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
        Schema::create('tai_lieus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('khoa_hoc_id')->nullable()->constrained('khoa_hocs')->onDelete('cascade');
            $table->foreignId('bai_giang_id')->nullable()->constrained('bai_giangs')->onDelete('cascade');
            $table->string('tieu_de', 200);
            $table->enum('loai', ['pdf', 'slide', 'link', 'khac'])->default('pdf');
            $table->string('url', 500);
            $table->timestamps();

            $table->index('khoa_hoc_id');
            $table->index('bai_giang_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tai_lieus');
    }
};
