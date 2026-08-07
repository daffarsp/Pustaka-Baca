@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-file-text"></i> Detail Peminjaman</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.peminjaman.index') }}">Kelola Peminjaman</a></li>
            <li class="breadcrumb-item active">Detail Peminjaman</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle"></i> Informasi Peminjaman</span>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3"><i class="bi bi-person"></i> Data Peminjam</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="150">Nama</th>
                                <td>{{ $peminjaman->user->name }}</td>
                            </tr>
                            <tr>
                                <th>NIM</th>
                                <td>{{ $peminjaman->user->nim_nip }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $peminjaman->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td>{{ $peminjaman->user->jurusan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-success mb-3"><i class="bi bi-book"></i> Data Buku</h5>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="150">Judul</th>
                                <td>{{ $peminjaman->buku->judul }}</td>
                            </tr>
                            <tr>
                                <th>Kode Buku</th>
                                <td><span class="badge bg-secondary">{{ $peminjaman->buku->kode_buku }}</span></td>
                            </tr>
                            <tr>
                                <th>Penulis</th>
                                <td>{{ $peminjaman->buku->penulis }}</td>
                            </tr>
                            <tr>
                                <th>Kategori</th>
                                <td><span class="badge bg-info">{{ $peminjaman->buku->kategori }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h5 class="text-warning mb-3"><i class="bi bi-calendar-event"></i> Informasi Peminjaman</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="250">Tanggal Pinjam</th>
                        <td>{{ $peminjaman->tanggal_pinjam->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali (Rencana)</th>
                        <td>{{ $peminjaman->tanggal_kembali_rencana->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kembali (Aktual)</th>
                        <td>
                            @if($peminjaman->tanggal_kembali_aktual)
                                {{ $peminjaman->tanggal_kembali_aktual->format('d F Y') }}
                            @else
                                <span class="badge bg-warning">Belum dikembalikan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($peminjaman->status === 'dipinjam')
                                <span class="badge bg-warning">Dipinjam</span>
                            @elseif($peminjaman->status === 'dikembalikan')
                                <span class="badge bg-success">Dikembalikan</span>
                            @else
                                <span class="badge bg-danger">Terlambat</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Denda</th>
                        <td>
                            @if($peminjaman->denda > 0)
                                <span class="text-danger fw-bold">Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-success">Tidak ada denda</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Admin Peminjaman</th>
                        <td>{{ $peminjaman->adminPinjam->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Admin Pengembalian</th>
                        <td>{{ $peminjaman->adminKembali->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $peminjaman->catatan ?? '-' }}</td>
                    </tr>
                </table>

                @if($peminjaman->status === 'dipinjam')
                    <div class="alert alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle"></i> Buku ini masih dipinjam
                    </div>
                    <form action="{{ route('admin.peminjaman.pengembalian', $peminjaman) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Konfirmasi pengembalian buku?')">
                            <i class="bi bi-check-circle"></i> Proses Pengembalian
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection