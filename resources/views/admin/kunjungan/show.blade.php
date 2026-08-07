@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-file-text"></i> Detail Kunjungan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.kunjungan.index') }}">Kelola Kunjungan</a></li>
            <li class="breadcrumb-item active">Detail Kunjungan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-info-circle"></i> Informasi Kunjungan</span>
                <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-sm btn-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3"><i class="bi bi-person"></i> Data Mahasiswa</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Nama</th>
                                <td>{{ $kunjungan->user->name }}</td>
                            </tr>
                            <tr>
                                <th>NIM</th>
                                <td>{{ $kunjungan->user->nim_nip }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $kunjungan->user->email }}</td>
                            </tr>
                            <tr>
                                <th>Jurusan</th>
                                <td>{{ $kunjungan->user->jurusan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-success mb-3"><i class="bi bi-clock"></i> Waktu Kunjungan</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th width="150">Waktu Masuk</th>
                                <td>{{ $kunjungan->waktu_masuk->format('d F Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Waktu Keluar</th>
                                <td>
                                    @if($kunjungan->waktu_keluar)
                                        {{ $kunjungan->waktu_keluar->format('d F Y, H:i') }}
                                    @else
                                        <span class="badge bg-success">Masih di Perpustakaan</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Durasi</th>
                                <td>
                                    @if($kunjungan->waktu_keluar)
                                        {{ $kunjungan->waktu_masuk->diffForHumans($kunjungan->waktu_keluar, true) }}
                                    @else
                                        {{ $kunjungan->waktu_masuk->diffForHumans(now(), true) }} (berlangsung)
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                <h5 class="text-info mb-3"><i class="bi bi-camera"></i> Foto Kunjungan</h5>
                <div class="text-center">
                    <img src="{{ Storage::url($kunjungan->foto_kunjungan) }}" alt="Foto Kunjungan" class="img-fluid rounded" style="max-height: 400px;">
                </div>

                @if(!$kunjungan->waktu_keluar)
                    <hr>
                    <form action="{{ route('admin.kunjungan.checkout', $kunjungan)
                    7:41 AM}}" method="POST">
@csrf
<button type="submit" class="btn btn-success" onclick="return confirm('Checkout mahasiswa ini?')">
<i class="bi bi-box-arrow-right"></i> Proses Check-out
</button>
</form>
@endif
</div>
</div>
</div>
</div>
@endsection