<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cek apakah sudah check-in hari ini
        $kunjunganHariIni = Kunjungan::where('user_id', $user->id)
            ->whereDate('waktu_masuk', Carbon::today())
            ->whereNull('waktu_keluar')
            ->first();

        // Riwayat peminjaman aktif
        $peminjamanAktif = Peminjaman::where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->with('buku')
            ->get();

        // Riwayat kunjungan (10 terakhir)
        $riwayatKunjungan = Kunjungan::where('user_id', $user->id)
            ->latest()
            ->limit(10)
            ->get();

        // Riwayat peminjaman (10 terakhir)
        $riwayatPeminjaman = Peminjaman::where('user_id', $user->id)
            ->with('buku')
            ->latest()
            ->limit(10)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'kunjunganHariIni',
            'peminjamanAktif',
            'riwayatKunjungan',
            'riwayatPeminjaman'
        ));
    }
}