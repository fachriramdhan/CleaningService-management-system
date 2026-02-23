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
        Schema::create('performance_kpi_templates', function (Blueprint $table) {
            $table->id();
            $table->string('kpi_code')->unique(); // Code: 'punctuality', 'work_quality', etc
            $table->string('kpi_name'); // Nama KPI: "Ketepatan Waktu"
            $table->text('description'); // Deskripsi KPI
            $table->integer('weight')->default(25); // Bobot % (total 100%)
            $table->integer('min_score')->default(1); // Min score (1)
            $table->integer('max_score')->default(5); // Max score (5)
            $table->json('scoring_guide')->nullable(); // Guide penilaian (JSON)
            $table->integer('sort_order')->default(0); // Urutan tampilan
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Index
            $table->index('is_active');
            $table->index('sort_order');
        });

        // Insert default KPI templates
        DB::table('performance_kpi_templates')->insert([
            [
                'kpi_code' => 'punctuality',
                'kpi_name' => 'Ketepatan Waktu',
                'description' => 'Penilaian ketepatan waktu absen masuk (05:00-08:00)',
                'weight' => 25,
                'min_score' => 1,
                'max_score' => 5,
                'scoring_guide' => json_encode([
                    '5' => 'Selalu tepat waktu (0 keterlambatan)',
                    '4' => 'Hampir selalu tepat waktu (1-2 keterlambatan)',
                    '3' => 'Kadang terlambat (3-5 keterlambatan)',
                    '2' => 'Sering terlambat (6-10 keterlambatan)',
                    '1' => 'Sangat sering terlambat (>10 keterlambatan)',
                ]),
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kpi_code' => 'work_quality',
                'kpi_name' => 'Kualitas Kerja',
                'description' => 'Penilaian kualitas hasil pembersihan ATM',
                'weight' => 30,
                'min_score' => 1,
                'max_score' => 5,
                'scoring_guide' => json_encode([
                    '5' => 'Sangat baik - Selalu bersih maksimal, foto jelas',
                    '4' => 'Baik - Bersih & rapi, foto cukup jelas',
                    '3' => 'Cukup - Ada beberapa area kurang bersih',
                    '2' => 'Kurang - Banyak area tidak bersih',
                    '1' => 'Sangat kurang - Tidak bersih sama sekali',
                ]),
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kpi_code' => 'attendance',
                'kpi_name' => 'Kehadiran',
                'description' => 'Penilaian kehadiran kerja dalam sebulan',
                'weight' => 25,
                'min_score' => 1,
                'max_score' => 5,
                'scoring_guide' => json_encode([
                    '5' => 'Sempurna (0 absen tanpa keterangan)',
                    '4' => 'Sangat baik (1 absen dengan izin)',
                    '3' => 'Baik (2-3 absen dengan izin)',
                    '2' => 'Cukup (4-5 absen atau 1 tanpa izin)',
                    '1' => 'Kurang (>5 absen atau >1 tanpa izin)',
                ]),
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kpi_code' => 'checkout_time',
                'kpi_name' => 'Jam Pulang',
                'description' => 'Penilaian kedisiplinan jam pulang (maksimal 17:00)',
                'weight' => 20,
                'min_score' => 1,
                'max_score' => 5,
                'scoring_guide' => json_encode([
                    '5' => 'Selalu pulang <= 17:00 (0 pelanggaran)',
                    '4' => 'Hampir selalu tepat (1-2 kali >17:00)',
                    '3' => 'Kadang terlambat (3-5 kali >17:00)',
                    '2' => 'Sering terlambat (6-10 kali >17:00)',
                    '1' => 'Sangat sering terlambat (>10 kali >17:00)',
                ]),
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_kpi_templates');
    }
};
