<?php

namespace App\Http\Controllers;

use App\Models\NopBaiTap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NopBaiTapController extends Controller
{
    public function index(Request $request)
    {
        $query = NopBaiTap::query();

        if ($request->filled('bai_tap_id')) {
            $query->where('bai_tap_id', $request->bai_tap_id);
        }

        if ($request->filled('hoc_vien_id')) {
            $query->where('hoc_vien_id', $request->hoc_vien_id);
        }

        $nopBais = $query->with(['baiTap', 'hocVien'])
            ->latest()
            ->paginate(20);

        return response()->json($nopBais);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bai_tap_id' => 'required|exists:bai_taps,id',
            'hoc_vien_id' => 'required|exists:nguoi_dungs,id',
            'file' => 'nullable|file|max:10240',
            'url_bai_nop' => 'nullable|string|max:500',
        ]);

        $existing = NopBaiTap::where('bai_tap_id', $validated['bai_tap_id'])
            ->where('hoc_vien_id', $validated['hoc_vien_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Bài tập đã được nộp trước đó',
                'data' => $existing
            ], 409);
        }

        if ($request->hasFile('file')) {
            $validated['url_bai_nop'] = $request->file('file')->store('bai-tap', 'public');
        }

        $validated['thoi_gian_nop'] = now();

        $nopBai = NopBaiTap::create($validated);

        return response()->json([
            'message' => 'Nộp bài thành công',
            'data' => $nopBai
        ], 201);
    }

    public function show(NopBaiTap $nopBaiTap)
    {
        $nopBaiTap->load(['baiTap', 'hocVien']);
        return response()->json($nopBaiTap);
    }

    public function update(Request $request, NopBaiTap $nopBaiTap)
    {
        $validated = $request->validate([
            'file' => 'nullable|file|max:10240',
            'url_bai_nop' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('file')) {
            if ($nopBaiTap->url_bai_nop) {
                Storage::disk('public')->delete($nopBaiTap->url_bai_nop);
            }
            $validated['url_bai_nop'] = $request->file('file')->store('bai-tap', 'public');
        }

        $validated['thoi_gian_nop'] = now();

        $nopBaiTap->update($validated);

        return response()->json([
            'message' => 'Bài nộp đã được cập nhật',
            'data' => $nopBaiTap
        ]);
    }

    public function grade(Request $request, NopBaiTap $nopBaiTap)
    {
        $validated = $request->validate([
            'diem_so' => 'required|numeric|min:0',
            'nhan_xet' => 'nullable|string',
        ]);

        $nopBaiTap->update($validated);

        return response()->json([
            'message' => 'Đã chấm điểm',
            'data' => $nopBaiTap
        ]);
    }

    public function destroy(NopBaiTap $nopBaiTap)
    {
        if ($nopBaiTap->url_bai_nop) {
            Storage::disk('public')->delete($nopBaiTap->url_bai_nop);
        }

        $nopBaiTap->delete();
        return response()->json(['message' => 'Bài nộp đã được xóa']);
    }
}
