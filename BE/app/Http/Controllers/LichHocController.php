<?php

namespace App\Http\Controllers;

use App\Models\LichHoc;
use Illuminate\Http\Request;

class LichHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LichHoc::query();

        // Filter by class
        if ($request->filled('lop_hoc_id')) {
            $query->where('lop_hoc_id', $request->lop_hoc_id);
        }

        // Filter by lesson
        if ($request->filled('bai_giang_id')) {
            $query->where('bai_giang_id', $request->bai_giang_id);
        }

        // Filter by format
        if ($request->filled('hinh_thuc')) {
            $query->where('hinh_thuc', $request->hinh_thuc);
        }

        // Filter by date range
        if ($request->filled('tu_ngay')) {
            $query->where('thoi_gian_bat_dau', '>=', $request->tu_ngay);
        }
        if ($request->filled('den_ngay')) {
            $query->where('thoi_gian_bat_dau', '<=', $request->den_ngay);
        }

        $lichHocs = $query->with(['lopHoc', 'baiGiang'])
            ->orderBy('thoi_gian_bat_dau')
            ->paginate(20);

        return response()->json($lichHocs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lop_hoc_id' => 'required|exists:lop_hocs,id',
            'bai_giang_id' => 'nullable|exists:bai_giangs,id',
            'thoi_gian_bat_dau' => 'required|date',
            'thoi_gian_ket_thuc' => 'required|date|after:thoi_gian_bat_dau',
            'hinh_thuc' => 'nullable|in:online,offline,hybrid',
            'phong_hoc' => 'nullable|string|max:120',
            'ghi_chu' => 'nullable|string|max:255',
        ]);

        $lichHoc = LichHoc::create($validated);

        return response()->json([
            'message' => 'Lịch học đã được tạo thành công',
            'data' => $lichHoc->load(['lopHoc', 'baiGiang'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LichHoc $lichHoc)
    {
        $lichHoc->load([
            'lopHoc.khoaHoc',
            'baiGiang',
            'diemDanhs.hocVien'
        ]);

        return response()->json($lichHoc);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LichHoc $lichHoc)
    {
        $validated = $request->validate([
            'bai_giang_id' => 'nullable|exists:bai_giangs,id',
            'thoi_gian_bat_dau' => 'sometimes|required|date',
            'thoi_gian_ket_thuc' => 'sometimes|required|date|after:thoi_gian_bat_dau',
            'hinh_thuc' => 'nullable|in:online,offline,hybrid',
            'phong_hoc' => 'nullable|string|max:120',
            'ghi_chu' => 'nullable|string|max:255',
        ]);

        $lichHoc->update($validated);

        return response()->json([
            'message' => 'Lịch học đã được cập nhật',
            'data' => $lichHoc
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LichHoc $lichHoc)
    {
        $lichHoc->delete();

        return response()->json([
            'message' => 'Lịch học đã được xóa'
        ]);
    }

    /**
     * Get attendance for a specific schedule
     */
    public function attendance(LichHoc $lichHoc)
    {
        $diemDanhs = $lichHoc->diemDanhs()->with('hocVien')->get();

        $stats = [
            'total' => $diemDanhs->count(),
            'co_mat' => $diemDanhs->where('trang_thai', 'co_mat')->count(),
            'vang' => $diemDanhs->where('trang_thai', 'vang')->count(),
            'tre' => $diemDanhs->where('trang_thai', 'tre')->count(),
            'danh_sach' => $diemDanhs,
        ];

        return response()->json($stats);
    }
}
