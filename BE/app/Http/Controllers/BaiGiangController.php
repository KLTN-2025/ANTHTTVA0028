<?php

namespace App\Http\Controllers;

use App\Models\BaiGiang;
use App\Models\KhoaHoc;
use Illuminate\Http\Request;

class BaiGiangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BaiGiang::query();

        // Filter by course
        if ($request->filled('khoa_hoc_id')) {
            $query->where('khoa_hoc_id', $request->khoa_hoc_id);
        }

        // Filter by content type
        if ($request->filled('loai_noi_dung')) {
            $query->where('loai_noi_dung', $request->loai_noi_dung);
        }

        $baiGiangs = $query->with('khoaHoc')
            ->orderBy('thu_tu')
            ->paginate(20);

        return response()->json($baiGiangs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'khoa_hoc_id' => 'required|exists:khoa_hocs,id',
            'tieu_de' => 'required|string|max:200',
            'mo_ta' => 'nullable|string',
            'loai_noi_dung' => 'required|in:video,live,tai_lieu,bai_tap,quiz',
            'url_noi_dung' => 'nullable|string|max:500',
            'thu_tu' => 'nullable|integer|min:1',
            'thoi_luong_giay' => 'nullable|integer|min:0',
        ]);

        // Auto-increment thu_tu if not provided
        if (!isset($validated['thu_tu'])) {
            $maxThuTu = BaiGiang::where('khoa_hoc_id', $validated['khoa_hoc_id'])->max('thu_tu');
            $validated['thu_tu'] = ($maxThuTu ?? 0) + 1;
        }

        $baiGiang = BaiGiang::create($validated);

        return response()->json([
            'message' => 'Bài giảng đã được tạo thành công',
            'data' => $baiGiang->load('khoaHoc')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BaiGiang $baiGiang)
    {
        $baiGiang->load(['khoaHoc', 'taiLieus', 'baiTaps', 'baiKiemTras']);

        return response()->json($baiGiang);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BaiGiang $baiGiang)
    {
        $validated = $request->validate([
            'tieu_de' => 'sometimes|required|string|max:200',
            'mo_ta' => 'nullable|string',
            'loai_noi_dung' => 'sometimes|required|in:video,live,tai_lieu,bai_tap,quiz',
            'url_noi_dung' => 'nullable|string|max:500',
            'thu_tu' => 'nullable|integer|min:1',
            'thoi_luong_giay' => 'nullable|integer|min:0',
        ]);

        $baiGiang->update($validated);

        return response()->json([
            'message' => 'Bài giảng đã được cập nhật',
            'data' => $baiGiang
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BaiGiang $baiGiang)
    {
        $baiGiang->delete();

        return response()->json([
            'message' => 'Bài giảng đã được xóa'
        ]);
    }

    /**
     * Reorder lessons
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'khoa_hoc_id' => 'required|exists:khoa_hocs,id',
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:bai_giangs,id',
            'orders.*.thu_tu' => 'required|integer|min:1',
        ]);

        foreach ($validated['orders'] as $order) {
            BaiGiang::where('id', $order['id'])
                ->where('khoa_hoc_id', $validated['khoa_hoc_id'])
                ->update(['thu_tu' => $order['thu_tu']]);
        }

        return response()->json([
            'message' => 'Thứ tự bài giảng đã được cập nhật'
        ]);
    }
}
