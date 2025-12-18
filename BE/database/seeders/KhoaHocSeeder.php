<?php

namespace Database\Seeders;

use App\Models\KhoaHoc;
use Illuminate\Database\Seeder;

class KhoaHocSeeder extends Seeder
{
    public function run(): void
    {
        KhoaHoc::create([
            'tieu_de' => 'Lập trình Web Cơ bản',
            'mo_ta' => 'Nhập môn HTML, CSS và JavaScript',
            'cap_do' => 'co_ban',
            'hinh_thuc' => 'tu_hoc',
            'so_gio' => 30,
            'cong_khai' => 1,
        ]);

        KhoaHoc::create([
            'tieu_de' => 'Lập trình Web Nâng cao',
            'mo_ta' => 'Phát triển ứng dụng web với Laravel và React',
            'cap_do' => 'nang_cao',
            'hinh_thuc' => 'blended',
            'so_gio' => 45,
            'cong_khai' => 1,
        ]);

        KhoaHoc::create([
            'tieu_de' => 'Trí tuệ nhân tạo cơ bản',
            'mo_ta' => 'Khái niệm cơ bản về AI và Machine Learning',
            'cap_do' => 'trung_binh',
            'hinh_thuc' => 'live',
            'so_gio' => 40,
            'cong_khai' => 1,
        ]);
    }
}
