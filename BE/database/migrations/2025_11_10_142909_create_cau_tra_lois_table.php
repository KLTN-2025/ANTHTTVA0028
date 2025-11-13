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
        Schema::create('cau_tra_lois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bai_lam_id')->constrained('bai_lams')->onDelete('cascade');
            $table->foreignId('cau_hoi_id')->constrained('cau_hois')->onDelete('cascade');
            $table->foreignId('lua_chon_id')->nullable()->constrained('lua_chons')->onDelete('set null');
            $table->text('noi_dung_tu_luan')->nullable();
            $table->tinyInteger('dung')->nullable();
            $table->decimal('diem_so', 5, 2)->nullable();
            $table->timestamps();

            $table->index('bai_lam_id');
            $table->index('cau_hoi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cau_tra_lois');
    }
};
