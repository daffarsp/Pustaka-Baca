<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun Mahasiswa - Perpustakaan</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0d9488 0%, #1e40af 100%);
            --primary-hover: linear-gradient(135deg, #0f766e 0%, #1e3a8a 100%);
        }
        
        body {
            background: linear-gradient(135deg, #0f172a 0%, #0f766e 50%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 2rem 0;
        }
        
        .register-container {
            max-width: 550px;
            width: 100%;
        }
        
        .register-card {
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .register-header {
            background: var(--primary-gradient);
            color: white;
            padding: 2.2rem 2rem 1.8rem 2rem;
            text-align: center;
        }
        
        .register-header h3 {
            margin: 0;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .register-header p {
            margin: 0.5rem 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .register-body {
            padding: 2rem;
            background: #ffffff;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #0d9488;
            box-shadow: 0 0 0 0.25rem rgba(13, 148, 136, 0.2);
        }
        
        .input-group-text {
            background-color: #f8fafc;
            border-right: none;
            color: #0d9488;
        }
        
        .form-control {
            border-left: none;
        }
        
        .btn-register {
            background: var(--primary-gradient);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.3);
        }
        
        .btn-register:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.4);
        }
        
        .logo-icon {
            font-size: 2.8rem;
            margin-bottom: 0.5rem;
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            width: 70px;
            height: 70px;
            line-height: 70px;
            border-radius: 50%;
        }
        
        .role-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.25);
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            margin-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 register-container">
                <div class="register-card">
                    <div class="register-header">
                        <div class="logo-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <h3>Pendaftaran Akun Mahasiswa</h3>
                        <p>Lengkapi formulir di bawah untuk membuat akun baru</p>
                        <span class="role-badge"><i class="bi bi-shield-check me-1"></i> Default Role: Mahasiswa</span>
                    </div>
                    
                    <div class="register-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                                <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-1 ps-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Nama Lengkap -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Budi Santoso" value="{{ old('name') }}" required autofocus>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Alamat Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="nama@student.ac.id" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <!-- NIM / NIP -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">NIM (Nomor Induk Mahasiswa) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                    <input type="text" name="nim_nip" class="form-control @error('nim_nip') is-invalid @enderror" placeholder="Contoh: 22171065038" value="{{ old('nim_nip') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Jurusan -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary">Jurusan / Program Studi</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-mortarboard"></i></span>
                                        <input type="text" name="jurusan" class="form-control" placeholder="Contoh: Teknik Informatika" value="{{ old('jurusan') }}">
                                    </div>
                                </div>

                                <!-- No Telepon -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary">Nomor WhatsApp / HP</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" name="no_telepon" class="form-control" placeholder="Contoh: 081234567890" value="{{ old('no_telepon') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimal 6 karakter" required>
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary">Ulangi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Ketik ulang password" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-register w-100 mt-2 rounded-3">
                                <i class="bi bi-check-circle-fill me-1"></i> Daftar Sekarang
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="text-muted mb-0">Sudah memiliki akun?</p>
                            <a href="{{ route('login') }}" class="fw-bold text-decoration-none" style="color: #0d9488;">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Login di sini
                            </a>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-white-50">
                        &copy; {{ date('Y') }} Sistem Informasi Perpustakaan. All rights reserved.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
