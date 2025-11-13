<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiemDanh extends Model
{
    use HasFactory;

    protected $table = 'diem_danhs';

    protected $fillable = [
        'lich_hoc_id',
        'hoc_vien_id',
        'trang_thai',
        'phuong_thuc',
        'thoi_diem_vao',
        'thoi_diem_ra',
        'do_tin_cay',
        'ghi_chu',
    ];

    protected $casts = [
        'thoi_diem_vao' => 'datetime',
        'thoi_diem_ra' => 'datetime',
        'do_tin_cay' => 'decimal:2',
    ];

    /**
     * Lịch học được điểm danh
     */
    public function lichHoc(): BelongsTo
    {
        return $this->belongsTo(LichHoc::class, 'lich_hoc_id');
    }

    /**
     * Học viên được điểm danh
     */
    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'hoc_vien_id');
    }

    /**
     * Các lần nhận diện khuôn mặt
     */
    public function nhanDiens(): HasMany
    {
        return $this->hasMany(NhanDien::class, 'diem_danh_id');
    }
}
