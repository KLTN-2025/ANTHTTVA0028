<?php

namespace Database\Seeders;

use App\Models\GiangVien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GiangVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GiangVien::create([
            'ho_ten' => 'Nguyễn Văn Giảng Viên',
            'email' => 'giangvien@agoralearn.com',
            'mat_khau' => Hash::make('password'),
            'so_dien_thoai' => '0912345678',
            'chuyen_mon' => 'Công nghệ thông tin',
            'trang_thai' => 1,
        ]);

        GiangVien::create([
            'ho_ten' => 'Trần Thị Giảng Viên',
            'email' => 'giangvien2@agoralearn.com',
            'mat_khau' => Hash::make('password'),
            'so_dien_thoai' => '0987654321',
            'chuyen_mon' => 'Khoa học dữ liệu',
            'trang_thai' => 1,
        ]);
    }
}
