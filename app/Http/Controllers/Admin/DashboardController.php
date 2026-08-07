<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Kunjungan;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalBuku = Buku::sum('stok');
        $bukuTersedia = Buku::sum('stok_tersedia');
        $totalPeminjaman = Peminjaman::where('status', 'dipinjam')->count();

        // Mahasiswa yang sedang di perpustakaan (belum keluar)
        $mahasiswaDiPerpustakaan = Kunjungan::whereNull('waktu_keluar')
            ->whereDate('waktu_masuk', Carbon::today())
            ->with('user')
            ->latest()
            ->get();

        // Chart data - Kunjungan 7 hari terakhir
        $kunjunganChart = Kunjungan::select(
                DB::raw('DATE(waktu_masuk) as tanggal'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->where('waktu_masuk', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Chart data - Peminjaman per bulan (6 bulan terakhir)
        $peminjamanChart = Peminjaman::select(
                DB::raw('MONTH(tanggal_pinjam) as bulan'),
                DB::raw('YEAR(tanggal_pinjam) as tahun'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->where('tanggal_pinjam', '>=', Carbon::now()->subMonths(6))
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();

        // Buku paling sering dipinjam - Menggunakan withCount (lebih clean)
        $bukuPopuler = Buku::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function($buku) {
                $buku->total_pinjam = $buku->peminjaman_count;
                return $buku;
            });

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalBuku',
            'bukuTersedia',
            'totalPeminjaman',
            'mahasiswaDiPerpustakaan',
            'kunjunganChart',
            'peminjamanChart',
            'bukuPopuler'
        ));
    }
}