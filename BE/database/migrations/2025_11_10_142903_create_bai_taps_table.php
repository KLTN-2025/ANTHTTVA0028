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
        Schema::create('bai_taps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bai_giang_id')->constrained('bai_giangs')->onDelete('cascade');
            $table->string('tieu_de', 200);
            $table->text('mo_ta')->nullable();
            $table->dateTime('han_nop')->nullable();
            $table->decimal('diem_toi_da', 5, 2)->default(10.00);
            $table->timestamps();

            $table->index('bai_giang_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bai_taps');
    }
};
