<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_id')->constrained()->cascadeOnDelete();
            $table->enum('jenis_permintaan', ['pergantian', 'permintaan']);
            $table->integer('jumlah');
            $table->text('alasan');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('keterangan_admin')->nullable();
            $table->timestamp('tanggal_approved')->nullable();
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index(['cs_profile_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_inventories');
    }
};
