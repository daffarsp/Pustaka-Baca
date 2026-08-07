@extends('layouts.app')

@section('title', $buku->judul)

@section('content')
<div class="mb-3">
    <a href="{{ route('mahasiswa.buku.index') }}" class="btn btn-outline-secondary btn-sm rounded-2">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-teal-subtle text-teal fw-bold fs-6" style="background-color: #ccfbf1; color: #0f766e;">
                        Kode Buku: {{ $buku->kode_buku }}
                    </span>
                    @if($buku->kategori)
                        <span class="badge bg-secondary text-white">
                            {{ $buku->kategori }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body p-4">
                <h2 class="fw-bold text-dark mb-3">{{ $buku->judul }}</h2>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-person me-1"></i> Penulis</small>
                            <span class="fw-bold text-dark">{{ $buku->penulis }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-building me-1"></i> Penerbit & Tahun</small>
                            <span class="fw-bold text-dark">{{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-barcode me-1"></i> Nomor ISBN</small>
                            <span class="fw-bold text-dark">{{ $buku->isbn ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block mb-1"><i class="bi bi-box-seam me-1"></i> Status Ketersediaan</small>
                            @if($buku->stok_tersedia > 0)
                                <span class="badge bg-success fw-bold">
                                    <i class="bi bi-check-circle me-1"></i> Tersedia ({{ $buku->stok_tersedia }} dari {{ $buku->stok }})
                                </span>
                            @else
                                <span class="badge bg-danger fw-bold">
                                    <i class="bi bi-x-circle me-1"></i> Stok Habis
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold text-dark mb-2">Deskripsi Buku</h5>
                <p class="text-secondary leading-relaxed mb-0" style="white-space: pre-line;">
                    {{ $buku->deskripsi ?? 'Belum ada deskripsi lengkap untuk buku ini.' }}
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-teal text-white py-3" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%);">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-bookmark-plus me-2"></i> Ajukan Peminjaman</h5>
            </div>
            <div class="card-body p-4">
                @if($sedangDipinjam)
                    <div class="alert alert-warning mb-0" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <strong>Anda sedang meminjam buku ini!</strong>
                        <p class="small mb-0 mt-1">Harap kembalikan peminjaman aktif terlebih dahulu di perpustakaan.</p>
                    </div>
                @elseif($buku->stok_tersedia <= 0)
                    <div class="alert alert-danger mb-0" role="alert">
                        <i class="bi bi-x-circle-fill me-1"></i>
                        <strong>Stok tidak tersedia!</strong>
                        <p class="small mb-0 mt-1">Semua eksemplar buku ini sedang dipinjam oleh mahasiswa lain.</p>
                    </div>
                @else
                    <form method="POST" action="{{ route('mahasiswa.buku.pinjam', $buku->id) }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Durasi Peminjaman</label>
                            <select name="durasi_hari" class="form-select" required>
                                <option value="3">3 Hari</option>
                                <option value="7" selected>7 Hari (Standar)</option>
                                <option value="14">14 Hari (Maksimal)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Catatan / Keterangan (Opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Untuk referensi tugas akhir"></textarea>
                        </div>

                        <div class="p-3 bg-light rounded-3 mb-3 border">
                            <small class="text-muted d-block">Ketentuan Peminjaman:</small>
                            <ul class="small text-secondary mb-0 ps-3 mt-1">
                                <li>Denda keterlambatan Rp 2.000 / hari.</li>
                                <li>Pengambilan buku langsung di loket perpustakaan.</li>
                            </ul>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3">
                            <i class="bi bi-check-circle me-1"></i> Konfirmasi Pinjam Buku
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
