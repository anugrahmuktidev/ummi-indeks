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
        Schema::create('skrining', function (Blueprint $table) {
            $table->id();
            $table->foreignId('riwayat_skrining_id')->constrained('riwayat_skrining')->cascadeOnDelete();
            $table->foreignId('soal_id')->constrained('soal')->cascadeOnDelete();
            $table->foreignId('jawaban_id')->constrained('jawaban')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['riwayat_skrining_id', 'soal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skrining');
    }
};
