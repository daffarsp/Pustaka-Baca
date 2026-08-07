@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-book"></i> Detail Buku</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.buku.index') }}">Kelola Buku</a></li>
            <li class="breadcrumb-item active">Detail Buku</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle"></i> Informasi Buku</span>
                <div>
                    <a href="{{ route('admin.buku.edit', $buku) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="{{ route('admin.buku.index') }}" class="btn btn-sm btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Kode Buku</th>
                        <td><span class="badge bg-secondary">{{ $buku->kode_buku }}</span></td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td><strong>{{ $buku->judul }}</strong></td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $buku->penulis }}</td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>{{ $buku->penerbit }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>{{ $buku->tahun_terbit }}</td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>{{ $buku->isbn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td><span class="badge bg-info">{{ $buku->kategori }}</span></td>
                    </tr>
                    <tr>
                        <th>Total Stok</th>
                        <td>{{ $buku->stok }} buku</td>
                    </tr>
                    <tr>
                        <th>Stok Tersedia</th>
                        <td>
                            @if($buku->stok_tersedia > 0)
                                <span class="badge bg-success">{{ $buku->stok_tersedia }} buku</span>
                            @else
                                <span class="badge bg-danger">Tidak tersedia</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Sedang Dipinjam</th>
                        <td>{{ $buku->stok - $buku->stok_tersedia }} buku</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $buku->deskripsi ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Riwayat Peminjaman -->
        <div class="card mt-4">
            <div class="card-header">
                <i class="bi bi-clock-history"></i> Riwayat Peminjaman (10 Terakhir)
            </div>
            <div class="card-body">
                @if($buku->peminjaman->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Peminjam</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Tgl Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($buku->peminjaman as $pinjam)
                                <tr>
                                    <td>{{ $pinjam->user->name }}</td>
                                    <td>{{ $pinjam->tanggal_pinjam->format('d/m/Y') }}</td>
                                    <td>
                                        @if($pinjam->tanggal_kembali_aktual)
                                            {{ $pinjam->tanggal_kembali_aktual->format('d/m/Y') }}
                                        @else
                                            {{ $pinjam->tanggal_kembali_rencana->format('d/m/Y') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($pinjam->status === 'dipinjam')
                                            <span class="badge bg-warning">Dipinjam</span>
                                        @elseif($pinjam->status === 'dikembalikan')
                                            <span class="badge bg-success">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger">Terlambat</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-4">Belum ada riwayat peminjaman</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection