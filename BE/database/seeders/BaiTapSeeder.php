<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BaiTap;
use App\Models\BaiGiang;
use Carbon\Carbon;

class BaiTapSeeder extends Seeder
{
    public function run(): void
    {
        // Get all lectures that are of type 'bai_tap'
        $assignmentLectures = BaiGiang::where('loai_noi_dung', 'bai_tap')->get();

        foreach ($assignmentLectures as $lecture) {
            BaiTap::create([
                'bai_giang_id' => $lecture->id,
                'tieu_de' => 'Bài tập: ' . $lecture->tieu_de,
                'mo_ta' => 'Hoàn thành các yêu cầu trong tài liệu đính kèm và nộp bài trước hạn.',
                'han_nop' => Carbon::now()->addDays(rand(3, 14)), // Due in 3-14 days
                'diem_toi_da' => 10.00,
            ]);
        }
    }
}
