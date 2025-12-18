<?php

namespace Database\Seeders;

use App\Models\BaiGiang;
use App\Models\KhoaHoc;
use Illuminate\Database\Seeder;

class BaiGiangSeeder extends Seeder
{
    public function run(): void
    {
        $webBasic = KhoaHoc::where('tieu_de', 'Lập trình Web Cơ bản')->first();
        $webAdvanced = KhoaHoc::where('tieu_de', 'Lập trình Web Nâng cao')->first();

        if ($webBasic) {
            $lessons = [
                ['Chương 1: Giới thiệu về Web', 'video', 1, 900],
                ['Chương 2: HTML5 & CSS3', 'video', 2, 1200],
                ['Bài tập HTML/CSS', 'bai_tap', 3, 0],
                ['Chương 3: JavaScript Cơ bản', 'video', 4, 1500],
                ['Chương 4: DOM Manipulation', 'video', 5, 1800],
                ['Quiz: JavaScript', 'quiz', 6, 600],
            ];

            foreach ($lessons as $lesson) {
                BaiGiang::create([
                    'khoa_hoc_id' => $webBasic->id,
                    'tieu_de' => $lesson[0],
                    'mo_ta' => 'Nội dung chi tiết cho ' . $lesson[0],
                    'loai_noi_dung' => $lesson[1],
                    'url_noi_dung' => 'https://example.com/content',
                    'thu_tu' => $lesson[2],
                    'thoi_luong_giay' => $lesson[3],
                ]);
            }
        }

        if ($webAdvanced) {
            $lessons = [
                ['Chương 1: React Hooks', 'video', 1, 1200],
                ['Chương 2: State Management', 'video', 2, 1500],
                ['Assignment 1: To-Do App', 'bai_tap', 3, 0],
                ['Chương 3: Laravel API', 'video', 4, 1800],
                ['Chương 4: Authentication', 'video', 5, 2000],
                ['Final Project', 'bai_tap', 6, 0],
            ];

            foreach ($lessons as $lesson) {
                BaiGiang::create([
                    'khoa_hoc_id' => $webAdvanced->id,
                    'tieu_de' => $lesson[0],
                    'mo_ta' => 'Nội dung chi tiết cho ' . $lesson[0],
                    'loai_noi_dung' => $lesson[1],
                    'url_noi_dung' => 'https://example.com/content',
                    'thu_tu' => $lesson[2],
                    'thoi_luong_giay' => $lesson[3],
                ]);
            }
        }
    }
}
