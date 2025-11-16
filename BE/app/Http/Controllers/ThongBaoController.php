<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;
use Illuminate\Http\Request;

class ThongBaoController extends Controller
{
    public function index(Request $request)
    {
        $query = ThongBao::query();

        if ($request->filled('nguoi_nhan_id')) {
            $query->where('nguoi_nhan_id', $request->nguoi_nhan_id);
        }

        if ($request->filled('da_doc')) {
            $query->where('da_doc', $request->da_doc);
        }

        $thongBaos = $query->with('nguoiNhan')
            ->latest()
            ->paginate(20);

        return response()->json($thongBaos);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nguoi_nhan_id' => 'required|exists:nguoi_dungs,id',
            'tieu_de' => 'required|string|max:200',
            'noi_dung' => 'required|string',
        ]);

        $thongBao = ThongBao::create($validated);

        return response()->json([
            'message' => 'Thông báo đã được gửi',
            'data' => $thongBao
        ], 201);
    }

    public function show(ThongBao $thongBao)
    {
        $thongBao->load('nguoiNhan');
        return response()->json($thongBao);
    }

    public function markAsRead(ThongBao $thongBao)
    {
        $thongBao->update(['da_doc' => true]);

        return response()->json([
            'message' => 'Đã đánh dấu là đã đọc',
            'data' => $thongBao
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $validated = $request->validate([
            'nguoi_nhan_id' => 'required|exists:nguoi_dungs,id',
        ]);

        ThongBao::where('nguoi_nhan_id', $validated['nguoi_nhan_id'])
            ->where('da_doc', false)
            ->update(['da_doc' => true]);

        return response()->json([
            'message' => 'Đã đánh dấu tất cả là đã đọc'
        ]);
    }

    public function destroy(ThongBao $thongBao)
    {
        $thongBao->delete();
        return response()->json(['message' => 'Thông báo đã được xóa']);
    }

    public function unreadCount(Request $request, $nguoiDungId)
    {
        $count = ThongBao::where('nguoi_nhan_id', $nguoiDungId)
            ->where('da_doc', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
