@extends('layouts.app')

@section('title', 'Check-in Presensi Kunjungan')

@section('content')
<div class="page-header mb-4">
    <h1 class="h3 fw-bold text-dark mb-1"><i class="bi bi-camera-fill me-2 text-teal" style="color: #0d9488;"></i> Check-in Presensi Perpustakaan</h1>
    <p class="text-muted mb-0">Ambil foto langsung melalui kamera webcam atau unggah foto bukti kunjungan Anda.</p>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-gradient text-white py-3" style="background: linear-gradient(135deg, #0d9488 0%, #1e40af 100%);">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-bounding-box me-2 fs-5"></i>
                    <h5 class="mb-0 fw-bold">Konfirmasi Kehadiran Mahasiswa</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('mahasiswa.kunjungan.store') }}" method="POST" enctype="multipart/form-data" id="presensiForm">
                    @csrf

                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis rounded-3 p-3 mb-4">
                        <div class="d-flex">
                            <i class="bi bi-info-circle-fill me-2 fs-5 text-info"></i>
                            <div>
                                <strong>Petunjuk Presensi:</strong>
                                <ul class="mb-0 mt-1 ps-3 small">
                                    <li>Anda bisa menggunakan <strong>Kamera Live (Webcam)</strong> secara langsung atau mengunggah file foto dari perangkat.</li>
                                    <li>Pastikan wajah Anda terlihat jelas untuk pencatatan kehadiran fisik.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Nav Tab Mode Camera vs Upload -->
                    <ul class="nav nav-pills nav-fill mb-4 p-1 bg-light rounded-3" id="presensiTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold" id="webcam-tab" data-bs-toggle="tab" data-bs-target="#webcam-pane" type="button" role="tab">
                                <i class="bi bi-webcam me-1"></i> Kamera Live (Webcam)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload-pane" type="button" role="tab">
                                <i class="bi bi-upload me-1"></i> Upload File Foto
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="presensiTabContent">
                        <!-- Webcam Pane -->
                        <div class="tab-pane fade show active" id="webcam-pane" role="tabpanel">
                            <div class="text-center mb-3">
                                <div id="camera-container" class="position-relative d-inline-block rounded-3 overflow-hidden bg-dark shadow-sm" style="width: 100%; max-width: 480px; min-height: 280px;">
                                    <video id="webcam" autoplay playsinline class="w-100 h-100" style="object-fit: cover; transform: scaleX(-1);"></video>
                                    <canvas id="canvas" class="d-none"></canvas>
                                    <img id="captured-preview" class="w-100 h-100 d-none" style="object-fit: cover;">
                                    <div id="camera-placeholder" class="position-absolute top-50 start-50 translate-middle text-white text-center">
                                        <i class="bi bi-camera-video display-4 d-block mb-2"></i>
                                        <button type="button" class="btn btn-outline-light btn-sm" id="btn-start-camera">
                                            <i class="bi bi-power me-1"></i> Aktifkan Kamera
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mb-3">
                                <button type="button" class="btn btn-teal text-white fw-bold d-none" id="btn-snap" style="background-color: #0d9488;">
                                    <i class="bi bi-camera me-1"></i> Jepret Foto
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm d-none ms-2" id="btn-retake">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Foto Ulang
                                </button>
                            </div>
                        </div>

                        <!-- Upload File Pane -->
                        <div class="tab-pane fade" id="upload-pane" role="tabpanel">
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Pilih File Foto Kunjungan</label>
                                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" capture="camera">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
                            </div>

                            <div id="upload-preview-container" class="mb-3 d-none">
                                <label class="form-label fw-semibold">Preview Foto File:</label>
                                <div class="text-center">
                                    <img id="upload-preview-image" src="" alt="Preview" class="img-fluid rounded-3 border shadow-sm" style="max-height: 300px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-outline-secondary px-4 fw-semibold rounded-3">
                            <i class="bi bi-x-lg me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold rounded-3" id="btn-submit">
                            <i class="bi bi-check-circle-fill me-1"></i> Selesaikan Check-in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const webcam = document.getElementById('webcam');
    const canvas = document.getElementById('canvas');
    const capturedPreview = document.getElementById('captured-preview');
    const cameraPlaceholder = document.getElementById('camera-placeholder');
    const btnStartCamera = document.getElementById('btn-start-camera');
    const btnSnap = document.getElementById('btn-snap');
    const btnRetake = document.getElementById('btn-retake');
    const fotoInput = document.getElementById('foto');
    const uploadPreviewContainer = document.getElementById('upload-preview-container');
    const uploadPreviewImage = document.getElementById('upload-preview-image');
    let mediaStream = null;
    let isWebcamCaptured = false;

    // Start camera
    async function startCamera() {
        try {
            mediaStream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" }, audio: false });
            webcam.srcObject = mediaStream;
            cameraPlaceholder.classList.add('d-none');
            btnSnap.classList.remove('d-none');
            webcam.classList.remove('d-none');
            capturedPreview.classList.add('d-none');
        } catch (err) {
            alert('Tidak dapat mengakses kamera: ' + err.message + '\nSilakan gunakan tab "Upload File Foto".');
        }
    }

    btnStartCamera.addEventListener('click', startCamera);

    // Snap photo
    btnSnap.addEventListener('click', function() {
        canvas.width = webcam.videoWidth || 640;
        canvas.height = webcam.videoHeight || 480;
        const ctx = canvas.getContext('2d');
        // Mirror horizontally
        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(webcam, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
        capturedPreview.src = dataUrl;
        capturedPreview.classList.remove('d-none');
        webcam.classList.add('d-none');

        // Create File object from canvas blob and set it to file input
        canvas.toBlob(function(blob) {
            const file = new File([blob], "webcam-presensi.jpg", { type: "image/jpeg" });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fotoInput.files = dataTransfer.files;
            isWebcamCaptured = true;
        }, 'image/jpeg', 0.9);

        btnSnap.classList.add('d-none');
        btnRetake.classList.remove('d-none');
    });

    // Retake photo
    btnRetake.addEventListener('click', function() {
        capturedPreview.classList.add('d-none');
        webcam.classList.remove('d-none');
        btnSnap.classList.remove('d-none');
        btnRetake.classList.add('d-none');
        isWebcamCaptured = false;
        fotoInput.value = '';
    });

    // File input preview
    fotoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                uploadPreviewImage.src = e.target.result;
                uploadPreviewContainer.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submit validation
    document.getElementById('presensiForm').addEventListener('submit', function(e) {
        if (!fotoInput.files || fotoInput.files.length === 0) {
            e.preventDefault();
            alert('Harap ambil foto menggunakan Kamera Live atau pilih file foto terlebih dahulu!');
        }
    });

    // Clean up camera stream when leaving tab/page
    window.addEventListener('beforeunload', function() {
        if (mediaStream) {
            mediaStream.getTracks().forEach(track => track.stop());
        }
    });
</script>
@endpush