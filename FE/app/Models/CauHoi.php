<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CauHoi extends Model
{
    use HasFactory;

    protected $table = 'cau_hois';

    protected $fillable = [
        'bai_kiem_tra_id',
        'noi_dung',
        'loai',
        'thu_tu',
        'diem',
    ];

    protected $casts = [
        'diem' => 'decimal:2',
    ];

    /**
     * Bài kiểm tra chứa câu hỏi này
     */
    public function baiKiemTra(): BelongsTo
    {
        return $this->belongsTo(BaiKiemTra::class, 'bai_kiem_tra_id');
    }

    /**
     * Các lựa chọn của câu hỏi
     */
    public function luaChons(): HasMany
    {
        return $this->hasMany(LuaChon::class, 'cau_hoi_id');
    }

    /**
     * Các câu trả lời của học viên
     */
    public function cauTraLois(): HasMany
    {
        return $this->hasMany(CauTraLoi::class, 'cau_hoi_id');
    }
}
