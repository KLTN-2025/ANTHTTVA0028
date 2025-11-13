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
        Schema::create('phien_hocs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->foreignId('lop_hoc_id')->nullable()->constrained('lop_hocs')->onDelete('set null');
            $table->foreignId('bai_giang_id')->nullable()->constrained('bai_giangs')->onDelete('set null');
            $table->foreignId('thiet_bi_id')->nullable()->constrained('thiet_bis')->onDelete('set null');
            $table->dateTime('thoi_gian_bat_dau');
            $table->dateTime('thoi_gian_ket_thuc')->nullable();
            $table->string('dia_chi_ip', 45)->nullable();
            $table->string('vi_tri', 190)->nullable();
            $table->enum('nguon', ['web', 'mobile', 'desktop'])->default('web');
            $table->timestamps();

            $table->index('nguoi_dung_id');
            $table->index('lop_hoc_id');
            $table->index('bai_giang_id');
            $table->index('thiet_bi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phien_hocs');
    }
};
