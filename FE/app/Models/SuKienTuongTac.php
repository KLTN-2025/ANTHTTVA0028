<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuKienTuongTac extends Model
{
    use HasFactory;

    protected $table = 'su_kien_tuong_tacs';

    protected $fillable = [
        'phien_hoc_id',
        'thoi_diem',
        'loai_su_kien',
        'gia_tri',
        'thoi_gian_tren_man_hinh_ms',
    ];

    protected $casts = [
        'thoi_diem' => 'datetime',
    ];

    /**
     * Phiên học của sự kiện
     */
    public function phienHoc(): BelongsTo
    {
        return $this->belongsTo(PhienHoc::class, 'phien_hoc_id');
    }
}
