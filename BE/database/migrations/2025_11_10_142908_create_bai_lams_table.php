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
        Schema::create('bai_lams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bai_kiem_tra_id')->constrained('bai_kiem_tras')->onDelete('cascade');
            $table->foreignId('hoc_vien_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->dateTime('thoi_gian_bat_dau');
            $table->dateTime('thoi_gian_ket_thuc')->nullable();
            $table->decimal('diem_tong', 6, 2)->nullable();
            $table->enum('trang_thai', ['dang_lam', 'nop', 'het_han'])->default('dang_lam');
            $table->timestamps();

            $table->index('bai_kiem_tra_id');
            $table->index('hoc_vien_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_lams');
    }
};
