@extends('adminlte::page')

@section('title', 'Tambah Carousel')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Tambah Carousel</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.carousel.index') }}">Carousel</a></li>
            <li class="breadcrumb-item active">Tambah Carousel</li>
        </ol>
    </div>
@stop
@section('content')
    <div class="container-fluid">

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <form action="{{ route('superadmin.carousel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Drag & Drop Upload --}}
                    <div class="mb-4">
                        <label class="form-label fw-bold">Gambar Carousel</label>

                        <div id="drop-area" class="border rounded p-4 text-center position-relative">
                            <input type="file" name="image" id="fileInput" class="d-none" accept="image/*" required>

                            <div id="drop-content">
                                <i class="fas fa-cloud-upload-alt fa-2x text-primary mb-2"></i>
                                <p class="mb-1 fw-bold">Drag & Drop gambar di sini</p>
                                <small class="text-muted">atau klik untuk memilih file (Rekomendasi Ukuran 1536 X 1024
                                    pixel)</small>
                            </div>

                            <img id="previewImage" class="img-fluid rounded mt-3 d-none"
                                style="max-height: 200px; object-fit: cover;">
                        </div>

                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" checked>
                        <label class="form-check-label fw-bold" for="is_active">Aktifkan Carousel</label>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary shadow-sm">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('superadmin.carousel.index') }}" class="btn btn-secondary ml-2">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    {{-- CSS --}}
    <style>
        #drop-area {
            cursor: pointer;
            transition: 0.2s;
            background: #f8f9fa;
        }

        #drop-area.dragover {
            background: #e3f2fd;
            border-color: #0d6efd;
        }
    </style>

    {{-- JS Drag & Drop --}}
    <script>
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('fileInput');
        const previewImage = document.getElementById('previewImage');
        const dropContent = document.getElementById('drop-content');

        dropArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            previewFile(this.files[0]);
        });

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('dragover');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('dragover');

            const file = e.dataTransfer.files[0];
            fileInput.files = e.dataTransfer.files;
            previewFile(file);
        });

        function previewFile(file) {
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.classList.remove('d-none');
                dropContent.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        }
    </script>
@endsection
