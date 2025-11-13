<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaiGiang extends Model
{
    use HasFactory;

    protected $table = 'bai_giangs';

    protected $fillable = [
        'khoa_hoc_id',
        'tieu_de',
        'mo_ta',
        'loai_noi_dung',
        'url_noi_dung',
        'thu_tu',
        'thoi_luong_giay',
    ];

    /**
     * Khóa học của bài giảng
     */
    public function khoaHoc(): BelongsTo
    {
        return $this->belongsTo(KhoaHoc::class, 'khoa_hoc_id');
    }

    /**
     * Các lịch học sử dụng bài giảng này
     */
    public function lichHocs(): HasMany
    {
        return $this->hasMany(LichHoc::class, 'bai_giang_id');
    }

    /**
     * Các phiên học của bài giảng
     */
    public function phienHocs(): HasMany
    {
        return $this->hasMany(PhienHoc::class, 'bai_giang_id');
    }

    /**
     * Các tài liệu của bài giảng
     */
    public function taiLieus(): HasMany
    {
        return $this->hasMany(TaiLieu::class, 'bai_giang_id');
    }

    /**
     * Các bài tập của bài giảng
     */
    public function baiTaps(): HasMany
    {
        return $this->hasMany(BaiTap::class, 'bai_giang_id');
    }

    /**
     * Các bài kiểm tra của bài giảng
     */
    public function baiKiemTras(): HasMany
    {
        return $this->hasMany(BaiKiemTra::class, 'bai_giang_id');
    }

    /**
     * Các phân tích tham gia của bài giảng
     */
    public function thamGiaPhanTichs(): HasMany
    {
        return $this->hasMany(ThamGiaPhanTich::class, 'bai_giang_id');
    }
}
