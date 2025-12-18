<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Fortify\TwoFactorAuthenticatable;

class NguoiDung extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $table = 'nguoi_dungs';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',

        'anh_dai_dien',
        'trang_thai',
    ];

    protected $hidden = [
        'mat_khau',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'trang_thai' => 'boolean',
        'two_factor_confirmed_at' => 'datetime',
    ];

    /**
     * Get the password for authentication.
     */
    public function getAuthPassword(): string
    {
        return $this->mat_khau;
    }



    /**
     * Các đăng ký học của học viên
     */
    public function dangKys(): HasMany
    {
        return $this->hasMany(DangKy::class, 'hoc_vien_id');
    }

    /**
     * Các thiết bị của người dùng
     */
    public function thietBis(): HasMany
    {
        return $this->hasMany(ThietBi::class, 'nguoi_dung_id');
    }

    /**
     * Các phiên học của người dùng
     */
    public function phienHocs(): HasMany
    {
        return $this->hasMany(PhienHoc::class, 'nguoi_dung_id');
    }

    /**
     * Các điểm danh của học viên
     */
    public function diemDanhs(): HasMany
    {
        return $this->hasMany(DiemDanh::class, 'hoc_vien_id');
    }

    /**
     * Các phân tích tham gia của học viên
     */
    public function thamGiaPhanTichs(): HasMany
    {
        return $this->hasMany(ThamGiaPhanTich::class, 'hoc_vien_id');
    }

    /**
     * Các bài nộp của học viên
     */
    public function nopBaiTaps(): HasMany
    {
        return $this->hasMany(NopBaiTap::class, 'hoc_vien_id');
    }

    /**
     * Các bài làm quiz của học viên
     */
    public function baiLams(): HasMany
    {
        return $this->hasMany(BaiLam::class, 'hoc_vien_id');
    }

    /**
     * Các thông báo nhận được
     */
    public function thongBaos(): HasMany
    {
        return $this->hasMany(ThongBao::class, 'nguoi_nhan_id');
    }
}
