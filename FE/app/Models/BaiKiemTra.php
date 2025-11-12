<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaiKiemTra extends Model
{
    use HasFactory;

    protected $table = 'bai_kiem_tras';

    protected $fillable = [
        'bai_giang_id',
        'tieu_de',
        'mo_ta',
        'thoi_luong_giay',
        'so_lan_lam',
        'chinh_sach_cham',
    ];

    /**
     * Bài giảng của bài kiểm tra
     */
    public function baiGiang(): BelongsTo
    {
        return $this->belongsTo(BaiGiang::class, 'bai_giang_id');
    }

    /**
     * Các câu hỏi trong bài kiểm tra
     */
    public function cauHois(): HasMany
    {
        return $this->hasMany(CauHoi::class, 'bai_kiem_tra_id');
    }

    /**
     * Các bài làm của học viên
     */
    public function baiLams(): HasMany
    {
        return $this->hasMany(BaiLam::class, 'bai_kiem_tra_id');
    }
}
