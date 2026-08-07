@extends('layouts.app')

@section('title', 'Kelola Kunjungan')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1"><i class="bi bi-door-open me-2 text-teal" style="color: #0d9488;"></i> Kelola Presensi Kunjungan</h1>
        <p class="text-muted mb-0">Monitoring kehadiran mahasiswa di perpustakaan secara realtime.</p>
    </div>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary fw-semibold">
            <i class="bi bi-printer me-1"></i> Cetak Laporan Kunjungan
        </button>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <!-- Filter & Search -->
        <form method="GET" class="row g-3 mb-4 no-print">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-teal" style="color: #0d9488;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama atau NIM..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', date('Y-m-d')) }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">-- Semua --</option>
                    <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.kunjungan.index') }}" class="btn btn-outline-secondary" title="Reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>

        <!-- Statistics Alert Bar -->
        <div class="row g-3 mb-4 no-print">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border-start border-4 border-info">
                    <small class="text-muted d-block"><i class="bi bi-calendar-event me-1"></i> Total Kunjungan Tanggal Ini</small>
                    <span class="fs-5 fw-bold text-dark">{{ $kunjungan->total() }} Mahasiswa</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3 border-start border-4 border-success">
                    <small class="text-muted d-block"><i class="bi bi-people me-1"></i> Masih Berada di Perpustakaan</small>
                    <span class="fs-5 fw-bold text-success">{{ $kunjungan->where('waktu_keluar', null)->count() }} Mahasiswa Aktif</span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Waktu Masuk</th>
                        <th>Waktu Keluar</th>
                        <th>Durasi</th>
                        <th class="no-print">Foto</th>
                        <th class="no-print" width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kunjungan as $index => $item)
                    <tr>
                        <td class="fw-semibold">{{ $kunjungan->firstItem() + $index }}</td>
                        <td><strong class="text-dark">{{ $item->user->name }}</strong></td>
                        <td><span class="badge bg-light text-dark border">{{ $item->user->nim_nip }}</span></td>
                        <td><span class="badge bg-teal-subtle text-teal fw-semibold" style="background-color:#ccfbf1; color:#0f766e;">{{ $item->waktu_masuk->format('H:i') }} WIB</span></td>
                        <td>
                            @if($item->waktu_keluar)
                                <span class="badge bg-light text-dark border">{{ $item->waktu_keluar->format('H:i') }} WIB</span>
                            @else
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-geo-alt-fill me-1"></i> Di Perpustakaan
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->waktu_keluar)
                                <small class="fw-semibold text-secondary">{{ $item->waktu_masuk->diffInMinutes($item->waktu_keluar) }} Menit</small>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="no-print">
                            <button type="button" class="btn btn-sm btn-outline-teal" style="color:#0d9488; border-color:#0d9488;" data-bs-toggle="modal" data-bs-target="#fotoModal{{ $item->id }}">
                                <i class="bi bi-image me-1"></i> Lihat Foto
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold">Foto Presensi - {{ $item->user->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ Storage::url($item->foto_kunjungan) }}" alt="Foto Kunjungan" class="img-fluid rounded-3 shadow-sm" style="max-height: 400px;">
                                            <p class="mt-3 text-muted mb-0 small"><i class="bi bi-clock me-1"></i> {{ $item->waktu_masuk->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="no-print">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.kunjungan.show', $item) }}" class="btn btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(!$item->waktu_keluar)
                                    <form action="{{ route('admin.kunjungan.checkout', $item) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Paksa Check-out" onclick="return confirm('Checkout mahasiswa ini?')">
                                            <i class="bi bi-box-arrow-right me-1"></i> Checkout
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-door-closed display-4 d-block mb-2 opacity-25"></i>
                            Tidak ada data presensi kunjungan pada tanggal ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 no-print">
            {{ $kunjungan->links() }}
        </div>
    </div>
</div>
@endsection