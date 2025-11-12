<?php

namespace App\Http\Controllers;

use App\Models\BaiTap;
use Illuminate\Http\Request;

class BaiTapController extends Controller
{
    public function index(Request $request)
    {
        $query = BaiTap::query();

        if ($request->filled('bai_giang_id')) {
            $query->where('bai_giang_id', $request->bai_giang_id);
        }

        $baiTaps = $query->with(['baiGiang', 'nopBaiTaps'])
            ->latest()
            ->paginate(20);

        return response()->json($baiTaps);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bai_giang_id' => 'required|exists:bai_giangs,id',
            'tieu_de' => 'required|string|max:200',
            'mo_ta' => 'nullable|string',
            'han_nop' => 'nullable|date',
            'diem_toi_da' => 'nullable|numeric|min:0',
        ]);

        $baiTap = BaiTap::create($validated);

        return response()->json([
            'message' => 'Bài tập đã được tạo',
            'data' => $baiTap
        ], 201);
    }

    public function show(BaiTap $baiTap)
    {
        $baiTap->load(['baiGiang', 'nopBaiTaps.hocVien']);
        return response()->json($baiTap);
    }

    public function update(Request $request, BaiTap $baiTap)
    {
        $validated = $request->validate([
            'tieu_de' => 'sometimes|required|string|max:200',
            'mo_ta' => 'nullable|string',
            'han_nop' => 'nullable|date',
            'diem_toi_da' => 'nullable|numeric|min:0',
        ]);

        $baiTap->update($validated);

        return response()->json([
            'message' => 'Bài tập đã được cập nhật',
            'data' => $baiTap
        ]);
    }

    public function destroy(BaiTap $baiTap)
    {
        $baiTap->delete();
        return response()->json(['message' => 'Bài tập đã được xóa']);
    }

    public function submissions(BaiTap $baiTap)
    {
        $submissions = $baiTap->nopBaiTaps()->with('hocVien')->get();

        $stats = [
            'total' => $submissions->count(),
            'graded' => $submissions->whereNotNull('diem_so')->count(),
            'pending' => $submissions->whereNull('diem_so')->count(),
            'average_score' => $submissions->whereNotNull('diem_so')->avg('diem_so'),
        ];

        return response()->json([
            'statistics' => $stats,
            'submissions' => $submissions
        ]);
    }
}
