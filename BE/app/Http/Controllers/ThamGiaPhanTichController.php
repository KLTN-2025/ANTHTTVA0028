<?php

namespace App\Http\Controllers;

use App\Models\ThamGiaPhanTich;
use Illuminate\Http\Request;

class ThamGiaPhanTichController extends Controller
{
    public function index(Request $request)
    {
        $query = ThamGiaPhanTich::query();

        if ($request->filled('hoc_vien_id')) {
            $query->where('hoc_vien_id', $request->hoc_vien_id);
        }

        if ($request->filled('lop_hoc_id')) {
            $query->where('lop_hoc_id', $request->lop_hoc_id);
        }

        if ($request->filled('bai_giang_id')) {
            $query->where('bai_giang_id', $request->bai_giang_id);
        }

        $phanTichs = $query->with(['hocVien', 'lopHoc', 'baiGiang', 'lichHoc'])
            ->latest('cap_nhat_cuoi')
            ->paginate(20);

        return response()->json($phanTichs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hoc_vien_id' => 'required|exists:nguoi_dungs,id',
            'lop_hoc_id' => 'required|exists:lop_hocs,id',
            'bai_giang_id' => 'nullable|exists:bai_giangs,id',
            'lich_hoc_id' => 'nullable|exists:lich_hocs,id',
            'tong_thoi_gian_xem_giay' => 'nullable|integer|min:0',
            'so_su_kien_tuong_tac' => 'nullable|integer|min:0',
            'so_lan_quay_lai' => 'nullable|integer|min:0',
            'diem_tham_gia' => 'nullable|numeric|min:0|max:100',
            'chi_so_chu_y' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['cap_nhat_cuoi'] = now();

        $phanTich = ThamGiaPhanTich::create($validated);

        return response()->json([
            'message' => 'Phân tích đã được tạo',
            'data' => $phanTich
        ], 201);
    }

    public function show(ThamGiaPhanTich $thamGiaPhanTich)
    {
        $thamGiaPhanTich->load(['hocVien', 'lopHoc', 'baiGiang', 'lichHoc']);
        return response()->json($thamGiaPhanTich);
    }

    public function update(Request $request, ThamGiaPhanTich $thamGiaPhanTich)
    {
        $validated = $request->validate([
            'tong_thoi_gian_xem_giay' => 'nullable|integer|min:0',
            'so_su_kien_tuong_tac' => 'nullable|integer|min:0',
            'so_lan_quay_lai' => 'nullable|integer|min:0',
            'diem_tham_gia' => 'nullable|numeric|min:0|max:100',
            'chi_so_chu_y' => 'nullable|numeric|min:0|max:100',
        ]);

        $validated['cap_nhat_cuoi'] = now();

        $thamGiaPhanTich->update($validated);

        return response()->json([
            'message' => 'Phân tích đã được cập nhật',
            'data' => $thamGiaPhanTich
        ]);
    }

    public function destroy(ThamGiaPhanTich $thamGiaPhanTich)
    {
        $thamGiaPhanTich->delete();
        return response()->json(['message' => 'Phân tích đã được xóa']);
    }

    public function studentSummary($hocVienId, Request $request)
    {
        $query = ThamGiaPhanTich::where('hoc_vien_id', $hocVienId);

        if ($request->filled('lop_hoc_id')) {
            $query->where('lop_hoc_id', $request->lop_hoc_id);
        }

        $phanTichs = $query->get();

        $summary = [
            'tong_thoi_gian_hoc' => $phanTichs->sum('tong_thoi_gian_xem_giay'),
            'tong_su_kien_tuong_tac' => $phanTichs->sum('so_su_kien_tuong_tac'),
            'diem_tham_gia_trung_binh' => $phanTichs->avg('diem_tham_gia'),
            'chi_so_chu_y_trung_binh' => $phanTichs->avg('chi_so_chu_y'),
            'so_bai_da_xem' => $phanTichs->count(),
        ];

        return response()->json([
            'summary' => $summary,
            'details' => $phanTichs
        ]);
    }

    public function classSummary($lopHocId)
    {
        $phanTichs = ThamGiaPhanTich::where('lop_hoc_id', $lopHocId)
            ->with('hocVien')
            ->get();

        $byStudent = $phanTichs->groupBy('hoc_vien_id')->map(function ($items) {
            return [
                'hoc_vien' => $items->first()->hocVien,
                'tong_thoi_gian' => $items->sum('tong_thoi_gian_xem_giay'),
                'diem_tham_gia_tb' => $items->avg('diem_tham_gia'),
                'chi_so_chu_y_tb' => $items->avg('chi_so_chu_y'),
            ];
        });

        return response()->json([
            'by_student' => $byStudent->values(),
            'class_average' => [
                'diem_tham_gia' => $phanTichs->avg('diem_tham_gia'),
                'chi_so_chu_y' => $phanTichs->avg('chi_so_chu_y'),
            ]
        ]);
    }
}
