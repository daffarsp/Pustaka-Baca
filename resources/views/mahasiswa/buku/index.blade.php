@extends('layouts.app')

@section('title', 'Katalog Buku')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 text-dark fw-bold mb-1"><i class="bi bi-journal-bookmark-fill me-2 text-teal" style="color: #0d9488;"></i> Katalog Koleksi Buku</h1>
        <p class="text-muted mb-0">Jelajahi dan cari koleksi buku perpustakaan untuk dipinjam secara langsung.</p>
    </div>
</div>

<!-- Search & Filter Card -->
<div class="card mb-4 border-0 shadow-sm rounded-3">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('mahasiswa.buku.index') }}" class="row g-2">
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-teal" style="color: #0d9488;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Cari judul buku, penulis, penerbit, atau kode..." 
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                @if(request('search') || request('kategori'))
                    <a href="{{ route('mahasiswa.buku.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Books Grid -->
<div class="row g-4">
    @forelse($buku as $item)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition rounded-3 overflow-hidden">
                <div class="card-header bg-gradient bg-light py-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="badge bg-teal-subtle text-teal fw-bold" style="background-color: #ccfbf1; color: #0f766e;">
                        {{ $item->kode_buku }}
                    </span>
                    @if($item->kategori)
                        <span class="badge bg-secondary-subtle text-secondary small">
                            {{ $item->kategori }}
                        </span>
                    @endif
                </div>
                <div class="card-body d-flex flex-column p-3">
                    <h5 class="card-title fw-bold text-dark mb-2 text-truncate" title="{{ $item->judul }}">
                        {{ $item->judul }}
                    </h5>
                    <p class="card-text text-muted small mb-1">
                        <i class="bi bi-person me-1"></i> {{ $item->penulis }}
                    </p>
                    <p class="card-text text-muted small mb-3">
                        <i class="bi bi-building me-1"></i> {{ $item->penerbit }} ({{ $item->tahun_terbit }})
                    </p>
                    
                    @if($item->deskripsi)
                        <p class="card-text small text-secondary mb-3 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            {{ $item->deskripsi }}
                        </p>
                    @endif

                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">Stok Tersedia:</small>
                            @if($item->stok_tersedia > 0)
                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-semibold">
                                    <i class="bi bi-check-circle me-1"></i> {{ $item->stok_tersedia }} dari {{ $item->stok }}
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-semibold">
                                    <i class="bi bi-x-circle me-1"></i> Habis
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('mahasiswa.buku.show', $item->id) }}" class="btn btn-outline-teal btn-sm fw-semibold rounded-2" style="color: #0d9488; border-color: #0d9488;">
                            Detail <i class="bi bi-chevron-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="text-muted">
                <i class="bi bi-search display-1 d-block mb-3 opacity-25"></i>
                <h5 class="fw-bold">Tidak ada buku ditemukan</h5>
                <p>Coba gunakan kata kunci atau filter kategori yang berbeda.</p>
                <a href="{{ route('mahasiswa.buku.index') }}" class="btn btn-primary btn-sm mt-2">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Pencarian
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $buku->links() }}
</div>
@endsection
