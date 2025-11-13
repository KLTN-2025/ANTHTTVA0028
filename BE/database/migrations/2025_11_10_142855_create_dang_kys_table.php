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
        Schema::create('dang_kys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lop_hoc_id')->constrained('lop_hocs')->onDelete('cascade');
            $table->foreignId('hoc_vien_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->enum('trang_thai', ['dang_ky', 'huy', 'hoan_thanh'])->default('dang_ky');
            $table->dateTime('ngay_dang_ky');
            $table->timestamps();

            $table->index('lop_hoc_id');
            $table->index('hoc_vien_id');
            $table->unique(['lop_hoc_id', 'hoc_vien_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dang_kys');
    }
};
