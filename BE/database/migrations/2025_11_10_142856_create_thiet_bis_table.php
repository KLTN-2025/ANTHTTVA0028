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
        Schema::create('thiet_bis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nguoi_dung_id')->constrained('nguoi_dungs')->onDelete('cascade');
            $table->string('loai_thiet_bi', 60)->nullable();
            $table->string('he_dieu_hanh', 60)->nullable();
            $table->string('model', 120)->nullable();
            $table->string('dinh_danh_thiet_bi', 190)->nullable();
            $table->dateTime('lan_cuoi_su_dung')->nullable();
            $table->timestamps();

            $table->index('nguoi_dung_id');
            $table->index('dinh_danh_thiet_bi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thiet_bis');
    }
};
