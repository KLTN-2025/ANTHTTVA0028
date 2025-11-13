<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaiTap extends Model
{
    use HasFactory;

    protected $table = 'bai_taps';

    protected $fillable = [
        'bai_giang_id',
        'tieu_de',
        'mo_ta',
        'han_nop',
        'diem_toi_da',
    ];

    protected $casts = [
        'han_nop' => 'datetime',
        'diem_toi_da' => 'decimal:2',
    ];

    /**
     * Bài giảng của bài tập
     */
    public function baiGiang(): BelongsTo
    {
        return $this->belongsTo(BaiGiang::class, 'bai_giang_id');
    }

    /**
     * Các bài nộp của học viên
     */
    public function nopBaiTaps(): HasMany
    {
        return $this->hasMany(NopBaiTap::class, 'bai_tap_id');
    }
}
