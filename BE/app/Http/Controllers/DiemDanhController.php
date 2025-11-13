<?php

namespace App\Http\Controllers;

use App\Models\DiemDanh;
use App\Models\LichHoc;
use Illuminate\Http\Request;

class DiemDanhController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DiemDanh::query();

        // Filter by schedule
        if ($request->filled('lich_hoc_id')) {
            $query->where('lich_hoc_id', $request->lich_hoc_id);
        }

        // Filter by student
        if ($request->filled('hoc_vien_id')) {
            $query->where('hoc_vien_id', $request->hoc_vien_id);
        }

        // Filter by status
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        // Filter by method
        if ($request->filled('phuong_thuc')) {
            $query->where('phuong_thuc', $request->phuong_thuc);
        }

        $diemDanhs = $query->with(['lichHoc', 'hocVien', 'nhanDiens'])
            ->latest()
            ->paginate(20);

        return response()->json($diemDanhs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lich_hoc_id' => 'required|exists:lich_hocs,id',
            'hoc_vien_id' => 'required|exists:nguoi_dungs,id',
            'trang_thai' => 'required|in:co_mat,vang,tre',
            'phuong_thuc' => 'required|in:ai,thu_cong,qr',
            'thoi_diem_vao' => 'nullable|date',
            'thoi_diem_ra' => 'nullable|date|after:thoi_diem_vao',
            'do_tin_cay' => 'nullable|numeric|min:0|max:100',
            'ghi_chu' => 'nullable|string|max:255',
        ]);

        // Check if already marked
        $existing = DiemDanh::where('lich_hoc_id', $validated['lich_hoc_id'])
            ->where('hoc_vien_id', $validated['hoc_vien_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Học viên đã được điểm danh',
                'data' => $existing
            ], 409);
        }

        $diemDanh = DiemDanh::create($validated);

        return response()->json([
            'message' => 'Điểm danh thành công',
            'data' => $diemDanh->load(['lichHoc', 'hocVien'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DiemDanh $diemDanh)
    {
        $diemDanh->load(['lichHoc.lopHoc', 'hocVien', 'nhanDiens']);

        return response()->json($diemDanh);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiemDanh $diemDanh)
    {
        $validated = $request->validate([
            'trang_thai' => 'sometimes|required|in:co_mat,vang,tre',
            'thoi_diem_vao' => 'nullable|date',
            'thoi_diem_ra' => 'nullable|date|after:thoi_diem_vao',
            'do_tin_cay' => 'nullable|numeric|min:0|max:100',
            'ghi_chu' => 'nullable|string|max:255',
        ]);

        $diemDanh->update($validated);

        return response()->json([
            'message' => 'Điểm danh đã được cập nhật',
            'data' => $diemDanh
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiemDanh $diemDanh)
    {
        $diemDanh->delete();

        return response()->json([
            'message' => 'Điểm danh đã được xóa'
        ]);
    }

    /**
     * Bulk attendance marking
     */
    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'lich_hoc_id' => 'required|exists:lich_hocs,id',
            'attendances' => 'required|array',
            'attendances.*.hoc_vien_id' => 'required|exists:nguoi_dungs,id',
            'attendances.*.trang_thai' => 'required|in:co_mat,vang,tre',
            'attendances.*.phuong_thuc' => 'required|in:ai,thu_cong,qr',
            'attendances.*.thoi_diem_vao' => 'nullable|date',
            'attendances.*.ghi_chu' => 'nullable|string|max:255',
        ]);

        $results = [];
        foreach ($validated['attendances'] as $attendance) {
            $attendance['lich_hoc_id'] = $validated['lich_hoc_id'];

            $diemDanh = DiemDanh::updateOrCreate(
                [
                    'lich_hoc_id' => $attendance['lich_hoc_id'],
                    'hoc_vien_id' => $attendance['hoc_vien_id'],
                ],
                $attendance
            );

            $results[] = $diemDanh;
        }

        return response()->json([
            'message' => 'Điểm danh hàng loạt thành công',
            'data' => $results
        ], 201);
    }

    /**
     * Get attendance report for a student
     */
    public function studentReport(Request $request, $hocVienId)
    {
        $query = DiemDanh::where('hoc_vien_id', $hocVienId);

        if ($request->filled('lop_hoc_id')) {
            $query->whereHas('lichHoc', function ($q) use ($request) {
                $q->where('lop_hoc_id', $request->lop_hoc_id);
            });
        }

        $diemDanhs = $query->with('lichHoc')->get();

        $stats = [
            'total' => $diemDanhs->count(),
            'co_mat' => $diemDanhs->where('trang_thai', 'co_mat')->count(),
            'vang' => $diemDanhs->where('trang_thai', 'vang')->count(),
            'tre' => $diemDanhs->where('trang_thai', 'tre')->count(),
            'attendance_rate' => $diemDanhs->count() > 0
                ? round(($diemDanhs->where('trang_thai', 'co_mat')->count() / $diemDanhs->count()) * 100, 2)
                : 0,
        ];

        return response()->json([
            'statistics' => $stats,
            'details' => $diemDanhs
        ]);
    }
}
