<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DangKy;
use App\Models\LichHoc;
use App\Models\LopHoc;
use App\Models\ThongBao;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        // Thống kê
        $totalCourses = DangKy::where('hoc_vien_id', $user->id)->count();
        $activeCourses = DangKy::where('hoc_vien_id', $user->id)
            ->where('trang_thai', 'dang_hoc')
            ->count();
        
        // Lớp học sắp tới (trong 7 ngày tới)
        $upcomingClasses = LichHoc::whereHas('lopHoc.dangKys', function ($query) use ($user) {
                $query->where('hoc_vien_id', $user->id);
            })
            ->where('thoi_gian_bat_dau', '>=', now())
            ->where('thoi_gian_bat_dau', '<=', now()->addDays(7))
            ->orderBy('thoi_gian_bat_dau', 'asc')
            ->with(['lopHoc.khoaHoc'])
            ->take(5)
            ->get()
            ->map(function ($lich) {
                return [
                    'id' => $lich->id,
                    'ten_lop' => $lich->lopHoc->ten_lop,
                    'ten_khoa_hoc' => $lich->lopHoc->khoaHoc->tieu_de,
                    'thoi_gian' => $lich->thoi_gian_bat_dau->format('H:i d/m/Y'),
                    'phong' => $lich->phong_hoc,
                    'hinh_thuc' => $lich->hinh_thuc,
                ];
            });

        // Thông báo mới
        $notifications = ThongBao::where('nguoi_nhan_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'stats' => [
                'total_courses' => $totalCourses,
                'active_courses' => $activeCourses,
                'assignments_pending' => 0, // Todo: Implement assignment logic
                'average_score' => 0, // Todo: Implement grade logic
            ],
            'upcoming_classes' => $upcomingClasses,
            'notifications' => $notifications,
        ]);
    }

    public function myCourses(Request $request)
    {
        $user = $request->user();

        $courses = DangKy::where('hoc_vien_id', $user->id)
            ->with(['lopHoc.khoaHoc', 'lopHoc.giangVien'])
            ->get()
            ->map(function ($dangKy) {
                $lop = $dangKy->lopHoc;
                $khoa = $lop->khoaHoc;
                return [
                    'id' => $lop->id,
                    'ten_khoa_hoc' => $khoa->tieu_de,
                    'ma_lop' => $lop->ten_lop,
                    'giang_vien' => $lop->giangVien->ho_ten,
                    'anh_bia' => $khoa->anh_bia,
                    'tien_do' => 0, // Todo: Calculate progress
                    'trang_thai' => $dangKy->trang_thai,
                ];
            });

        return response()->json($courses);
    }

    public function courseDetail(Request $request, $id)
    {
        $user = $request->user();
        
        // Check enrollment
        $enrollment = DangKy::where('hoc_vien_id', $user->id)
            ->where('lop_hoc_id', $id)
            ->firstOrFail();

        $class = LopHoc::with(['khoaHoc.baiGiangs.baiTap', 'giangVien'])->findOrFail($id);
        $course = $class->khoaHoc;

        // Get submissions for this user
        $submissions = \App\Models\NopBaiTap::where('hoc_vien_id', $user->id)
            ->whereIn('bai_tap_id', $course->baiGiangs->pluck('baiTap.id')->filter())
            ->get()
            ->keyBy('bai_tap_id');

        return response()->json([
            'id' => $class->id,
            'ten_khoa_hoc' => $course->tieu_de,
            'ten_lop' => $class->ten_lop,
            'mo_ta' => $course->mo_ta,
            'giang_vien' => $class->giangVien->ho_ten,
            'bai_giangs' => $course->baiGiangs->map(function ($bg) use ($submissions) {
                $data = [
                    'id' => $bg->id,
                    'tieu_de' => $bg->tieu_de,
                    'loai' => $bg->loai_noi_dung,
                    'thoi_luong' => $bg->thoi_luong_giay,
                    'hoan_thanh' => false, // Todo: Check completion for video
                ];

                if ($bg->loai_noi_dung === 'bai_tap' && $bg->baiTap) {
                    $submission = $submissions->get($bg->baiTap->id);
                    $data['bai_tap'] = [
                        'id' => $bg->baiTap->id,
                        'han_nop' => $bg->baiTap->han_nop,
                        'diem_toi_da' => $bg->baiTap->diem_toi_da,
                        'da_nop' => $submission ? true : false,
                        'diem_so' => $submission ? $submission->diem_so : null,
                        'trang_thai' => $submission ? ($submission->diem_so !== null ? 'da_cham' : 'cho_cham') : 'chua_nop',
                    ];
                }

                return $data;
            }),
        ]);
    }

    public function schedule(Request $request)
    {
        $user = $request->user();
        $start = $request->query('start', now()->startOfWeek()->format('Y-m-d'));
        $end = $request->query('end', now()->endOfWeek()->format('Y-m-d'));

        $schedule = LichHoc::whereHas('lopHoc.dangKys', function ($query) use ($user) {
                $query->where('hoc_vien_id', $user->id);
            })
            ->whereBetween('thoi_gian_bat_dau', [$start . ' 00:00:00', $end . ' 23:59:59'])
            ->with(['lopHoc.khoaHoc'])
            ->orderBy('thoi_gian_bat_dau')
            ->get()
            ->map(function ($lich) {
                return [
                    'id' => $lich->id,
                    'title' => $lich->lopHoc->khoaHoc->tieu_de,
                    'start' => $lich->thoi_gian_bat_dau->toIso8601String(),
                    'end' => $lich->thoi_gian_ket_thuc->toIso8601String(),
                    'type' => $lich->hinh_thuc,
                    'room' => $lich->phong_hoc,
                ];
            });

        return response()->json($schedule);
    }
}
