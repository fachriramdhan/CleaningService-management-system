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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cs_profile_id')->constrained('cs_profiles')->onDelete('cascade');
            $table->enum('document_type', ['ktp', 'kk', 'ijazah', 'rekening']); // Jenis dokumen
            $table->string('document_number')->nullable(); // Nomor dokumen (NIK, No. KK, dll)
            $table->string('file_path'); // Path file di storage
            $table->string('original_filename'); // Nama file asli
            $table->string('file_size')->nullable(); // Ukuran file (KB)
            $table->timestamp('uploaded_at'); // Waktu upload
            $table->boolean('is_verified')->default(false); // Sudah diverifikasi admin?
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('notes')->nullable(); // Catatan dari admin
            $table->timestamps();
            $table->softDeletes(); // Soft delete untuk history

            // Indexes
            $table->index('cs_profile_id');
            $table->index('document_type');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};
