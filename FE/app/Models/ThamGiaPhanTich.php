<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThamGiaPhanTich extends Model
{
    use HasFactory;

    protected $table = 'tham_gia_phan_tichs';

    protected $fillable = [
        'hoc_vien_id',
        'lop_hoc_id',
        'bai_giang_id',
        'lich_hoc_id',
        'tong_thoi_gian_xem_giay',
        'so_su_kien_tuong_tac',
        'so_lan_quay_lai',
        'diem_tham_gia',
        'chi_so_chu_y',
        'cap_nhat_cuoi',
    ];

    protected $casts = [
        'cap_nhat_cuoi' => 'datetime',
        'diem_tham_gia' => 'decimal:2',
        'chi_so_chu_y' => 'decimal:2',
    ];

    /**
     * Học viên
     */
    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'hoc_vien_id');
    }

    /**
     * Lớp học
     */
    public function lopHoc(): BelongsTo
    {
        return $this->belongsTo(LopHoc::class, 'lop_hoc_id');
    }

    /**
     * Bài giảng
     */
    public function baiGiang(): BelongsTo
    {
        return $this->belongsTo(BaiGiang::class, 'bai_giang_id');
    }

    /**
     * Lịch học
     */
    public function lichHoc(): BelongsTo
    {
        return $this->belongsTo(LichHoc::class, 'lich_hoc_id');
    }
}
