<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%");
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $buku = $query->latest()->paginate(10);
        $kategoris = Buku::distinct()->pluck('kategori');

        return view('admin.buku.index', compact('buku', 'kategoris'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|unique:buku',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['stok_tersedia'] = $validated['stok'];

        Buku::create($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        $buku->load(['peminjaman' => function($query) {
            $query->latest()->limit(10);
        }]);

        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|unique:buku,kode_buku,' . $buku->id,
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'isbn' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        // Hitung selisih stok
        $selisihStok = $validated['stok'] - $buku->stok;
        $validated['stok_tersedia'] = $buku->stok_tersedia + $selisihStok;

        // Pastikan stok tersedia tidak negatif
        if ($validated['stok_tersedia'] < 0) {
            $validated['stok_tersedia'] = 0;
        }

        $buku->update($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Buku $buku)
    {
        // Cek apakah ada peminjaman aktif
        if ($buku->peminjaman()->where('status', 'dipinjam')->exists()) {
            return redirect()->route('admin.buku.index')
                ->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam!');
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}