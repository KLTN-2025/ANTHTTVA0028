<?php

namespace App\Http\Controllers;

use App\Models\CauHoi;
use Illuminate\Http\Request;

class CauHoiController extends Controller
{
    public function index(Request $request)
    {
        $query = CauHoi::query();

        if ($request->filled('bai_kiem_tra_id')) {
            $query->where('bai_kiem_tra_id', $request->bai_kiem_tra_id);
        }

        $cauHois = $query->with(['baiKiemTra', 'luaChons'])
            ->orderBy('thu_tu')
            ->paginate(50);

        return response()->json($cauHois);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bai_kiem_tra_id' => 'required|exists:bai_kiem_tras,id',
            'noi_dung' => 'required|string',
            'loai' => 'required|in:trac_nghiem,dung_sai,tu_luan',
            'thu_tu' => 'nullable|integer|min:1',
            'diem' => 'nullable|numeric|min:0',
            'lua_chons' => 'nullable|array',
            'lua_chons.*.noi_dung' => 'required|string',
            'lua_chons.*.la_dap_an' => 'required|boolean',
        ]);

        if (!isset($validated['thu_tu'])) {
            $maxThuTu = CauHoi::where('bai_kiem_tra_id', $validated['bai_kiem_tra_id'])->max('thu_tu');
            $validated['thu_tu'] = ($maxThuTu ?? 0) + 1;
        }

        $luaChons = $validated['lua_chons'] ?? [];
        unset($validated['lua_chons']);

        $cauHoi = CauHoi::create($validated);

        if (!empty($luaChons)) {
            foreach ($luaChons as $luaChon) {
                $cauHoi->luaChons()->create($luaChon);
            }
        }

        return response()->json([
            'message' => 'Câu hỏi đã được tạo',
            'data' => $cauHoi->load('luaChons')
        ], 201);
    }

    public function show(CauHoi $cauHoi)
    {
        $cauHoi->load(['baiKiemTra', 'luaChons']);
        return response()->json($cauHoi);
    }

    public function update(Request $request, CauHoi $cauHoi)
    {
        $validated = $request->validate([
            'noi_dung' => 'sometimes|required|string',
            'loai' => 'sometimes|required|in:trac_nghiem,dung_sai,tu_luan',
            'thu_tu' => 'nullable|integer|min:1',
            'diem' => 'nullable|numeric|min:0',
        ]);

        $cauHoi->update($validated);

        return response()->json([
            'message' => 'Câu hỏi đã được cập nhật',
            'data' => $cauHoi
        ]);
    }

    public function destroy(CauHoi $cauHoi)
    {
        $cauHoi->delete();
        return response()->json(['message' => 'Câu hỏi đã được xóa']);
    }
}
