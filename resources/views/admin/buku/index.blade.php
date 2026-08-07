@extends('layouts.app')

@section('title', 'Kelola Buku')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1"><i class="bi bi-book me-2 text-teal" style="color: #0d9488;"></i> Kelola Koleksi Buku</h1>
        <p class="text-muted mb-0">Manajemen katalog, pengolahan data buku, dan informasi ketersediaan stok.</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary fw-semibold">
            <i class="bi bi-printer me-1"></i> Cetak Katalog Buku
        </button>
        <a href="{{ route('admin.buku.create') }}" class="btn btn-primary fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Tambah Buku Baru
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <!-- Filter & Search -->
        <form method="GET" class="row g-3 mb-4 no-print">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-teal" style="color: #0d9488;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari judul, penulis, penerbit, atau kode buku..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') === $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary" title="Reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Kategori</th>
                        <th>Stok Total</th>
                        <th>Stok Tersedia</th>
                        <th class="no-print" width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $index => $item)
                    <tr>
                        <td class="fw-semibold">{{ $buku->firstItem() + $index }}</td>
                        <td><span class="badge bg-teal-subtle text-teal fw-bold" style="background-color:#ccfbf1; color:#0f766e;">{{ $item->kode_buku }}</span></td>
                        <td><strong class="text-dark">{{ $item->judul }}</strong></td>
                        <td><small class="text-secondary">{{ $item->penulis }}</small></td>
                        <td><small class="text-secondary">{{ $item->penerbit }}</small></td>
                        <td><span class="badge bg-light text-dark border">{{ $item->tahun_terbit }}</span></td>
                        <td><span class="badge bg-secondary-subtle text-secondary">{{ $item->kategori ?? 'Umum' }}</span></td>
                        <td><span class="fw-bold">{{ $item->stok }}</span></td>
                        <td>
                            @if($item->stok_tersedia > 0)
                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold">
                                    {{ $item->stok_tersedia }}
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-bold">
                                    0 (Habis)
                                </span>
                            @endif
                        </td>
                        <td class="no-print">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.buku.show', $item) }}" class="btn btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.buku.edit', $item) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.buku.destroy', $item) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted py-5">
                            <i class="bi bi-book display-4 d-block mb-2 opacity-25"></i>
                            Tidak ada data buku ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 no-print">
            {{ $buku->links() }}
        </div>
    </div>
</div>
@endsection