<?php

namespace App\Http\Controllers;

use App\Models\BaiLam;
use App\Models\BaiKiemTra;
use Illuminate\Http\Request;

class BaiLamController extends Controller
{
    public function index(Request $request)
    {
        $query = BaiLam::query();

        if ($request->filled('bai_kiem_tra_id')) {
            $query->where('bai_kiem_tra_id', $request->bai_kiem_tra_id);
        }

        if ($request->filled('hoc_vien_id')) {
            $query->where('hoc_vien_id', $request->hoc_vien_id);
        }

        $baiLams = $query->with(['baiKiemTra', 'hocVien'])
            ->latest()
            ->paginate(20);

        return response()->json($baiLams);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bai_kiem_tra_id' => 'required|exists:bai_kiem_tras,id',
            'hoc_vien_id' => 'required|exists:nguoi_dungs,id',
        ]);

        $baiKiemTra = BaiKiemTra::findOrFail($validated['bai_kiem_tra_id']);

        // Check số lần làm
        $attemptCount = BaiLam::where('bai_kiem_tra_id', $validated['bai_kiem_tra_id'])
            ->where('hoc_vien_id', $validated['hoc_vien_id'])
            ->count();

        if ($attemptCount >= $baiKiemTra->so_lan_lam) {
            return response()->json([
                'message' => 'Đã hết số lần làm bài'
            ], 403);
        }

        $baiLam = BaiLam::create([
            'bai_kiem_tra_id' => $validated['bai_kiem_tra_id'],
            'hoc_vien_id' => $validated['hoc_vien_id'],
            'thoi_gian_bat_dau' => now(),
            'trang_thai' => 'dang_lam',
        ]);

        return response()->json([
            'message' => 'Bắt đầu làm bài',
            'data' => $baiLam->load('baiKiemTra.cauHois.luaChons')
        ], 201);
    }

    public function show(BaiLam $baiLam)
    {
        $baiLam->load(['baiKiemTra', 'hocVien', 'cauTraLois.cauHoi.luaChons', 'cauTraLois.luaChon']);
        return response()->json($baiLam);
    }

    public function submit(Request $request, BaiLam $baiLam)
    {
        if ($baiLam->trang_thai !== 'dang_lam') {
            return response()->json([
                'message' => 'Bài làm đã được nộp hoặc đã hết hạn'
            ], 400);
        }

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.cau_hoi_id' => 'required|exists:cau_hois,id',
            'answers.*.lua_chon_id' => 'nullable|exists:lua_chons,id',
            'answers.*.noi_dung_tu_luan' => 'nullable|string',
        ]);

        $tongDiem = 0;

        foreach ($validated['answers'] as $answer) {
            $cauHoi = \App\Models\CauHoi::find($answer['cau_hoi_id']);
            $dung = false;
            $diem = 0;

            if ($cauHoi->loai === 'trac_nghiem' && isset($answer['lua_chon_id'])) {
                $luaChon = \App\Models\LuaChon::find($answer['lua_chon_id']);
                if ($luaChon && $luaChon->la_dap_an) {
                    $dung = true;
                    $diem = $cauHoi->diem;
                    $tongDiem += $diem;
                }
            }

            $baiLam->cauTraLois()->create([
                'cau_hoi_id' => $answer['cau_hoi_id'],
                'lua_chon_id' => $answer['lua_chon_id'] ?? null,
                'noi_dung_tu_luan' => $answer['noi_dung_tu_luan'] ?? null,
                'dung' => $dung,
                'diem_so' => $diem,
            ]);
        }

        $baiLam->update([
            'thoi_gian_ket_thuc' => now(),
            'diem_tong' => $tongDiem,
            'trang_thai' => 'nop',
        ]);

        return response()->json([
            'message' => 'Nộp bài thành công',
            'data' => $baiLam->load('cauTraLois')
        ]);
    }

    public function destroy(BaiLam $baiLam)
    {
        $baiLam->delete();
        return response()->json(['message' => 'Bài làm đã được xóa']);
    }
}
