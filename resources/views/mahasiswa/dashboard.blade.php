@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1"><i class="bi bi-house-door me-2 text-teal" style="color: #0d9488;"></i> Dashboard Mahasiswa</h1>
        <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> (NIM: {{ Auth::user()->nim_nip }})</p>
    </div>
    <a href="{{ route('mahasiswa.buku.index') }}" class="btn btn-primary fw-bold shadow-sm rounded-3">
        <i class="bi bi-journal-bookmark-fill me-1"></i> Jelajahi Katalog Buku
    </a>
</div>

<!-- Check-in Status Banner -->
<div class="row mb-4">
    <div class="col-12">
        @if($kunjunganHariIni)
            <div class="alert alert-success border-0 bg-success-subtle text-success-emphasis rounded-3 p-4 shadow-sm d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1"><i class="bi bi-check-circle-fill me-2 text-success"></i> Anda Sudah Check-in Hari Ini</h5>
                    <p class="mb-0 small text-secondary">Terdeteksi masuk perpustakaan pada pukul <strong>{{ $kunjunganHariIni->waktu_masuk->format('H:i') }} WIB</strong>. Jangan lupa check-out saat meninggalkan lokasi.</p>
                </div>
                <form action="{{ route('mahasiswa.kunjungan.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-success fw-bold px-4 rounded-3" onclick="return confirm('Yakin ingin menyelesaikan kunjungan hari ini?')">
                        <i class="bi bi-box-arrow-right me-1"></i> Check-out Sekarang
                    </button>
                </form>
            </div>
        @else
            <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis rounded-3 p-4 shadow-sm d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2 text-warning"></i> Anda Belum Check-in Hari Ini</h5>
                    <p class="mb-0 small text-secondary">Silakan lakukan presensi masuk dengan kamera/foto untuk menggunakan fasilitas perpustakaan.</p>
                </div>
                <a href="{{ route('mahasiswa.kunjungan.create') }}" class="btn btn-warning text-dark fw-bold px-4 rounded-3 shadow-sm">
                    <i class="bi bi-camera-fill me-1"></i> Presensi Check-in
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Peminjaman Aktif -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-book-half me-2 text-teal" style="color: #0d9488;"></i> Buku yang Sedang Dipinjam</h5>
                <span class="badge bg-teal-subtle text-teal fw-bold" style="background-color:#ccfbf1; color:#0f766e;">{{ $peminjamanAktif->count() }} Buku</span>
            </div>
            <div class="card-body p-4">
                @if($peminjamanAktif->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Kode</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamanAktif as $pinjam)
                                <tr>
                                    <td><strong class="text-dark">{{ $pinjam->buku->judul }}</strong></td>
                                    <td><span class="badge bg-light text-dark border">{{ $pinjam->buku->kode_buku }}</span></td>
                                    <td>{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td><span class="fw-bold text-teal" style="color: #0d9488;">{{ $pinjam->tanggal_kembali_rencana->format('d/m/Y') }}</span></td>
                                    <td>
                                        @if($pinjam->tanggal_kembali_rencana->isPast())
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-bold">
                                                <i class="bi bi-exclamation-circle me-1"></i> Terlambat
                                            </span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold">
                                                <i class="bi bi-clock me-1"></i> Masih Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-journal-x display-4 d-block mb-2 opacity-25"></i>
                        <p class="mb-2">Anda tidak memiliki peminjaman buku aktif saat ini.</p>
                        <a href="{{ route('mahasiswa.buku.index') }}" class="btn btn-outline-teal btn-sm fw-semibold" style="color:#0d9488; border-color:#0d9488;">
                            <i class="bi bi-search me-1"></i> Cari & Pinjam Buku Sekarang
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Kunjungan & Peminjaman -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-teal" style="color: #0d9488;"></i> Riwayat Kunjungan</h5>
            </div>
            <div class="card-body p-3">
                @if($riwayatKunjungan->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatKunjungan as $kunjungan)
                                <tr>
                                    <td><small class="fw-semibold text-dark">{{ $kunjungan->waktu_masuk->format('d/m/Y') }}</small></td>
                                    <td><span class="badge bg-light text-dark border">{{ $kunjungan->waktu_masuk->format('H:i') }} WIB</span></td>
                                    <td>
                                        @if($kunjungan->waktu_keluar)
                                            <span class="badge bg-light text-dark border">{{ $kunjungan->waktu_keluar->format('H:i') }} WIB</span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Aktif</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-4 small">Belum ada riwayat kunjungan</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-arrow-left-right me-2 text-teal" style="color: #0d9488;"></i> Riwayat Peminjaman Buku</h5>
            </div>
            <div class="card-body p-3">
                @if($riwayatPeminjaman->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayatPeminjaman as $pinjam)
                                <tr>
                                    <td><small class="fw-bold text-dark d-block text-truncate" style="max-width: 180px;">{{ $pinjam->buku->judul }}</small></td>
                                    <td><small class="text-muted">{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</small></td>
                                    <td>
                                        @if($pinjam->status === 'dipinjam')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">Dipinjam</span>
                                        @elseif($pinjam->status === 'dikembalikan')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-4 small">Belum ada riwayat peminjaman</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection