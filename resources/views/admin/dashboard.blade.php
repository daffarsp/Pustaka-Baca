@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1"><i class="bi bi-speedometer2 me-2 text-teal" style="color: #0d9488;"></i> Dashboard Control Center</h1>
        <p class="text-muted mb-0">Ringkasan aktivitas, statistik sirkulasi buku, dan presensi mahasiswa secara realtime.</p>
    </div>
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary fw-semibold">
            <i class="bi bi-printer me-1"></i> Cetak Ringkasan
        </button>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card stat-card primary border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Mahasiswa</div>
                        <div class="h4 mb-0 fw-extrabold text-dark">{{ $totalMahasiswa }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #ccfbf1; color: #0d9488;">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card success border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">Total Eksemplar Buku</div>
                        <div class="h4 mb-0 fw-extrabold text-dark">{{ $totalBuku }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #d1fae5; color: #10b981;">
                        <i class="bi bi-book fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card info border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">Stok Buku Tersedia</div>
                        <div class="h4 mb-0 fw-extrabold text-dark">{{ $bukuTersedia }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #e0f2fe; color: #0284c7;">
                        <i class="bi bi-journal-check fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card stat-card warning border-0 shadow-sm rounded-3 h-100">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted" style="font-size: 0.75rem; letter-spacing: 0.5px;">Sedang Dipinjam</div>
                        <div class="h4 mb-0 fw-extrabold text-dark">{{ $totalPeminjaman }}</div>
                    </div>
                    <div class="p-3 rounded-circle" style="background-color: #fef3c7; color: #f59e0b;">
                        <i class="bi bi-arrow-left-right fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Mahasiswa di Perpustakaan -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <span class="fw-bold text-dark"><i class="bi bi-door-open me-2 text-teal" style="color: #0d9488;"></i> Mahasiswa Aktif di Perpustakaan</span>
                <span class="badge bg-teal-subtle text-teal fw-bold" style="background-color:#ccfbf1; color:#0f766e;">{{ $mahasiswaDiPerpustakaan->count() }} Orang</span>
            </div>
            <div class="card-body p-3">
                @if($mahasiswaDiPerpustakaan->count() > 0)
                    <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Mahasiswa</th>
                                    <th>NIM</th>
                                    <th>Masuk</th>
                                    <th class="no-print">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mahasiswaDiPerpustakaan as $kunjungan)
                                <tr>
                                    <td><strong class="text-dark">{{ $kunjungan->user->name }}</strong></td>
                                    <td><small class="text-muted">{{ $kunjungan->user->nim_nip }}</small></td>
                                    <td><span class="badge bg-light text-dark border">{{ $kunjungan->waktu_masuk->format('H:i') }} WIB</span></td>
                                    <td class="no-print">
                                        <form action="{{ route('admin.kunjungan.checkout', $kunjungan) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-2" title="Checkout" onclick="return confirm('Checkout mahasiswa ini?')">
                                                <i class="bi bi-box-arrow-right me-1"></i> Checkout
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-4 py-3 small">
                        <i class="bi bi-person-x display-6 d-block mb-2 opacity-25"></i>
                        Tidak ada mahasiswa di lokasi perpustakaan saat ini
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Buku Paling Populer -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <span class="fw-bold text-dark"><i class="bi bi-star-fill me-2 text-warning"></i> Top 5 Buku Sering Dipinjam</span>
            </div>
            <div class="card-body p-3">
                @if($bukuPopuler->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="8%">#</th>
                                    <th>Judul Buku</th>
                                    <th>Total Dipinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bukuPopuler as $index => $buku)
                                <tr>
                                    <td class="fw-bold text-teal" style="color: #0d9488;">{{ $index + 1 }}</td>
                                    <td><strong class="text-dark">{{ $buku->judul }}</strong></td>
                                    <td><span class="badge bg-teal-subtle text-teal fw-bold" style="background-color:#ccfbf1; color:#0f766e;">{{ $buku->total_pinjam ?? 0 }} Kali</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted my-4 py-3 small">Belum ada transaksi peminjaman</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <!-- Chart Kunjungan -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <span class="fw-bold text-dark"><i class="bi bi-bar-chart-fill me-2 text-teal" style="color: #0d9488;"></i> Grafik Presensi 7 Hari Terakhir</span>
            </div>
            <div class="card-body p-3">
                <canvas id="kunjunganChart" height="220"></canvas>
            </div>
        </div>
    </div>

    <!-- Chart Peminjaman -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <span class="fw-bold text-dark"><i class="bi bi-graph-up me-2 text-indigo" style="color: #1e40af;"></i> Grafik Peminjaman 6 Bulan Terakhir</span>
            </div>
            <div class="card-body p-3">
                <canvas id="peminjamanChart" height="220"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Chart Kunjungan
    const kunjunganData = @json($kunjunganChart);
    const kunjunganLabels = kunjunganData.map(item => {
        const date = new Date(item.tanggal);
        return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
    });
    const kunjunganValues = kunjunganData.map(item => item.jumlah);

    new Chart(document.getElementById('kunjunganChart'), {
        type: 'line',
        data: {
            labels: kunjunganLabels,
            datasets: [{
                label: 'Presensi Mahasiswa',
                data: kunjunganValues,
                borderColor: '#0d9488',
                backgroundColor: 'rgba(13, 148, 136, 0.12)',
                borderWidth: 3,
                tension: 0.35,
                fill: true,
                pointBackgroundColor: '#0d9488',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Chart Peminjaman
    const peminjamanData = @json($peminjamanChart);
    const bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const peminjamanLabels = peminjamanData.map(item => bulanNames[item.bulan - 1]);
    const peminjamanValues = peminjamanData.map(item => item.jumlah);

    new Chart(document.getElementById('peminjamanChart'), {
        type: 'bar',
        data: {
            labels: peminjamanLabels,
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: peminjamanValues,
                backgroundColor: '#1e40af',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>
@endpush