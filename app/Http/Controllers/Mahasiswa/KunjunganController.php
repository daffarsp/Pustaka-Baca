<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class KunjunganController extends Controller
{
    public function create()
    {
        $user = auth()->user();

        // Cek apakah sudah check-in hari ini
        $sudahCheckIn = Kunjungan::where('user_id', $user->id)
            ->whereDate('waktu_masuk', Carbon::today())
            ->whereNull('waktu_keluar')
            ->exists();

        if ($sudahCheckIn) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah melakukan check-in hari ini!');
        }

        return view('mahasiswa.kunjungan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        // Cek lagi apakah sudah check-in
        $sudahCheckIn = Kunjungan::where('user_id', $user->id)
            ->whereDate('waktu_masuk', Carbon::today())
            ->whereNull('waktu_keluar')
            ->exists();

        if ($sudahCheckIn) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('info', 'Anda sudah melakukan check-in hari ini!');
        }

        // Upload foto
        $fotoPath = $request->file('foto')->store('kunjungan', 'public');

        Kunjungan::create([
            'user_id' => $user->id,
            'foto_kunjungan' => $fotoPath,
            'waktu_masuk' => Carbon::now(),
        ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Check-in berhasil! Selamat datang di perpustakaan.');
    }

    public function checkout()
    {
        $user = auth()->user();

        $kunjungan = Kunjungan::where('user_id', $user->id)
            ->whereDate('waktu_masuk', Carbon::today())
            ->whereNull('waktu_keluar')
            ->first();

        if (!$kunjungan) {
            return redirect()->route('mahasiswa.dashboard')
                ->with('error', 'Anda belum melakukan check-in hari ini!');
        }

        $kunjungan->update([
            'waktu_keluar' => Carbon::now(),
        ]);

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Check-out berhasil! Terima kasih sudah berkunjung.');
    }
}