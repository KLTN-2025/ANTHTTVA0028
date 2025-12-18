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
        $this->call([
            AdminSeeder::class,
            GiangVienSeeder::class,
            KhoaHocSeeder::class,
            LopHocSeeder::class,
            // Create Student first before enrolling
        ]);

        // Tạo tài khoản học viên mẫu
        NguoiDung::firstOrCreate(
            ['email' => 'hocvien@agoralearn.com'],
            [
                'ho_ten' => 'Học Viên Mẫu',
                'mat_khau' => Hash::make('password'),
                'trang_thai' => 1,
            ]
        );

        // Continue seeding dependent data
        $this->call([
            DangKySeeder::class,
            BaiGiangSeeder::class,
            BaiTapSeeder::class,
            NopBaiTapSeeder::class,
            LichHocSeeder::class,
            ThongBaoSeeder::class,
        ]);
    }
}
