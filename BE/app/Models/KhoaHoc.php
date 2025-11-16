<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KhoaHoc extends Model
{
    use HasFactory;

    protected $table = 'khoa_hocs';

    protected $fillable = [
        'tieu_de',
        'mo_ta',
        'cap_do',
        'hinh_thuc',
        'so_gio',
        'anh_bia',
        'cong_khai',
    ];

    protected $casts = [
        'cong_khai' => 'boolean',
    ];

    /**
     * Các lớp học của khóa học này
     */
    public function lopHocs(): HasMany
    {
        return $this->hasMany(LopHoc::class, 'khoa_hoc_id');
    }

    /**
     * Các bài giảng của khóa học
     */
    public function baiGiangs(): HasMany
    {
        return $this->hasMany(BaiGiang::class, 'khoa_hoc_id');
    }

    /**
     * Các tài liệu của khóa học
     */
    public function taiLieus(): HasMany
    {
        return $this->hasMany(TaiLieu::class, 'khoa_hoc_id');
    }
}
