<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim_nip', 'like', "%{$search}%");
            });
        }

        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('waktu_masuk', $request->tanggal);
        } else {
            // Default: tampilkan kunjungan hari ini
            $query->whereDate('waktu_masuk', Carbon::today());
        }

        if ($request->has('status')) {
            if ($request->status === 'aktif') {
                $query->whereNull('waktu_keluar');
            } elseif ($request->status === 'selesai') {
                $query->whereNotNull('waktu_keluar');
            }
        }

        $kunjungan = $query->latest('waktu_masuk')->paginate(15);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function show(Kunjungan $kunjungan)
    {
        $kunjungan->load('user');

        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    public function checkout(Kunjungan $kunjungan)
    {
        if ($kunjungan->waktu_keluar) {
            return back()->with('error', 'Kunjungan sudah selesai!');
        }

        $kunjungan->update([
            'waktu_keluar' => Carbon::now(),
        ]);

        return redirect()->route('admin.kunjungan.index')
            ->with('success', 'Mahasiswa berhasil check-out!');
    }
}