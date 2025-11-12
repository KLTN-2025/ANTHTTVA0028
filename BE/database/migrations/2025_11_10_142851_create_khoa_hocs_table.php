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
        Schema::create('khoa_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('tieu_de', 200);
            $table->text('mo_ta')->nullable();
            $table->enum('cap_do', ['co_ban', 'trung_binh', 'nang_cao'])->default('co_ban');
            $table->enum('hinh_thuc', ['tu_hoc', 'live', 'blended'])->default('tu_hoc');
            $table->integer('so_gio')->nullable();
            $table->string('anh_bia', 255)->nullable();
            $table->tinyInteger('cong_khai')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khoa_hocs');
    }
};
