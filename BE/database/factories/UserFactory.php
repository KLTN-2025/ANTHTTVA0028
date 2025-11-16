<?php

namespace Database\Factories;

use App\Models\NguoiDung;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NguoiDung>
 */
class UserFactory extends Factory
{
    protected $model = NguoiDung::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ho_ten' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'mat_khau' => Hash::make('password'),
            'vai_tro' => 'hoc_vien',
            'anh_dai_dien' => null,
            'trang_thai' => 1,
        ];
    }

    /**
     * Chỉ định vai trò là giảng viên
     */
    public function giangVien(): static
    {
        return $this->state(fn (array $attributes) => [
            'vai_tro' => 'giang_vien',
        ]);
    }

    /**
     * Chỉ định vai trò là quản trị
     */
    public function quanTri(): static
    {
        return $this->state(fn (array $attributes) => [
            'vai_tro' => 'quan_tri',
        ]);
    }
}
