<?php

namespace Database\Seeders;

use App\Models\NguoiDung;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo tài khoản quản trị mặc định
        NguoiDung::firstOrCreate(
            ['email' => 'admin@agoralearn.com'],
            [
                'ho_ten' => 'Administrator',
                'mat_khau' => Hash::make('password'),
                'vai_tro' => 'quan_tri',
                'trang_thai' => 1,
            ]
        );

        // Tạo tài khoản giảng viên mẫu
        NguoiDung::firstOrCreate(
            ['email' => 'giangvien@agoralearn.com'],
            [
                'ho_ten' => 'Giảng Viên Mẫu',
                'mat_khau' => Hash::make('password'),
                'vai_tro' => 'giang_vien',
                'trang_thai' => 1,
            ]
        );

        // Tạo tài khoản học viên mẫu
        NguoiDung::firstOrCreate(
            ['email' => 'hocvien@agoralearn.com'],
            [
                'ho_ten' => 'Học Viên Mẫu',
                'mat_khau' => Hash::make('password'),
                'vai_tro' => 'hoc_vien',
                'trang_thai' => 1,
            ]
        );
    }
}

