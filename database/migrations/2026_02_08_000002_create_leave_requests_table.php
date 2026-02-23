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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_profile_id')->constrained('cs_profiles')->onDelete('cascade');
            $table->enum('leave_type', ['annual', 'sick', 'emergency', 'unpaid']); // Jenis cuti
            $table->date('start_date'); // Tanggal mulai cuti
            $table->date('end_date'); // Tanggal selesai cuti
            $table->integer('total_days'); // Total hari cuti (calculated)
            $table->text('reason'); // Alasan cuti
            $table->string('attachment')->nullable(); // Lampiran (misal: surat dokter untuk sakit)

            // Status approval workflow
            $table->enum('status', ['pending', 'approved_koordinator', 'approved_admin', 'rejected_koordinator', 'rejected_admin'])->default('pending');

            // Koordinator approval
            $table->foreignId('koordinator_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('koordinator_approved_at')->nullable();
            $table->text('koordinator_notes')->nullable();

            // Admin approval
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('admin_approved_at')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Soft delete untuk history

            // Indexes
            $table->index('cs_profile_id');
            $table->index('leave_type');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
