<?php

namespace Database\Seeders;

use App\Models\LichHoc;
use App\Models\LopHoc;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LichHocSeeder extends Seeder
{
    public function run(): void
    {
        $classes = LopHoc::all();
        $startDate = Carbon::now()->startOfWeek(); // Start from this week Monday

        foreach ($classes as $class) {
            // Create schedule for 2 weeks
            for ($week = 0; $week < 2; $week++) {
                // 2 sessions per week
                for ($session = 1; $session <= 2; $session++) {
                    $dayOffset = ($session == 1) ? 1 : 3; // Tuesday and Thursday
                    $date = $startDate->copy()->addWeeks($week)->addDays($dayOffset);
                    
                    LichHoc::create([
                        'lop_hoc_id' => $class->id,
                        'thoi_gian_bat_dau' => $date->copy()->setHour(7)->setMinute(0),
                        'thoi_gian_ket_thuc' => $date->copy()->setHour(11)->setMinute(0),
                        'phong_hoc' => 'A2-' . rand(100, 500),
                        'hinh_thuc' => ($session == 1) ? 'offline' : 'online',
                        'ghi_chu' => 'Mang theo laptop',
                    ]);
                }
            }
        }
    }
}
