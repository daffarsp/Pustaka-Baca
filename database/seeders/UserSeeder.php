<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Default
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perpustakaan.com',
            'nim_nip' => 'ADM001',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Mahasiswa Contoh
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@student.com',
            'nim_nip' => '2024001',
            'role' => 'mahasiswa',
            'jurusan' => 'Teknik Informatika',
            'no_telepon' => '081234567890',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Siti Rahma',
            'email' => 'siti@student.com',
            'nim_nip' => '2024002',
            'role' => 'mahasiswa',
            'jurusan' => 'Sistem Informasi',
            'no_telepon' => '081234567891',
            'password' => Hash::make('password'),
        ]);
    }
}