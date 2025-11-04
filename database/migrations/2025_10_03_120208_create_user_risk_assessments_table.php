<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('probabilitas', 5, 2)->nullable();
            $table->string('kategori')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedInteger('total_skor')->nullable();
            $table->string('umur')->nullable();
            $table->string('paritas')->nullable();
            $table->string('kontrasepsi')->nullable();
            $table->string('penyakit_infeksi')->nullable();
            $table->string('aktifitas_fisik')->nullable();
            $table->string('status_pekerjaan')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('status_ekonomi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_risk_assessments');
    }
};
