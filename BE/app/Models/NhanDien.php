<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NhanDien extends Model
{
    use HasFactory;

    protected $table = 'nhan_diens';

    protected $fillable = [
        'diem_danh_id',
        'thoi_diem',
        'khuon_mat_url',
        'do_tin_cay',
        'mo_ta_model',
        'thong_so',
    ];

    protected $casts = [
        'thoi_diem' => 'datetime',
        'do_tin_cay' => 'decimal:2',
        'thong_so' => 'array',
    ];

    /**
     * Điểm danh của nhận diện này
     */
    public function diemDanh(): BelongsTo
    {
        return $this->belongsTo(DiemDanh::class, 'diem_danh_id');
    }
}
