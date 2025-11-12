<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NopBaiTap extends Model
{
    use HasFactory;

    protected $table = 'nop_bai_taps';

    protected $fillable = [
        'bai_tap_id',
        'hoc_vien_id',
        'url_bai_nop',
        'thoi_gian_nop',
        'diem_so',
        'nhan_xet',
    ];

    protected $casts = [
        'thoi_gian_nop' => 'datetime',
        'diem_so' => 'decimal:2',
    ];

    /**
     * Bài tập được nộp
     */
    public function baiTap(): BelongsTo
    {
        return $this->belongsTo(BaiTap::class, 'bai_tap_id');
    }

    /**
     * Học viên nộp bài
     */
    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'hoc_vien_id');
    }
}
