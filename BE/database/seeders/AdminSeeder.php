<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'ho_ten' => 'Administrator',
            'email' => 'admin@agoralearn.com',
            'mat_khau' => Hash::make('password'),
        ]);
    }
}
