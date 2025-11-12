<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaiLam extends Model
{
    use HasFactory;

    protected $table = 'bai_lams';

    protected $fillable = [
        'bai_kiem_tra_id',
        'hoc_vien_id',
        'thoi_gian_bat_dau',
        'thoi_gian_ket_thuc',
        'diem_tong',
        'trang_thai',
    ];

    protected $casts = [
        'thoi_gian_bat_dau' => 'datetime',
        'thoi_gian_ket_thuc' => 'datetime',
        'diem_tong' => 'decimal:2',
    ];

    /**
     * Bài kiểm tra được làm
     */
    public function baiKiemTra(): BelongsTo
    {
        return $this->belongsTo(BaiKiemTra::class, 'bai_kiem_tra_id');
    }

    /**
     * Học viên làm bài
     */
    public function hocVien(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'hoc_vien_id');
    }

    /**
     * Các câu trả lời trong bài làm
     */
    public function cauTraLois(): HasMany
    {
        return $this->hasMany(CauTraLoi::class, 'bai_lam_id');
    }
}
