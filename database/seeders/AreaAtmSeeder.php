<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Area;
use App\Models\Atm;
use App\Models\CsProfile;

class AreaAtmSeeder extends Seeder
{
    public function run(): void
    {
        // Area 1: Cikini
        $areaCikini = Area::create([
            'nama_area' => 'ATM Cikini',
            'keterangan' => 'Area ATM di sekitar Cikini, Jakarta Pusat',
            'is_active' => true,
        ]);

        Atm::create([
            'area_id' => $areaCikini->id,
            'nama_atm' => 'ATM BCA Cikini',
            'lokasi' => 'Jakarta Pusat',
            'alamat_lengkap' => 'Jl. Cikini Raya No. 10, Jakarta Pusat',
            'is_active' => true,
        ]);

        Atm::create([
            'area_id' => $areaCikini->id,
            'nama_atm' => 'ATM Mandiri Menteng',
            'lokasi' => 'Jakarta Pusat',
            'alamat_lengkap' => 'Jl. Menteng Raya No. 25, Jakarta Pusat',
            'is_active' => true,
        ]);

        // Area 2: Serpong
        $areaSerpong = Area::create([
            'nama_area' => 'ATM Serpong',
            'keterangan' => 'Area ATM di sekitar Serpong, Tangerang Selatan',
            'is_active' => true,
        ]);

        Atm::create([
            'area_id' => $areaSerpong->id,
            'nama_atm' => 'ATM BNI BSD',
            'lokasi' => 'Tangerang Selatan',
            'alamat_lengkap' => 'Jl. BSD Raya No. 100, BSD City',
            'is_active' => true,
        ]);

        Atm::create([
            'area_id' => $areaSerpong->id,
            'nama_atm' => 'ATM BCA Gading Serpong',
            'lokasi' => 'Tangerang Selatan',
            'alamat_lengkap' => 'Jl. Gading Serpong Boulevard, Gading Serpong',
            'is_active' => true,
        ]);

        // Area 3: Sudirman
        $areaSudirman = Area::create([
            'nama_area' => 'ATM Sudirman',
            'keterangan' => 'Area ATM di sekitar Sudirman, Jakarta Selatan',
            'is_active' => true,
        ]);

        Atm::create([
            'area_id' => $areaSudirman->id,
            'nama_atm' => 'ATM BRI Sudirman',
            'lokasi' => 'Jakarta Selatan',
            'alamat_lengkap' => 'Jl. Jend. Sudirman Kav. 44-46, Jakarta Selatan',
            'is_active' => true,
        ]);

        Atm::create([
            'area_id' => $areaSudirman->id,
            'nama_atm' => 'ATM CIMB Niaga Plaza Indonesia',
            'lokasi' => 'Jakarta Pusat',
            'alamat_lengkap' => 'Plaza Indonesia, Jl. M.H. Thamrin, Jakarta Pusat',
            'is_active' => true,
        ]);

        // Assign Area ke CS
        $cs1 = CsProfile::find(1); // Andi
        $cs2 = CsProfile::find(2); // Budi
        $cs3 = CsProfile::find(3); // Citra

        if ($cs1) {
            $cs1->areas()->attach([$areaCikini->id, $areaSudirman->id]);
        }

        if ($cs2) {
            $cs2->areas()->attach([$areaSerpong->id]);
        }

        if ($cs3) {
            $cs3->areas()->attach([$areaCikini->id]);
        }
    }
}
