@extends('layouts.app')

@section('title', 'Kelola User')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold text-dark mb-1"><i class="bi bi-people me-2 text-teal" style="color: #0d9488;"></i> Kelola Data User</h1>
        <p class="text-muted mb-0">Manajemen akun administrator dan data mahasiswa terdaftar.</p>
    </div>
    <div class="d-flex gap-2 no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary fw-semibold">
            <i class="bi bi-printer me-1"></i> Cetak Data User
        </button>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> Tambah User Baru
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4">
        <!-- Filter & Search -->
        <form method="GET" class="row g-3 mb-4 no-print">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-teal" style="color: #0d9488;">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Cari nama, email, atau NIM/NIP..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="role" class="form-select">
                    <option value="">-- Semua Role --</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="mahasiswa" {{ request('role') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100 fw-semibold">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" title="Reset">
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
                        <th>Nama Pengguna</th>
                        <th>Email</th>
                        <th>NIM/NIP</th>
                        <th>Role</th>
                        <th>Jurusan</th>
                        <th>No. Telepon</th>
                        <th class="no-print" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td class="fw-semibold">{{ $users->firstItem() + $index }}</td>
                        <td><strong class="text-dark">{{ $user->name }}</strong></td>
                        <td><small class="text-secondary">{{ $user->email }}</small></td>
                        <td><span class="badge bg-teal-subtle text-teal fw-bold" style="background-color:#ccfbf1; color:#0f766e;">{{ $user->nim_nip }}</span></td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle fw-bold">Admin</span>
                            @else
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold">Mahasiswa</span>
                            @endif
                        </td>
                        <td><small class="text-secondary">{{ $user->jurusan ?? '-' }}</small></td>
                        <td><small class="text-secondary">{{ $user->no_telepon ?? '-' }}</small></td>
                        <td class="no-print">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-people display-4 d-block mb-2 opacity-25"></i>
                            Tidak ada data user ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4 no-print">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection