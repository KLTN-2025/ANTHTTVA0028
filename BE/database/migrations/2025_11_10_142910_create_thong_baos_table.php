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
        Schema::create('thong_baos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_nhan_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->string('tieu_de', 200);
            $table->text('noi_dung');
            $table->tinyInteger('da_doc')->default(0);
            $table->timestamps();

            $table->index('nguoi_nhan_id');
            $table->index('da_doc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thong_baos');
    }
};
