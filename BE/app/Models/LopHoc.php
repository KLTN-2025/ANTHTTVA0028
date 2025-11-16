<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LopHoc extends Model
{
    use HasFactory;

    protected $table = 'lop_hocs';

    protected $fillable = [
        'khoa_hoc_id',
        'giang_vien_id',
        'ten_lop',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
    ];

    /**
     * Khóa học của lớp này
     */
    public function khoaHoc(): BelongsTo
    {
        return $this->belongsTo(KhoaHoc::class, 'khoa_hoc_id');
    }

    /**
     * Giảng viên của lớp
     */
    public function giangVien(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'giang_vien_id');
    }

    /**
     * Các lịch học của lớp
     */
    public function lichHocs(): HasMany
    {
        return $this->hasMany(LichHoc::class, 'lop_hoc_id');
    }

    /**
     * Các đăng ký học của lớp
     */
    public function dangKys(): HasMany
    {
        return $this->hasMany(DangKy::class, 'lop_hoc_id');
    }

    /**
     * Các phiên học của lớp
     */
    public function phienHocs(): HasMany
    {
        return $this->hasMany(PhienHoc::class, 'lop_hoc_id');
    }

    /**
     * Các phân tích tham gia của lớp
     */
    public function thamGiaPhanTichs(): HasMany
    {
        return $this->hasMany(ThamGiaPhanTich::class, 'lop_hoc_id');
    }
}
