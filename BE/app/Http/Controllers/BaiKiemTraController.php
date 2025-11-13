<?php

namespace App\Http\Controllers;

use App\Models\BaiKiemTra;
use Illuminate\Http\Request;

class BaiKiemTraController extends Controller
{
    public function index(Request $request)
    {
        $query = BaiKiemTra::query();

        if ($request->filled('bai_giang_id')) {
            $query->where('bai_giang_id', $request->bai_giang_id);
        }

        $baiKiemTras = $query->with(['baiGiang', 'cauHois'])
            ->latest()
            ->paginate(20);

        return response()->json($baiKiemTras);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bai_giang_id' => 'required|exists:bai_giangs,id',
            'tieu_de' => 'required|string|max:200',
            'mo_ta' => 'nullable|string',
            'thoi_luong_giay' => 'nullable|integer|min:0',
            'so_lan_lam' => 'nullable|integer|min:1',
            'chinh_sach_cham' => 'nullable|in:diem_cao_nhat,lan_cuoi',
        ]);

        $baiKiemTra = BaiKiemTra::create($validated);

        return response()->json([
            'message' => 'Bài kiểm tra đã được tạo',
            'data' => $baiKiemTra
        ], 201);
    }

    public function show(BaiKiemTra $baiKiemTra)
    {
        $baiKiemTra->load(['baiGiang', 'cauHois.luaChons', 'baiLams']);
        return response()->json($baiKiemTra);
    }

    public function update(Request $request, BaiKiemTra $baiKiemTra)
    {
        $validated = $request->validate([
            'tieu_de' => 'sometimes|required|string|max:200',
            'mo_ta' => 'nullable|string',
            'thoi_luong_giay' => 'nullable|integer|min:0',
            'so_lan_lam' => 'nullable|integer|min:1',
            'chinh_sach_cham' => 'nullable|in:diem_cao_nhat,lan_cuoi',
        ]);

        $baiKiemTra->update($validated);

        return response()->json([
            'message' => 'Bài kiểm tra đã được cập nhật',
            'data' => $baiKiemTra
        ]);
    }

    public function destroy(BaiKiemTra $baiKiemTra)
    {
        $baiKiemTra->delete();
        return response()->json(['message' => 'Bài kiểm tra đã được xóa']);
    }

    public function results(BaiKiemTra $baiKiemTra)
    {
        $baiLams = $baiKiemTra->baiLams()->with('hocVien')->get();

        $stats = [
            'total_attempts' => $baiLams->count(),
            'total_students' => $baiLams->unique('hoc_vien_id')->count(),
            'completed' => $baiLams->where('trang_thai', 'nop')->count(),
            'in_progress' => $baiLams->where('trang_thai', 'dang_lam')->count(),
            'average_score' => $baiLams->where('trang_thai', 'nop')->avg('diem_tong'),
            'highest_score' => $baiLams->where('trang_thai', 'nop')->max('diem_tong'),
            'lowest_score' => $baiLams->where('trang_thai', 'nop')->min('diem_tong'),
        ];

        return response()->json([
            'statistics' => $stats,
            'attempts' => $baiLams
        ]);
    }
}
