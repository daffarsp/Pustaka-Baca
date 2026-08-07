<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku', 'adminPinjam']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nim_nip', 'like', "%{$search}%");
            })->orWhereHas('buku', function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $peminjaman = $query->latest()->paginate(15);

        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        $buku = Buku::where('stok_tersedia', '>', 0)->get();

        return view('admin.peminjaman.create', compact('mahasiswa', 'buku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tanggal_kembali_rencana' => 'required|date|after:today',
            'catatan' => 'nullable|string',
        ]);

        // Cek ketersediaan buku
        $buku = Buku::find($validated['buku_id']);
        if ($buku->stok_tersedia <= 0) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam!');
        }

        // Cek apakah user sudah meminjam buku yang sama dan belum dikembalikan
        $existingPeminjaman = Peminjaman::where('user_id', $validated['user_id'])
            ->where('buku_id', $validated['buku_id'])
            ->where('status', 'dipinjam')
            ->exists();

        if ($existingPeminjaman) {
            return back()->with('error', 'Mahasiswa masih meminjam buku ini!');
        }

        $validated['tanggal_pinjam'] = Carbon::today();
        $validated['admin_pinjam_id'] = auth()->id();
        $validated['status'] = 'dipinjam';

        Peminjaman::create($validated);

        // Kurangi stok tersedia
        $buku->decrement('stok_tersedia');

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku', 'adminPinjam', 'adminKembali']);

        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function pengembalian(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Buku sudah dikembalikan!');
        }

        $tanggalKembali = Carbon::today();
        $denda = 0;

        // Hitung denda jika terlambat
        if ($tanggalKembali->gt($peminjaman->tanggal_kembali_rencana)) {
            $hariTerlambat = $tanggalKembali->diffInDays($peminjaman->tanggal_kembali_rencana);
            $denda = $hariTerlambat * 2000; // Rp 2.000 per hari
        }

        $peminjaman->update([
            'tanggal_kembali_aktual' => $tanggalKembali,
            'status' => $denda > 0 ? 'terlambat' : 'dikembalikan',
            'denda' => $denda,
            'admin_kembali_id' => auth()->id(),
        ]);

        // Tambah stok tersedia
        $peminjaman->buku->increment('stok_tersedia');

        $message = $denda > 0 
            ? "Buku berhasil dikembalikan dengan denda Rp " . number_format($denda, 0, ',', '.')
            : "Buku berhasil dikembalikan!";

        return redirect()->route('admin.peminjaman.index')
            ->with('success', $message);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Hanya bisa hapus jika sudah dikembalikan
        if ($peminjaman->status === 'dipinjam') {
            return back()->with('error', 'Tidak dapat menghapus peminjaman yang masih aktif!');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }
}