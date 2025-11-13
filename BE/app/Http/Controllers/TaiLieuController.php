<?php

namespace App\Http\Controllers;

use App\Models\TaiLieu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaiLieuController extends Controller
{
    public function index(Request $request)
    {
        $query = TaiLieu::query();

        if ($request->filled('khoa_hoc_id')) {
            $query->where('khoa_hoc_id', $request->khoa_hoc_id);
        }

        if ($request->filled('bai_giang_id')) {
            $query->where('bai_giang_id', $request->bai_giang_id);
        }

        if ($request->filled('loai')) {
            $query->where('loai', $request->loai);
        }

        $taiLieus = $query->with(['khoaHoc', 'baiGiang'])
            ->latest()
            ->paginate(20);

        return response()->json($taiLieus);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'khoa_hoc_id' => 'nullable|exists:khoa_hocs,id',
            'bai_giang_id' => 'nullable|exists:bai_giangs,id',
            'tieu_de' => 'required|string|max:200',
            'loai' => 'required|in:pdf,slide,link,khac',
            'file' => 'nullable|file|max:20480',
            'url' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('file')) {
            $validated['url'] = $request->file('file')->store('tai-lieu', 'public');
        }

        $taiLieu = TaiLieu::create($validated);

        return response()->json([
            'message' => 'Tài liệu đã được tạo',
            'data' => $taiLieu
        ], 201);
    }

    public function show(TaiLieu $taiLieu)
    {
        $taiLieu->load(['khoaHoc', 'baiGiang']);
        return response()->json($taiLieu);
    }

    public function update(Request $request, TaiLieu $taiLieu)
    {
        $validated = $request->validate([
            'tieu_de' => 'sometimes|required|string|max:200',
            'loai' => 'sometimes|required|in:pdf,slide,link,khac',
            'file' => 'nullable|file|max:20480',
            'url' => 'nullable|string|max:500',
        ]);

        if ($request->hasFile('file')) {
            if ($taiLieu->url && !filter_var($taiLieu->url, FILTER_VALIDATE_URL)) {
                Storage::disk('public')->delete($taiLieu->url);
            }
            $validated['url'] = $request->file('file')->store('tai-lieu', 'public');
        }

        $taiLieu->update($validated);

        return response()->json([
            'message' => 'Tài liệu đã được cập nhật',
            'data' => $taiLieu
        ]);
    }

    public function destroy(TaiLieu $taiLieu)
    {
        if ($taiLieu->url && !filter_var($taiLieu->url, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete($taiLieu->url);
        }

        $taiLieu->delete();
        return response()->json(['message' => 'Tài liệu đã được xóa']);
    }
}
