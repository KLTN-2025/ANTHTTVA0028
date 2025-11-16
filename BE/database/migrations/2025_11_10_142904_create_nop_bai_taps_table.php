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
        Schema::create('nop_bai_taps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bai_tap_id')->constrained('bai_taps')->onDelete('cascade');
            $table->foreignId('hoc_vien_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->string('url_bai_nop', 500)->nullable();
            $table->dateTime('thoi_gian_nop')->nullable();
            $table->decimal('diem_so', 5, 2)->nullable();
            $table->text('nhan_xet')->nullable();
            $table->timestamps();

            $table->index('bai_tap_id');
            $table->index('hoc_vien_id');
            $table->unique(['bai_tap_id', 'hoc_vien_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nop_bai_taps');
    }
};
