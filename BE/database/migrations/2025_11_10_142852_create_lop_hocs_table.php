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
        Schema::create('lop_hocs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khoa_hoc_id')->constrained('khoa_hocs')->onDelete('cascade');
            $table->foreignId('giang_vien_id')->constrained('giang_viens')->onDelete('cascade');
            $table->string('ten_lop', 200);
            $table->date('ngay_bat_dau')->nullable();
            $table->date('ngay_ket_thuc')->nullable();
            $table->enum('trang_thai', ['len_ke_hoach', 'dang_hoc', 'ket_thuc'])->default('len_ke_hoach');
            $table->timestamps();

            $table->index('khoa_hoc_id');
            $table->index('giang_vien_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lop_hocs');
    }
};
