@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="page-header">
    <h1><i class="bi bi-plus-circle"></i> Tambah Peminjaman Baru</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.peminjaman.index') }}">Kelola Peminjaman</a></li>
            <li class="breadcrumb-item active">Tambah Peminjaman</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-file-earmark-text"></i> Form Tambah Peminjaman
            </div>
            <div class="card-body">
                <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Mahasiswa <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Pilih Mahasiswa</option>
                            @foreach($mahasiswa as $mhs)
                                <option value="{{ $mhs->id }}" {{ old('user_id') == $mhs->id ? 'selected' : '' }}>
                                    {{ $mhs->name }} - {{ $mhs->nim_nip }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Buku <span class="text-danger">*</span></label>
                        <select name="buku_id" id="buku_id" class="form-select @error('buku_id') is-invalid @enderror" required>
                            <option value="">Pilih Buku</option>
                            @foreach($buku as $b)
                                <option value="{{ $b->id }}" data-stok="{{ $b->stok_tersedia }}" {{ old('buku_id') == $b->id ? 'selected' : '' }}>
                                    {{ $b->judul }} - {{ $b->kode_buku }} (Tersedia: {{ $b->stok_tersedia }})
                                </option>
                            @endforeach
                        </select>
                        @error('buku_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="stok-info" class="mt-2"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali (Rencana) <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_kembali_rencana" class="form-control @error('tanggal_kembali_rencana') is-invalid @enderror" value="{{ old('tanggal_kembali_rencana') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        @error('tanggal_kembali_rencana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Biasanya 7-14 hari dari hari ini</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> <strong>Informasi:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Tanggal pinjam otomatis hari ini</li>
                            <li>Denda keterlambatan: Rp 2.000 per hari</li>
                            <li>Pastikan buku tersedia sebelum meminjamkan</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('buku_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stok = selectedOption.getAttribute('data-stok');
        const stokInfo = document.getElementById('stok-info');
        
        if (stok && stok > 0) {
            stokInfo.innerHTML = `<div class="alert alert-success mb-0"><i class="bi bi-check-circle"></i> Buku tersedia: ${stok} exemplar</div>`;
        } else if (stok == 0) {
            stokInfo.innerHTML = `<div class="alert alert-danger mb-0"><i class="bi bi-x-circle"></i> Buku tidak tersedia</div>`;
        } else {
            stokInfo.innerHTML = '';
        }
    });
</script>
@endpush