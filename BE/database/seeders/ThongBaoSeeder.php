<?php

namespace Database\Seeders;

use App\Models\NguoiDung;
use App\Models\ThongBao;
use Illuminate\Database\Seeder;

class ThongBaoSeeder extends Seeder
{
    public function run(): void
    {
        $student = NguoiDung::where('email', 'hocvien@agoralearn.com')->first();

        if ($student) {
            ThongBao::create([
                'nguoi_nhan_id' => $student->id,
                'tieu_de' => 'Chào mừng đến với AgoraLearn',
                'noi_dung' => 'Chúc bạn có những trải nghiệm học tập tuyệt vời tại hệ thống.',
                'da_doc' => 0,
            ]);

            ThongBao::create([
                'nguoi_nhan_id' => $student->id,
                'tieu_de' => 'Nhắc nhở lịch học',
                'noi_dung' => 'Bạn có lịch học môn Lập trình Web vào ngày mai lúc 7:00.',
                'da_doc' => 0,
            ]);
        }
    }
}
