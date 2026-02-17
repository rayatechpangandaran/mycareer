@extends('adminlte::page')

@section('title', 'Edit Tentang Web')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                <i class="fas fa-edit mr-2"></i>Edit Tentang Web
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.about.index') }}">Tentang Web</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-file-alt mr-2"></i>Form Edit Informasi
                        </h3>
                    </div>

                    <form action="{{ route('superadmin.about.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body p-4">
                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-heading text-primary mr-1"></i>
                                    Judul <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="title" value="{{ old('title', $about->title) }}"
                                    class="form-control form-control-lg @error('title') is-invalid @enderror"
                                    placeholder="Masukkan judul">
                                @error('title')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">
                                    <i class="fas fa-align-left text-info mr-1"></i>
                                    Deskripsi <span class="text-danger">*</span>
                                </label>
                                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Masukkan deskripsi">{{ old('description', $about->description) }}</textarea>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>Jelaskan secara detail tentang website Anda
                                </small>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            <i class="fas fa-eye text-primary mr-1"></i>
                                            Visi
                                        </label>
                                        <textarea name="vision" rows="4" class="form-control" placeholder="Masukkan visi (opsional)">{{ old('vision', $about->vision) }}</textarea>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-star mr-1"></i>Cita-cita jangka panjang
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">
                                            <i class="fas fa-bullseye text-success mr-1"></i>
                                            Misi
                                        </label>
                                        <textarea name="mission" rows="4" class="form-control" placeholder="Masukkan misi (opsional)">{{ old('mission', $about->mission) }}</textarea>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-tasks mr-1"></i>Langkah mencapai visi
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('superadmin.about.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left mr-1"></i>Kembali
                                    </a>
                                </div>
                                <div class="col-6 text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save mr-1"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card card-outline card-info mt-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-lightbulb mr-1"></i>Informasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0">
                            <li>Field bertanda <span class="text-danger font-weight-bold">*</span> wajib diisi</li>
                            <li>Visi dan Misi bersifat opsional</li>
                            <li>Pastikan informasi yang diisi akurat dan up-to-date</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
        }

        .card-body {
            padding: 2rem 1.5rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-control-lg {
            font-size: 1.1rem;
            font-weight: 500;
        }

        textarea.form-control {
            resize: vertical;
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.5rem 1.5rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-lg {
            padding: 0.75rem 2rem;
        }

        label {
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-text {
            font-size: 0.875rem;
        }

        hr {
            border-top: 2px solid #e9ecef;
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-hide alert
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@endsection
