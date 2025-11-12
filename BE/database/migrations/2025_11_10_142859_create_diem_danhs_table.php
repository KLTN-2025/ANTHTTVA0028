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
        Schema::create('diem_danhs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lich_hoc_id')->constrained('lich_hocs')->onDelete('cascade');
            $table->foreignId('hoc_vien_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->enum('trang_thai', ['co_mat', 'vang', 'tre'])->default('co_mat');
            $table->enum('phuong_thuc', ['ai', 'thu_cong', 'qr'])->default('ai');
            $table->dateTime('thoi_diem_vao')->nullable();
            $table->dateTime('thoi_diem_ra')->nullable();
            $table->decimal('do_tin_cay', 5, 2)->nullable();
            $table->string('ghi_chu', 255)->nullable();
            $table->timestamps();

            $table->index('lich_hoc_id');
            $table->index('hoc_vien_id');
            $table->unique(['lich_hoc_id', 'hoc_vien_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diem_danhs');
    }
};
