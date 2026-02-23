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
        Schema::table('cs_profiles', function (Blueprint $table) {
            // Employee Self-Service fields (removed ->after() to avoid column position errors)
            $table->text('alamat_lengkap')->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->string('no_wa', 20)->nullable();

            // Emergency Contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->string('emergency_contact_relation')->nullable();

            // Personal Info (untuk dokumentasi)
            $table->string('nik', 20)->nullable();
            $table->string('no_kk', 20)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->enum('status_pernikahan', ['belum_menikah', 'menikah', 'cerai'])->nullable();

            // Bank Account Info
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();

            // Employment Info
            $table->date('tanggal_bergabung')->nullable();
            $table->enum('status_karyawan', ['kontrak', 'tetap', 'probation'])->default('probation');

            // Indexes
            $table->index('nik');
            $table->index('no_hp');
            $table->index('tanggal_bergabung');
            $table->index('status_karyawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cs_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'alamat_lengkap',
                'no_hp',
                'no_wa',
                'emergency_contact_name',
                'emergency_contact_phone',
                'emergency_contact_relation',
                'nik',
                'no_kk',
                'tanggal_lahir',
                'tempat_lahir',
                'jenis_kelamin',
                'status_pernikahan',
                'bank_name',
                'bank_account_number',
                'bank_account_name',
                'tanggal_bergabung',
                'status_karyawan',
            ]);
        });
    }
};
