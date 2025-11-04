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
        Schema::create('riwayat_skrining', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('tanggal')->useCurrent();
            $table->string('status', 30)->default('In Progress');
            $table->string('status_risiko', 50)->nullable();
            $table->string('jenis_sesi', 20);
            $table->string('jumlah_edukasi', 20)->nullable();
            $table->timestamps();

            $table->index(['jenis_sesi', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_skrining');
    }
};
