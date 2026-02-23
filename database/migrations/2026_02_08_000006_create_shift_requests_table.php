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
        Schema::create('shift_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_profile_id')->constrained('cs_profiles')->onDelete('cascade');
            $table->year('request_year'); // Tahun request
            $table->integer('request_month'); // Bulan request (untuk jadwal bulan depan)
            $table->date('requested_date'); // Tanggal yang diminta libur
            $table->text('reason')->nullable(); // Alasan request libur

            // Status approval
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();

            // Request period tracking
            $table->timestamp('request_submitted_at'); // Kapan CS submit (harus tgl 23-24)

            $table->timestamps();

            // Indexes
            $table->index('cs_profile_id');
            $table->index(['request_year', 'request_month']);
            $table->index('requested_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_requests');
    }
};
