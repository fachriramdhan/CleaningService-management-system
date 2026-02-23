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
        // Skip if table already exists
        if (Schema::hasTable('performance_reviews')) {
            return;
        }

        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_profile_id')->constrained('cs_profiles')->onDelete('cascade');
            $table->year('review_year'); // Tahun review (2024, 2025)
            $table->integer('review_month'); // Bulan review (1-12)
            $table->date('review_period_start'); // Periode awal (misal: 2024-01-01)
            $table->date('review_period_end'); // Periode akhir (misal: 2024-01-31)

            // KPI Scores (1-5)
            $table->integer('punctuality_score')->nullable(); // Ketepatan Waktu (absen masuk & pulang)
            $table->integer('work_quality_score')->nullable(); // Kualitas Kerja
            $table->integer('attendance_score')->nullable(); // Kehadiran
            $table->integer('checkout_time_score')->nullable(); // Jam Pulang (max 17:00)

            // Average & Total
            $table->decimal('average_score', 3, 2)->nullable(); // Rata-rata (1.00 - 5.00)
            $table->integer('total_score')->nullable(); // Total (4 - 20)

            // Reviewer info
            $table->foreignId('koordinator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('koordinator_reviewed_at')->nullable();
            $table->text('koordinator_notes')->nullable();

            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('admin_reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();

            // Overall notes & recommendation
            $table->text('overall_notes')->nullable();
            $table->text('improvement_plan')->nullable(); // Rencana perbaikan
            $table->text('achievement_notes')->nullable(); // Pencapaian

            // Status
            $table->enum('status', ['draft', 'submitted_koordinator', 'submitted_admin', 'completed'])->default('draft');

            $table->timestamps();

            // Unique constraint: 1 CS hanya punya 1 review per bulan
            $table->unique(['cs_profile_id', 'review_year', 'review_month'], 'perf_review_unique');

            // Indexes
            $table->index('cs_profile_id');
            $table->index(['review_year', 'review_month']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
