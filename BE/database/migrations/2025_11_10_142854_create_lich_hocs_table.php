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
        Schema::create('lich_hocs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lop_hoc_id')->constrained('lop_hocs')->onDelete('cascade');
            $table->foreignId('bai_giang_id')->nullable()->constrained('bai_giangs')->onDelete('set null');
            $table->dateTime('thoi_gian_bat_dau');
            $table->dateTime('thoi_gian_ket_thuc');
            $table->enum('hinh_thuc', ['online', 'offline', 'hybrid'])->default('online');
            $table->string('phong_hoc', 120)->nullable();
            $table->string('ghi_chu', 255)->nullable();
            $table->timestamps();

            $table->index('lop_hoc_id');
            $table->index('bai_giang_id');
            $table->index('thoi_gian_bat_dau');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lich_hocs');
    }
};
