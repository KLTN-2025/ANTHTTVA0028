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
        Schema::create('cau_hois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bai_kiem_tra_id')->constrained('bai_kiem_tras')->onDelete('cascade');
            $table->text('noi_dung');
            $table->enum('loai', ['trac_nghiem', 'dung_sai', 'tu_luan'])->default('trac_nghiem');
            $table->integer('thu_tu')->default(1);
            $table->decimal('diem', 5, 2)->default(1.00);
            $table->timestamps();

            $table->index('bai_kiem_tra_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_hois');
    }
};
