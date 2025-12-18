<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NopBaiTap;
use App\Models\BaiTap;
use App\Models\NguoiDung;
use Carbon\Carbon;

class NopBaiTapSeeder extends Seeder
{
    public function run(): void
    {
        // Get the student user
        $student = NguoiDung::where('email', 'hocvien@agoralearn.com')->first();
        
        if (!$student) return;

        // Get some assignments
        $assignments = BaiTap::take(3)->get();

        foreach ($assignments as $index => $assignment) {
            // Simulate different statuses
            if ($index == 0) {
                // Submitted and graded
                NopBaiTap::create([
                    'bai_tap_id' => $assignment->id,
                    'hoc_vien_id' => $student->id,
                    'url_bai_nop' => 'https://example.com/submission.zip',
                    'thoi_gian_nop' => Carbon::now()->subDays(2),
                    'diem_so' => 8.5,
                    'nhan_xet' => 'Làm tốt lắm, nhưng cần cải thiện phần CSS.',
                ]);
            } elseif ($index == 1) {
                // Submitted but not graded
                NopBaiTap::create([
                    'bai_tap_id' => $assignment->id,
                    'hoc_vien_id' => $student->id,
                    'url_bai_nop' => 'https://example.com/submission2.zip',
                    'thoi_gian_nop' => Carbon::now()->subHours(5),
                    'diem_so' => null,
                    'nhan_xet' => null,
                ]);
            }
            // Index 2 is not submitted
        }
    }
}
