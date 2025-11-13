<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhienHoc extends Model
{
    use HasFactory;

    protected $table = 'phien_hocs';

    protected $fillable = [
        'nguoi_dung_id',
        'lop_hoc_id',
        'bai_giang_id',
        'thiet_bi_id',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
        'dia_chi_ip',
        'vi_tri',
        'nguon',
    ];

    protected $casts = [
        'thoi_gian_bat_dau' => 'datetime',
        'thoi_gian_ket_thuc' => 'datetime',
    ];

    /**
     * Người dùng của phiên học
     */
    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    /**
     * Lớp học của phiên
     */
    public function lopHoc(): BelongsTo
    {
        return $this->belongsTo(LopHoc::class, 'lop_hoc_id');
    }

    /**
     * Bài giảng của phiên học
     */
    public function baiGiang(): BelongsTo
    {
        return $this->belongsTo(BaiGiang::class, 'bai_giang_id');
    }

    /**
     * Thiết bị sử dụng
     */
    public function thietBi(): BelongsTo
    {
        return $this->belongsTo(ThietBi::class, 'thiet_bi_id');
    }

    /**
     * Các sự kiện tương tác trong phiên
     */
    public function suKienTuongTacs(): HasMany
    {
        return $this->hasMany(SuKienTuongTac::class, 'phien_hoc_id');
    }
}
