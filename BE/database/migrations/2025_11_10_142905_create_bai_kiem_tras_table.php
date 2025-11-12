<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bai_kiem_tras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bai_giang_id')->constrained('bai_giangs')->onDelete('cascade');
            $table->string('tieu_de', 200);
            $table->text('mo_ta')->nullable();
            $table->integer('thoi_luong_giay')->default(600);
            $table->integer('so_lan_lam')->default(1);
            $table->enum('chinh_sach_cham', ['diem_cao_nhat', 'lan_cuoi'])->default('diem_cao_nhat');
            $table->timestamps();

            $table->index('bai_giang_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_kiem_tras');
    }
};
