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
        Schema::create('lua_chons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cau_hoi_id')->constrained('cau_hois')->onDelete('cascade');
            $table->text('noi_dung');
            $table->tinyInteger('la_dap_an')->default(0);
            $table->timestamps();

            $table->index('cau_hoi_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lua_chons');
    }
};
