<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThietBi extends Model
{
    use HasFactory;

    protected $table = 'thiet_bis';

    protected $fillable = [
        'nguoi_dung_id',
        'loai_thiet_bi',
        'he_dieu_hanh',
        'model',
        'dinh_danh_thiet_bi',
        'lan_cuoi_su_dung',
    ];

    protected $casts = [
        'lan_cuoi_su_dung' => 'datetime',
    ];

    /**
     * Người dùng sở hữu thiết bị
     */
    public function nguoiDung(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_dung_id');
    }

    /**
     * Các phiên học sử dụng thiết bị này
     */
    public function phienHocs(): HasMany
    {
        return $this->hasMany(PhienHoc::class, 'thiet_bi_id');
    }
}
