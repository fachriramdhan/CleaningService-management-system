<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\CsProfile;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@cleaning.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Koordinator
        User::create([
            'name' => 'Koordinator CS',
            'email' => 'koordinator@cleaning.com',
            'password' => Hash::make('password'),
            'role' => 'koordinator',
            'is_active' => true,
        ]);

        // CS 1
        $cs1 = User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@cleaning.com',
            'password' => Hash::make('password'),
            'role' => 'cs',
            'is_active' => true,
        ]);

        CsProfile::create([
            'user_id' => $cs1->id,
            'foto' => 'default-avatar.png',
            'tanggal_mulai_kerja' => Carbon::parse('2023-01-15'),
            'lama_kerja_tahun' => 2,
            'lama_kerja_bulan' => 0,
            'is_active' => true,
        ]);

        // CS 2
        $cs2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@cleaning.com',
            'password' => Hash::make('password'),
            'role' => 'cs',
            'is_active' => true,
        ]);

        CsProfile::create([
            'user_id' => $cs2->id,
            'foto' => 'default-avatar.png',
            'tanggal_mulai_kerja' => Carbon::parse('2023-06-01'),
            'lama_kerja_tahun' => 1,
            'lama_kerja_bulan' => 8,
            'is_active' => true,
        ]);

        // CS 3
        $cs3 = User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra@cleaning.com',
            'password' => Hash::make('password'),
            'role' => 'cs',
            'is_active' => true,
        ]);

        CsProfile::create([
            'user_id' => $cs3->id,
            'foto' => 'default-avatar.png',
            'tanggal_mulai_kerja' => Carbon::parse('2024-03-10'),
            'lama_kerja_tahun' => 0,
            'lama_kerja_bulan' => 11,
            'is_active' => true,
        ]);
    }
}
