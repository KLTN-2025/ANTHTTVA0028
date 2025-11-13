<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaiLieu extends Model
{
    use HasFactory;

    protected $table = 'tai_lieus';

    protected $fillable = [
        'khoa_hoc_id',
        'bai_giang_id',
        'tieu_de',
        'loai',
        'url',
    ];

    /**
     * Khóa học của tài liệu
     */
    public function khoaHoc(): BelongsTo
    {
        return $this->belongsTo(KhoaHoc::class, 'khoa_hoc_id');
    }

    /**
     * Bài giảng của tài liệu
     */
    public function baiGiang(): BelongsTo
    {
        return $this->belongsTo(BaiGiang::class, 'bai_giang_id');
    }
}
