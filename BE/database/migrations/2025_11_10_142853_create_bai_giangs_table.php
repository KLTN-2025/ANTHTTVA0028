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
        Schema::create('bai_giangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khoa_hoc_id')->constrained('khoa_hocs')->onDelete('cascade');
            $table->string('tieu_de', 200);
            $table->text('mo_ta')->nullable();
            $table->enum('loai_noi_dung', ['video', 'live', 'tai_lieu', 'bai_tap', 'quiz'])->default('video');
            $table->string('url_noi_dung', 500)->nullable();
            $table->integer('thu_tu')->default(1);
            $table->integer('thoi_luong_giay')->nullable();
            $table->timestamps();

            $table->index('khoa_hoc_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_giangs');
    }
};
