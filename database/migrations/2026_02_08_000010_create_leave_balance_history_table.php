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
        Schema::create('leave_balance_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_quota_id')->constrained('leave_quotas')->onDelete('cascade');
            $table->foreignId('leave_request_id')->nullable()->constrained('leave_requests')->onDelete('set null');
            $table->enum('leave_type', ['annual', 'sick', 'emergency', 'unpaid']);
            $table->enum('transaction_type', ['used', 'refund', 'adjustment', 'reset']); // used=pakai, refund=kembalikan, adjustment=koreksi, reset=reset tahunan
            $table->integer('amount'); // Jumlah hari (bisa + atau -)
            $table->integer('balance_before'); // Saldo sebelum transaksi
            $table->integer('balance_after'); // Saldo setelah transaksi
            $table->text('notes')->nullable(); // Catatan transaksi
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            // Indexes
            $table->index('leave_quota_id');
            $table->index('leave_request_id');
            $table->index('transaction_type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_balance_history');
    }
};
