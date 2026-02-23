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
        Schema::create('leave_quotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_profile_id')->constrained('cs_profiles')->onDelete('cascade');
            $table->year('year'); // Tahun cuti (2024, 2025, etc)
            $table->integer('annual_quota')->default(6); // Jatah cuti tahunan (6 hari)
            $table->integer('annual_used')->default(0); // Cuti tahunan yang sudah dipakai
            $table->integer('sick_used')->default(0); // Cuti sakit yang sudah dipakai (unlimited)
            $table->integer('emergency_used')->default(0); // Cuti emergency yang sudah dipakai (unlimited)
            $table->integer('unpaid_used')->default(0); // Cuti unpaid yang sudah dipakai (unlimited)
            $table->timestamps();

            // Unique constraint: 1 CS hanya punya 1 quota per tahun
            $table->unique(['cs_profile_id', 'year'], 'leave_quota_unique');

            // Index untuk performa query
            $table->index('cs_profile_id');
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_quotas');
    }
};
