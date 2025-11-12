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
        Schema::create('nhan_diens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('diem_danh_id')->constrained('diem_danhs')->onDelete('cascade');
            $table->dateTime('thoi_diem');
            $table->string('khuon_mat_url', 500)->nullable();
            $table->decimal('do_tin_cay', 5, 2);
            $table->string('mo_ta_model', 120)->nullable();
            $table->text('thong_so')->nullable();
            $table->timestamps();

            $table->index('diem_danh_id');
            $table->index('thoi_diem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_diens');
    }
};
