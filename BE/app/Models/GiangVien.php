<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class GiangVien extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'giang_viens';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'chuyen_mon',
        'anh_dai_dien',
        'trang_thai',
    ];

    protected $hidden = [
        'mat_khau',
    ];

    protected $casts = [
        'mat_khau' => 'hashed',
        'trang_thai' => 'boolean',
    ];

    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function lopHocs()
    {
        return $this->hasMany(LopHoc::class, 'giang_vien_id');
    }
}
