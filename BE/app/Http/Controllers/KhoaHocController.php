<?php

namespace App\Http\Controllers;

use App\Models\KhoaHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KhoaHocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KhoaHoc::query();

        // Filter by level
        if ($request->filled('cap_do')) {
            $query->where('cap_do', $request->cap_do);
        }

        // Filter by type
        if ($request->filled('hinh_thuc')) {
            $query->where('hinh_thuc', $request->hinh_thuc);
        }

        // Filter public/private
        if ($request->filled('cong_khai')) {
            $query->where('cong_khai', $request->cong_khai);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('tieu_de', 'like', '%' . $request->search . '%');
        }

        $khoaHocs = $query->with(['lopHocs', 'baiGiangs'])
            ->latest()
            ->paginate(15);

        return response()->json($khoaHocs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tieu_de' => 'required|string|max:200',
            'mo_ta' => 'nullable|string',
            'cap_do' => 'nullable|in:co_ban,trung_binh,nang_cao',
            'hinh_thuc' => 'nullable|in:tu_hoc,live,blended',
            'so_gio' => 'nullable|integer|min:0',
            'anh_bia' => 'nullable|image|max:2048',
            'cong_khai' => 'nullable|boolean',
        ]);

        if ($request->hasFile('anh_bia')) {
            $validated['anh_bia'] = $request->file('anh_bia')->store('khoa-hoc', 'public');
        }

        $khoaHoc = KhoaHoc::create($validated);

        return response()->json([
            'message' => 'Khóa học đã được tạo thành công',
            'data' => $khoaHoc
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(KhoaHoc $khoaHoc)
    {
        $khoaHoc->load(['lopHocs', 'baiGiangs', 'taiLieus']);

        return response()->json($khoaHoc);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KhoaHoc $khoaHoc)
    {
        $validated = $request->validate([
            'tieu_de' => 'sometimes|required|string|max:200',
            'mo_ta' => 'nullable|string',
            'cap_do' => 'nullable|in:co_ban,trung_binh,nang_cao',
            'hinh_thuc' => 'nullable|in:tu_hoc,live,blended',
            'so_gio' => 'nullable|integer|min:0',
            'anh_bia' => 'nullable|image|max:2048',
            'cong_khai' => 'nullable|boolean',
        ]);

        if ($request->hasFile('anh_bia')) {
            // Delete old image
            if ($khoaHoc->anh_bia) {
                Storage::disk('public')->delete($khoaHoc->anh_bia);
            }
            $validated['anh_bia'] = $request->file('anh_bia')->store('khoa-hoc', 'public');
        }

        $khoaHoc->update($validated);

        return response()->json([
            'message' => 'Khóa học đã được cập nhật',
            'data' => $khoaHoc
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KhoaHoc $khoaHoc)
    {
        if ($khoaHoc->anh_bia) {
            Storage::disk('public')->delete($khoaHoc->anh_bia);
        }

        $khoaHoc->delete();

        return response()->json([
            'message' => 'Khóa học đã được xóa'
        ]);
    }

    /**
     * Get courses statistics
     */
    public function statistics()
    {
        $stats = [
            'total' => KhoaHoc::count(),
            'by_level' => KhoaHoc::selectRaw('cap_do, COUNT(*) as count')
                ->groupBy('cap_do')
                ->get(),
            'by_type' => KhoaHoc::selectRaw('hinh_thuc, COUNT(*) as count')
                ->groupBy('hinh_thuc')
                ->get(),
            'public' => KhoaHoc::where('cong_khai', 1)->count(),
            'private' => KhoaHoc::where('cong_khai', 0)->count(),
        ];

        return response()->json($stats);
    }
}
