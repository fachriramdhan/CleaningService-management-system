<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_atms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('absensi_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cs_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('atm_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal');
            $table->string('foto_sebelum');
            $table->string('foto_sesudah');
            $table->string('foto_lokasi');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index(['cs_profile_id', 'tanggal']);
            $table->index(['atm_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_atms');
    }
};
