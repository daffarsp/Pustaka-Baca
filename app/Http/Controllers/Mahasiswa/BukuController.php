<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $buku = $query->latest()->paginate(12);
        $kategoris = Buku::distinct()->pluck('kategori')->filter();

        return view('mahasiswa.buku.index', compact('buku', 'kategoris'));
    }

    public function show(Buku $buku)
    {
        $user = auth()->user();
        $sedangDipinjam = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->exists();

        return view('mahasiswa.buku.show', compact('buku', 'sedangDipinjam'));
    }

    public function pinjam(Request $request, Buku $buku)
    {
        $user = auth()->user();

        if ($buku->stok_tersedia <= 0) {
            return back()->with('error', 'Maaf, stok buku ini sedang habis!');
        }

        $sedangDipinjam = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($sedangDipinjam) {
            return back()->with('error', 'Anda masih meminjam buku ini. Kembalikan terlebih dahulu sebelum meminjam lagi.');
        }

        $validated = $request->validate([
            'durasi_hari' => 'required|integer|min:1|max:14',
            'catatan' => 'nullable|string|max:255',
        ]);

        $durasi = (int) $validated['durasi_hari'];
        $tanggalRencana = Carbon::today()->addDays($durasi);

        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_kembali_rencana' => $tanggalRencana,
            'status' => 'dipinjam',
            'catatan' => $validated['catatan'] ?? 'Peminjaman mandiri via Katalog Online Mahasiswa',
        ]);

        $buku->decrement('stok_tersedia');

        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Buku "' . $buku->judul . '" berhasil dipinjam! Harap dikembalikan sebelum ' . $tanggalRencana->isoFormat('D MMMM Y'));
    }
}
