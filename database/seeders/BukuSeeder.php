<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $bukuList = [
            [
                'kode_buku' => 'BK001',
                'judul' => 'Pemrograman Web dengan Laravel',
                'penulis' => 'John Doe',
                'penerbit' => 'Tech Publisher',
                'tahun_terbit' => 2023,
                'isbn' => '978-1234567890',
                'stok' => 5,
                'stok_tersedia' => 5,
                'kategori' => 'Teknologi',
                'deskripsi' => 'Buku panduan lengkap pemrograman web menggunakan framework Laravel'
            ],
            [
                'kode_buku' => 'BK002',
                'judul' => 'Database Management System',
                'penulis' => 'Jane Smith',
                'penerbit' => 'Data Press',
                'tahun_terbit' => 2022,
                'isbn' => '978-0987654321',
                'stok' => 3,
                'stok_tersedia' => 3,
                'kategori' => 'Teknologi',
                'deskripsi' => 'Konsep dan implementasi sistem manajemen database'
            ],
            [
                'kode_buku' => 'BK003',
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Robert Johnson',
                'penerbit' => 'Code Books',
                'tahun_terbit' => 2023,
                'isbn' => '978-1122334455',
                'stok' => 4,
                'stok_tersedia' => 4,
                'kategori' => 'Teknologi',
                'deskripsi' => 'Pemahaman mendalam tentang algoritma dan struktur data'
            ],
            [
                'kode_buku' => 'BK004',
                'judul' => 'Kalkulus untuk Teknik',
                'penulis' => 'Prof. Ahmad',
                'penerbit' => 'Matematika Press',
                'tahun_terbit' => 2021,
                'isbn' => '978-5566778899',
                'stok' => 6,
                'stok_tersedia' => 6,
                'kategori' => 'Matematika',
                'deskripsi' => 'Buku kalkulus untuk mahasiswa teknik'
            ],
            [
                'kode_buku' => 'BK005',
                'judul' => 'Bahasa Indonesia yang Baik dan Benar',
                'penulis' => 'Dr. Susi',
                'penerbit' => 'Bahasa Publisher',
                'tahun_terbit' => 2022,
                'isbn' => '978-9988776655',
                'stok' => 7,
                'stok_tersedia' => 7,
                'kategori' => 'Bahasa',
                'deskripsi' => 'Panduan penggunaan bahasa Indonesia yang baik dan benar'
            ],
        ];

        foreach ($bukuList as $buku) {
            Buku::create($buku);
        }
    }
}