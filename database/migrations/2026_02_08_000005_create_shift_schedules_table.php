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
        Schema::create('shift_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_profile_id')->constrained('cs_profiles')->onDelete('cascade');
            $table->year('schedule_year'); // Tahun jadwal
            $table->integer('schedule_month'); // Bulan jadwal (1-12)
            $table->date('schedule_date'); // Tanggal spesifik (2024-01-01)

            // Shift info
            $table->enum('shift_type', ['work', 'off']); // work = kerja, off = libur
            $table->time('shift_start')->default('08:00:00'); // Jam mulai kerja
            $table->time('shift_end')->default('17:00:00'); // Jam selesai kerja

            // Status
            $table->enum('status', ['scheduled', 'worked', 'absent', 'leave'])->default('scheduled');

            // Notes
            $table->text('notes')->nullable();

            // Creator info
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('published_at')->nullable(); // Kapan jadwal dipublish (tgl 25)

            $table->timestamps();

            // Unique constraint: 1 CS hanya punya 1 jadwal per hari
            $table->unique(['cs_profile_id', 'schedule_date'], 'shift_schedule_unique');

            // Indexes
            $table->index('cs_profile_id');
            $table->index(['schedule_year', 'schedule_month']);
            $table->index('schedule_date');
            $table->index('shift_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_schedules');
    }
};
