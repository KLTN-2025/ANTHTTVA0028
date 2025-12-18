<?php

namespace Database\Seeders;

use App\Models\GiangVien;
use App\Models\KhoaHoc;
use App\Models\LopHoc;
use Illuminate\Database\Seeder;

class LopHocSeeder extends Seeder
{
    public function run(): void
    {
        $giangVien1 = GiangVien::first(); // giangvien@agoralearn.com
        $webBasic = KhoaHoc::where('tieu_de', 'Lập trình Web Cơ bản')->first();
        $webAdvanced = KhoaHoc::where('tieu_de', 'Lập trình Web Nâng cao')->first();

        if ($giangVien1 && $webBasic) {
            LopHoc::create([
                'khoa_hoc_id' => $webBasic->id,
                'giang_vien_id' => $giangVien1->id,
                'ten_lop' => 'CNTT-K15-01',
                'ngay_bat_dau' => '2025-09-01',
                'ngay_ket_thuc' => '2025-12-30',
                'trang_thai' => 'dang_hoc',
            ]);
        }

        if ($giangVien1 && $webAdvanced) {
            LopHoc::create([
                'khoa_hoc_id' => $webAdvanced->id,
                'giang_vien_id' => $giangVien1->id,
                'ten_lop' => 'CNTT-K15-02',
                'ngay_bat_dau' => '2025-09-01',
                'ngay_ket_thuc' => '2025-12-30',
                'trang_thai' => 'dang_hoc',
            ]);
        }
    }
}
