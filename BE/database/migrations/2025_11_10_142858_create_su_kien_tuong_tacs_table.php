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
        Schema::create('su_kien_tuong_tacs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('phien_hoc_id')->constrained('phien_hocs')->onDelete('cascade');
            $table->dateTime('thoi_diem');
            $table->enum('loai_su_kien', ['play', 'pause', 'seek', 'hoan_thanh', 'click', 'chat', 'reaction', 'quiz_tra_loi', 'mo_tai_lieu', 'scroll']);
            $table->string('gia_tri', 255)->nullable();
            $table->integer('thoi_gian_tren_man_hinh_ms')->nullable();
            $table->timestamps();

            $table->index('phien_hoc_id');
            $table->index('thoi_diem');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('su_kien_tuong_tacs');
    }
};
