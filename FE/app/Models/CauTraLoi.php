<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CauTraLoi extends Model
{
    use HasFactory;

    protected $table = 'cau_tra_lois';

    protected $fillable = [
        'bai_lam_id',
        'cau_hoi_id',
        'lua_chon_id',
        'noi_dung_tu_luan',
        'dung',
        'diem_so',
    ];

    protected $casts = [
        'dung' => 'boolean',
        'diem_so' => 'decimal:2',
    ];

    /**
     * Bài làm chứa câu trả lời này
     */
    public function baiLam(): BelongsTo
    {
        return $this->belongsTo(BaiLam::class, 'bai_lam_id');
    }

    /**
     * Câu hỏi được trả lời
     */
    public function cauHoi(): BelongsTo
    {
        return $this->belongsTo(CauHoi::class, 'cau_hoi_id');
    }

    /**
     * Lựa chọn được chọn (nếu là trắc nghiệm)
     */
    public function luaChon(): BelongsTo
    {
        return $this->belongsTo(LuaChon::class, 'lua_chon_id');
    }
}
