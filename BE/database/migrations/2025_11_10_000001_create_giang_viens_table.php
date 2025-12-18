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
        Schema::create('giang_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten', 120);
            $table->string('email', 190)->unique();
            $table->string('mat_khau', 255);
            $table->string('so_dien_thoai', 20)->nullable();
            $table->string('chuyen_mon', 200)->nullable();
            $table->string('anh_dai_dien', 255)->nullable();
            $table->tinyInteger('trang_thai')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giang_viens');
    }
};
