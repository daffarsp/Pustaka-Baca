@extends('layouts.app')

@section('title', 'Kelola Peminjaman')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1"><i class="bi bi-arrow-left-right me-2 text-teal" style="color: #0d9488;"></i> Kelola Peminjaman Buku</h1>
        <p class="text-muted mb-0">Manajemen sirkulasi peminjaman, pengembalian, dan denda keterlambatan.</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary fw-semibold">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Tambah Peminjaman
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <!-- Filter & Search -->
        <form method="GET" class="row g-3 mb-4 no-print">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-teal" style="color: #0d9488;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama mahasiswa, NIM, atau judul buku..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="dipinjam" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary" title="Reset">
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
                        <th>Mahasiswa Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali Rencana</th>
                        <th>Tgl Kembali Aktual</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th class="no-print" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $item)
                    <tr>
                        <td class="fw-semibold">{{ $peminjaman->firstItem() + $index }}</td>
                        <td>
                            <strong class="text-dark d-block">{{ $item->user->name }}</strong>
                            <small class="text-muted"><i class="bi bi-card-text me-1"></i>{{ $item->user->nim_nip }}</small>
                        </td>
                        <td>
                            <strong class="text-dark d-block">{{ $item->buku->judul }}</strong>
                            <small class="text-muted"><i class="bi bi-barcode me-1"></i>{{ $item->buku->kode_buku }}</small>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $item->tanggal_pinjam->format('d/m/Y') }}</span></td>
                        <td><span class="badge bg-light text-dark border">{{ $item->tanggal_kembali_rencana->format('d/m/Y') }}</span></td>
                        <td>
                            @if($item->tanggal_kembali_aktual)
                                <span class="badge bg-light text-dark border">{{ $item->tanggal_kembali_aktual->format('d/m/Y') }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            @if($item->status === 'dipinjam')
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                    <i class="bi bi-clock-history me-1"></i> Dipinjam
                                </span>
                            @elseif($item->status === 'dikembalikan')
                                <span class="badge bg-success-subtle text-success border border-success-subtle">
                                    <i class="bi bi-check-circle me-1"></i> Dikembalikan
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Terlambat
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($item->denda > 0)
                                <span class="fw-bold text-danger">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                            @else
                                <span class="text-muted small">Rp 0</span>
                            @endif
                        </td>
                        <td class="no-print">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.peminjaman.show', $item) }}" class="btn btn-outline-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($item->status === 'dipinjam')
                                    <form action="{{ route('admin.peminjaman.pengembalian', $item) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Kembalikan Buku" onclick="return confirm('Konfirmasi pengembalian buku?')">
                                            <i class="bi bi-box-arrow-in-down-left me-1"></i> Kembali
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.peminjaman.destroy', $item) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="bi bi-inbox display-4 d-block mb-2 opacity-25"></i>
                            Belum ada data peminjaman buku
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 no-print">
            {{ $peminjaman->links() }}
        </div>
    </div>
</div>
@endsection