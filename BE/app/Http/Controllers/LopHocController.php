<?php

namespace App\Http\Controllers;

use App\Models\LopHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LopHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LopHoc::query();

        // Filter by course
        if ($request->filled('khoa_hoc_id')) {
            $query->where('khoa_hoc_id', $request->khoa_hoc_id);
        }

        // Filter by instructor
        if ($request->filled('giang_vien_id')) {
            $query->where('giang_vien_id', $request->giang_vien_id);
        }

        // Filter by status
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $lopHocs = $query->with(['khoaHoc', 'giangVien', 'dangKys'])
            ->latest()
            ->paginate(15);

        return response()->json($lopHocs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'khoa_hoc_id' => 'required|exists:khoa_hocs,id',
            'giang_vien_id' => 'required|exists:nguoi_dungs,id',
            'ten_lop' => 'required|string|max:200',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_ket_thuc' => 'nullable|date|after:ngay_bat_dau',
            'trang_thai' => 'nullable|in:len_ke_hoach,dang_hoc,ket_thuc',
        ]);

        $lopHoc = LopHoc::create($validated);

        return response()->json([
            'message' => 'Lớp học đã được tạo thành công',
            'data' => $lopHoc->load(['khoaHoc', 'giangVien'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(LopHoc $lopHoc)
    {
        $lopHoc->load([
            'khoaHoc',
            'giangVien',
            'lichHocs',
            'dangKys.hocVien',
            'thamGiaPhanTichs'
        ]);

        // Count students
        $lopHoc->so_hoc_vien = $lopHoc->dangKys()->where('trang_thai', 'dang_ky')->count();

        return response()->json($lopHoc);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LopHoc $lopHoc)
    {
        $validated = $request->validate([
            'ten_lop' => 'sometimes|required|string|max:200',
            'ngay_bat_dau' => 'nullable|date',
            'ngay_ket_thuc' => 'nullable|date|after:ngay_bat_dau',
            'trang_thai' => 'nullable|in:len_ke_hoach,dang_hoc,ket_thuc',
        ]);

        $lopHoc->update($validated);

        return response()->json([
            'message' => 'Lớp học đã được cập nhật',
            'data' => $lopHoc
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LopHoc $lopHoc)
    {
        $lopHoc->delete();

        return response()->json([
            'message' => 'Lớp học đã được xóa'
        ]);
    }

    /**
     * Get class statistics
     */
    public function statistics(LopHoc $lopHoc)
    {
        $stats = [
            'total_students' => $lopHoc->dangKys()->where('trang_thai', 'dang_ky')->count(),
            'total_sessions' => $lopHoc->lichHocs()->count(),
            'completed_sessions' => $lopHoc->lichHocs()->where('thoi_gian_ket_thuc', '<', now())->count(),
            'attendance_rate' => $this->calculateAttendanceRate($lopHoc),
        ];

        return response()->json($stats);
    }

    /**
     * Calculate attendance rate
     */
    private function calculateAttendanceRate(LopHoc $lopHoc)
    {
        $totalSessions = $lopHoc->lichHocs()->count();
        if ($totalSessions === 0) return 0;

        $totalStudents = $lopHoc->dangKys()->where('trang_thai', 'dang_ky')->count();
        if ($totalStudents === 0) return 0;

        $totalPossibleAttendance = $totalSessions * $totalStudents;

        $actualAttendance = DB::table('diem_danhs')
            ->join('lich_hocs', 'diem_danhs.lich_hoc_id', '=', 'lich_hocs.id')
            ->where('lich_hocs.lop_hoc_id', $lopHoc->id)
            ->where('diem_danhs.trang_thai', 'co_mat')
            ->count();

        return round(($actualAttendance / $totalPossibleAttendance) * 100, 2);
    }
}
