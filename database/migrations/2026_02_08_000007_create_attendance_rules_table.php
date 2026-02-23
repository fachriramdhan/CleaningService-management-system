<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_rules', function (Blueprint $table) {
            $table->id();
            $table->string('rule_name'); // Nama rule (misal: "Standard Working Hours")
            $table->text('description')->nullable();

            // Check-in rules (Absen Masuk)
            $table->time('checkin_start')->default('05:00:00'); // Mulai bisa absen jam 5 pagi
            $table->time('checkin_end')->default('08:00:00'); // Batas maksimal absen masuk jam 8 pagi
            $table->time('checkin_on_time')->default('08:00:00'); // Dianggap tepat waktu jika <= jam 8

            // Check-out rules (Absen Pulang)
            $table->time('checkout_max')->default('17:00:00'); // Maksimal pulang jam 5 sore
            $table->time('checkout_min')->nullable(); // Minimal kerja berapa jam (optional)

            // Penalty & scoring rules
            $table->integer('late_tolerance_minutes')->default(0); // Toleransi telat (0 = no tolerance)
            $table->integer('early_checkout_penalty')->default(0); // Penalty pulang cepat (dalam menit)

            // Active status
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Index
            $table->index('is_active');
        });

        // Insert default rule
        DB::table('attendance_rules')->insert([
            'rule_name' => 'Standard Working Hours 2024',
            'description' => 'Aturan absensi standar: Masuk 05:00-08:00, Pulang max 17:00',
            'checkin_start' => '05:00:00',
            'checkin_end' => '08:00:00',
            'checkin_on_time' => '08:00:00',
            'checkout_max' => '17:00:00',
            'late_tolerance_minutes' => 0,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_rules');
    }
};
