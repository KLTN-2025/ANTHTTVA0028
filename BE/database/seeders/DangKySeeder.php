<?php

namespace Database\Seeders;

use App\Models\DangKy;
use App\Models\LopHoc;
use App\Models\NguoiDung;
use Illuminate\Database\Seeder;

class DangKySeeder extends Seeder
{
    public function run(): void
    {
        $student = NguoiDung::where('email', 'hocvien@agoralearn.com')->first();
        $classes = LopHoc::all();

        if ($student) {
            foreach ($classes as $class) {
                DangKy::create([
                    'lop_hoc_id' => $class->id,
                    'hoc_vien_id' => $student->id,
                    'ngay_dang_ky' => now(),
                    'trang_thai' => 'dang_ky',
                ]);
            }
        }
    }
}
