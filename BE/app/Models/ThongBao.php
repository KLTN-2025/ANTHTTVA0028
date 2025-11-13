<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ThongBao extends Model
{
    use HasFactory;

    protected $table = 'thong_baos';

    protected $fillable = [
        'nguoi_nhan_id',
        'tieu_de',
        'noi_dung',
        'da_doc',
    ];

    protected $casts = [
        'da_doc' => 'boolean',
    ];

    /**
     * Người nhận thông báo
     */
    public function nguoiNhan(): BelongsTo
    {
        return $this->belongsTo(NguoiDung::class, 'nguoi_nhan_id');
    }
}
