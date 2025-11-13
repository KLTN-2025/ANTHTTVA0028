<?php

namespace App\Http\Controllers;

use App\Models\DangKy;
use Illuminate\Http\Request;

class DangKyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DangKy::query();

        // Filter by class
        if ($request->filled('lop_hoc_id')) {
            $query->where('lop_hoc_id', $request->lop_hoc_id);
        }

        // Filter by student
        if ($request->filled('hoc_vien_id')) {
            $query->where('hoc_vien_id', $request->hoc_vien_id);
        }

        // Filter by status
        if ($request->filled('trang_thai')) {
            $query->where('trang_thai', $request->trang_thai);
        }

        $dangKys = $query->with(['lopHoc.khoaHoc', 'hocVien'])
            ->latest()
            ->paginate(20);

        return response()->json($dangKys);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lop_hoc_id' => 'required|exists:lop_hocs,id',
            'hoc_vien_id' => 'required|exists:nguoi_dungs,id',
            'trang_thai' => 'nullable|in:dang_ky,huy,hoan_thanh',
        ]);

        // Check if already enrolled
        $existing = DangKy::where('lop_hoc_id', $validated['lop_hoc_id'])
            ->where('hoc_vien_id', $validated['hoc_vien_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Học viên đã đăng ký lớp học này',
                'data' => $existing
            ], 409);
        }

        $validated['ngay_dang_ky'] = now();
        $validated['trang_thai'] = $validated['trang_thai'] ?? 'dang_ky';

        $dangKy = DangKy::create($validated);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'data' => $dangKy->load(['lopHoc', 'hocVien'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DangKy $dangKy)
    {
        $dangKy->load(['lopHoc.khoaHoc', 'hocVien']);

        return response()->json($dangKy);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DangKy $dangKy)
    {
        $validated = $request->validate([
            'trang_thai' => 'required|in:dang_ky,huy,hoan_thanh',
        ]);

        $dangKy->update($validated);

        return response()->json([
            'message' => 'Trạng thái đăng ký đã được cập nhật',
            'data' => $dangKy
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DangKy $dangKy)
    {
        $dangKy->delete();

        return response()->json([
            'message' => 'Đăng ký đã được xóa'
        ]);
    }

    /**
     * Cancel enrollment
     */
    public function cancel(DangKy $dangKy)
    {
        $dangKy->update(['trang_thai' => 'huy']);

        return response()->json([
            'message' => 'Đã hủy đăng ký',
            'data' => $dangKy
        ]);
    }

    /**
     * Complete enrollment
     */
    public function complete(DangKy $dangKy)
    {
        $dangKy->update(['trang_thai' => 'hoan_thanh']);

        return response()->json([
            'message' => 'Đã hoàn thành khóa học',
            'data' => $dangKy
        ]);
    }
}
