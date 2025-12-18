<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
    ];

    protected $hidden = [
        'mat_khau',
    ];

    protected $casts = [
        'mat_khau' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->mat_khau;
    }
}
