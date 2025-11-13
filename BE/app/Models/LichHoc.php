<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LichHoc extends Model
{
    use HasFactory;

    protected $table = 'lich_hocs';

    protected $fillable = [
        'lop_hoc_id',
        'bai_giang_id',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
        'hinh_thuc',
        'phong_hoc',
        'ghi_chu',
    ];

    protected $casts = [
        'thoi_gian_bat_dau' => 'datetime',
        'thoi_gian_ket_thuc' => 'datetime',
    ];

    /**
     * Lớp học của lịch này
     */
    public function lopHoc(): BelongsTo
    {
        return $this->belongsTo(LopHoc::class, 'lop_hoc_id');
    }

    /**
     * Bài giảng của lịch học
     */
    public function baiGiang(): BelongsTo
    {
        return $this->belongsTo(BaiGiang::class, 'bai_giang_id');
    }

    /**
     * Các điểm danh trong buổi học này
     */
    public function diemDanhs(): HasMany
    {
        return $this->hasMany(DiemDanh::class, 'lich_hoc_id');
    }

    /**
     * Các phân tích tham gia của lịch học
     */
    public function thamGiaPhanTichs(): HasMany
    {
        return $this->hasMany(ThamGiaPhanTich::class, 'lich_hoc_id');
    }
}
