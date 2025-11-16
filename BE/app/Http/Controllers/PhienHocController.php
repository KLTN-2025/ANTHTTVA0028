<?php

namespace App\Http\Controllers;

use App\Models\PhienHoc;
use Illuminate\Http\Request;

class PhienHocController extends Controller
{
    public function index(Request $request)
    {
        $query = PhienHoc::query();

        if ($request->filled('nguoi_dung_id')) {
            $query->where('nguoi_dung_id', $request->nguoi_dung_id);
        }

        if ($request->filled('lop_hoc_id')) {
            $query->where('lop_hoc_id', $request->lop_hoc_id);
        }

        if ($request->filled('bai_giang_id')) {
            $query->where('bai_giang_id', $request->bai_giang_id);
        }

        if ($request->filled('nguon')) {
            $query->where('nguon', $request->nguon);
        }

        $phienHocs = $query->with(['nguoiDung', 'lopHoc', 'baiGiang', 'thietBi'])
            ->latest('thoi_gian_bat_dau')
            ->paginate(20);

        return response()->json($phienHocs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nguoi_dung_id' => 'required|exists:nguoi_dungs,id',
            'lop_hoc_id' => 'nullable|exists:lop_hocs,id',
            'bai_giang_id' => 'nullable|exists:bai_giangs,id',
            'thiet_bi_id' => 'nullable|exists:thiet_bis,id',
            'thoi_gian_bat_dau' => 'required|date',
            'dia_chi_ip' => 'nullable|string|max:45',
            'vi_tri' => 'nullable|string|max:190',
            'nguon' => 'nullable|in:web,mobile,desktop',
        ]);

        $phienHoc = PhienHoc::create($validated);

        return response()->json([
            'message' => 'Phiên học đã được tạo',
            'data' => $phienHoc
        ], 201);
    }

    public function show(PhienHoc $phienHoc)
    {
        $phienHoc->load(['nguoiDung', 'lopHoc', 'baiGiang', 'thietBi', 'suKienTuongTacs']);
        return response()->json($phienHoc);
    }

    public function end(Request $request, PhienHoc $phienHoc)
    {
        $phienHoc->update([
            'thoi_gian_ket_thuc' => now()
        ]);

        return response()->json([
            'message' => 'Phiên học đã kết thúc',
            'data' => $phienHoc
        ]);
    }

    public function destroy(PhienHoc $phienHoc)
    {
        $phienHoc->delete();
        return response()->json(['message' => 'Phiên học đã được xóa']);
    }

    public function statistics($nguoiDungId, Request $request)
    {
        $query = PhienHoc::where('nguoi_dung_id', $nguoiDungId);

        if ($request->filled('from_date')) {
            $query->where('thoi_gian_bat_dau', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('thoi_gian_bat_dau', '<=', $request->to_date);
        }

        $phienHocs = $query->get();

        $stats = [
            'total_sessions' => $phienHocs->count(),
            'by_source' => $phienHocs->groupBy('nguon')->map->count(),
            'total_duration' => $phienHocs->sum(function ($phien) {
                if ($phien->thoi_gian_ket_thuc) {
                    return $phien->thoi_gian_ket_thuc->diffInSeconds($phien->thoi_gian_bat_dau);
                }
                return 0;
            }),
        ];

        return response()->json($stats);
    }
}
