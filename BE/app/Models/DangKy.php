<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DangKy extends Model
{
    use HasFactory;

    protected $table = 'dang_kys';

    protected $fillable = [
        'lop_hoc_id',
        'hoc_vien_id',
        'trang_thai',
        'ngay_dang_ky',
    ];

    protected $casts = [
        'ngay_dang_ky' => 'datetime',
    ];

    /**
     * Lớp học được đăng ký
     */
    public function lopHoc(): BelongsTo
    {
        return $this->belongsTo(LopHoc::class, 'lop_hoc_id');
    }

    /**
     * Học viên đăng ký
     */
    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'hoc_vien_id');
    }
}
