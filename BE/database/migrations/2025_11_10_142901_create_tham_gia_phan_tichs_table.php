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
        Schema::create('tham_gia_phan_tichs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoc_vien_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->foreignId('lop_hoc_id')->constrained('lop_hocs')->onDelete('cascade');
            $table->foreignId('bai_giang_id')->nullable()->constrained('bai_giangs')->onDelete('set null');
            $table->foreignId('lich_hoc_id')->nullable()->constrained('lich_hocs')->onDelete('set null');
            $table->integer('tong_thoi_gian_xem_giay')->default(0);
            $table->integer('so_su_kien_tuong_tac')->default(0);
            $table->integer('so_lan_quay_lai')->default(0);
            $table->decimal('diem_tham_gia', 6, 2)->nullable();
            $table->decimal('chi_so_chu_y', 6, 2)->nullable();
            $table->dateTime('cap_nhat_cuoi')->nullable();
            $table->timestamps();

            $table->index('hoc_vien_id');
            $table->index('lop_hoc_id');
            $table->index('bai_giang_id');
            $table->index('lich_hoc_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tham_gia_phan_tichs');
    }
};
