<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LuaChon extends Model
{
    use HasFactory;

    protected $table = 'lua_chons';

    protected $fillable = [
        'cau_hoi_id',
        'noi_dung',
        'la_dap_an',
    ];

    protected $casts = [
        'la_dap_an' => 'boolean',
    ];

    /**
     * Câu hỏi của lựa chọn này
     */
    public function cauHoi(): BelongsTo
    {
        return $this->belongsTo(CauHoi::class, 'cau_hoi_id');
    }

    /**
     * Các câu trả lời chọn lựa chọn này
     */
    public function cauTraLois(): HasMany
    {
        return $this->hasMany(CauTraLoi::class, 'lua_chon_id');
    }
}
