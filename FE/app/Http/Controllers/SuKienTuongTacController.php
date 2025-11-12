<?php

namespace App\Http\Controllers;

use App\Models\SuKienTuongTac;
use Illuminate\Http\Request;

class SuKienTuongTacController extends Controller
{
    public function index(Request $request)
    {
        $query = SuKienTuongTac::query();

        if ($request->filled('phien_hoc_id')) {
            $query->where('phien_hoc_id', $request->phien_hoc_id);
        }

        if ($request->filled('loai_su_kien')) {
            $query->where('loai_su_kien', $request->loai_su_kien);
        }

        $suKiens = $query->with('phienHoc')
            ->orderBy('thoi_diem')
            ->paginate(50);

        return response()->json($suKiens);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phien_hoc_id' => 'required|exists:phien_hocs,id',
            'thoi_diem' => 'required|date',
            'loai_su_kien' => 'required|in:play,pause,seek,hoan_thanh,click,chat,reaction,quiz_tra_loi,mo_tai_lieu,scroll',
            'gia_tri' => 'nullable|string|max:255',
            'thoi_gian_tren_man_hinh_ms' => 'nullable|integer|min:0',
        ]);

        $suKien = SuKienTuongTac::create($validated);

        return response()->json([
            'message' => 'Sự kiện đã được ghi nhận',
            'data' => $suKien
        ], 201);
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'phien_hoc_id' => 'required|exists:phien_hocs,id',
            'events' => 'required|array',
            'events.*.thoi_diem' => 'required|date',
            'events.*.loai_su_kien' => 'required|in:play,pause,seek,hoan_thanh,click,chat,reaction,quiz_tra_loi,mo_tai_lieu,scroll',
            'events.*.gia_tri' => 'nullable|string|max:255',
            'events.*.thoi_gian_tren_man_hinh_ms' => 'nullable|integer|min:0',
        ]);

        $suKiens = [];
        foreach ($validated['events'] as $event) {
            $event['phien_hoc_id'] = $validated['phien_hoc_id'];
            $suKiens[] = SuKienTuongTac::create($event);
        }

        return response()->json([
            'message' => 'Đã ghi nhận ' . count($suKiens) . ' sự kiện',
            'data' => $suKiens
        ], 201);
    }

    public function show(SuKienTuongTac $suKienTuongTac)
    {
        $suKienTuongTac->load('phienHoc');
        return response()->json($suKienTuongTac);
    }

    public function destroy(SuKienTuongTac $suKienTuongTac)
    {
        $suKienTuongTac->delete();
        return response()->json(['message' => 'Sự kiện đã được xóa']);
    }

    public function sessionAnalytics($phienHocId)
    {
        $suKiens = SuKienTuongTac::where('phien_hoc_id', $phienHocId)->get();

        $analytics = [
            'total_events' => $suKiens->count(),
            'by_type' => $suKiens->groupBy('loai_su_kien')->map->count(),
            'total_screen_time_ms' => $suKiens->sum('thoi_gian_tren_man_hinh_ms'),
            'timeline' => $suKiens->sortBy('thoi_diem')->values(),
        ];

        return response()->json($analytics);
    }
}
