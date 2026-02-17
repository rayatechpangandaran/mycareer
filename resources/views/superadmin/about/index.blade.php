@extends('adminlte::page')

@section('title', 'Tentang Web')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                <i class="fas fa-info-circle mr-2"></i>Tentang Web
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Tentang Web</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-12 col-xl-12">

                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($about)
                    {{-- Main Content Card --}}
                    <div class="card card-widget widget-user shadow-sm">
                        <!-- Header -->
                        <div class="widget-user-header bg-gradient-primary text-white">
                            <h3 class="widget-user-username">{{ $about->title }}</h3>
                        </div>

                        <!-- Icon -->
                        <div class="widget-user-image">
                            <div class="img-circle elevation-2 bg-white d-flex align-items-center justify-content-center"
                                style="width: 90px; height: 90px;">
                                <i class="fas fa-globe fa-3x text-primary d-none d-sm-block"></i>
                                <i class="fas fa-globe fa-2x text-primary d-block d-sm-none"></i>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row mt-3 mt-sm-4">
                                <div class="col-12">
                                    <!-- Description Section -->
                                    <div class="mb-3 mb-md-4">
                                        <h5 class="text-primary mb-2 mb-md-3">
                                            <i class="fas fa-align-left mr-2"></i>Deskripsi
                                        </h5>
                                        <div class="callout callout-info">
                                            <p class="text-muted mb-0" style="line-height: 1.8; text-align: justify;">
                                                {{ $about->description }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Vision & Mission Section -->
                                    <div class="row">
                                        @if ($about->vision)
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="info-box shadow-sm">
                                                    <span class="info-box-icon bg-info">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text font-weight-bold">Visi</span>
                                                        <span class="info-box-number text-sm text-muted"
                                                            style="line-height: 1.6;">
                                                            {{ $about->vision }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($about->mission)
                                            <div class="col-12 col-md-6 mb-3">
                                                <div class="info-box shadow-sm">
                                                    <span class="info-box-icon bg-success">
                                                        <i class="fas fa-bullseye"></i>
                                                    </span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text font-weight-bold">Misi</span>
                                                        <span class="info-box-number text-sm text-muted"
                                                            style="line-height: 1.6;">
                                                            {{ $about->mission }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light">
                            <div class="text-center">
                                <a href="{{ route('superadmin.about.edit') }}"
                                    class="btn btn-warning btn-lg btn-block btn-sm-inline">
                                    <i class="fas fa-edit mr-2"></i>Edit Informasi
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Statistics Cards --}}
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>1</h3>
                                    <p class="mb-0">Data Tersimpan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-database"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 mb-3">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 class="d-none d-sm-block">{{ $about->updated_at->diffForHumans() }}</h3>
                                    <h3 class="d-block d-sm-none" style="font-size: 1.2rem;">
                                        {{ $about->updated_at->diffForHumans() }}
                                    </h3>
                                    <p class="mb-0">Terakhir Diperbarui</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 mb-3 mx-auto">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ Str::wordCount($about->description) }}</h3>
                                    <p class="mb-0">Jumlah Kata</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center py-4 py-md-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-4x fa-md-5x text-muted mb-3 mb-md-4"></i>
                                <h3 class="text-muted mb-2 mb-md-3">Belum Ada Data</h3>
                                <p class="text-secondary mb-3 mb-md-4 mx-auto px-3" style="max-width: 500px;">
                                    Belum ada data Tentang Web yang tersimpan. Silakan tambahkan informasi
                                    tentang website Anda melalui halaman edit.
                                </p>
                                <a href="{{ route('superadmin.about.edit') }}"
                                    class="btn btn-primary btn-lg btn-block btn-sm-inline">
                                    <i class="fas fa-plus mr-2"></i>Tambah Data Sekarang
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Info Alert --}}
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i> Informasi</h5>
                        <p class="mb-0">
                            Halaman "Tentang Web" akan menampilkan informasi penting tentang website Anda,
                            termasuk deskripsi, visi, dan misi organisasi.
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .widget-user-header {
            padding: 20px;
            height: 135px;
        }

        .widget-user-username {
            font-size: 25px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .widget-user-desc {
            font-size: 14px;
            margin-top: 0;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .card {
            border-radius: 10px;
            overflow: hidden;
        }

        .callout {
            border-left: 4px solid #17a2b8;
            border-radius: 5px;
            padding: 1rem 1.25rem;
            background-color: #f8f9fa;
        }

        .info-box {
            border-radius: 8px;
            transition: all 0.3s ease;
            min-height: auto;
        }

        .info-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
        }

        .info-box-icon {
            border-radius: 8px 0 0 8px;
        }

        .info-box-number {
            white-space: normal;
        }

        .small-box {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .small-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .btn {
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .alert {
            border-radius: 8px;
            border: none;
        }

        .empty-state i {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Responsive Styles */
        @media (max-width: 575.98px) {
            .widget-user-header {
                padding: 15px;
                height: 100px;
            }

            .widget-user-username {
                font-size: 1.2rem;
            }

            .widget-user-image>div {
                width: 70px !important;
                height: 70px !important;
            }

            h1.m-0 {
                font-size: 1.5rem;
            }

            h5.text-primary {
                font-size: 1rem;
            }

            .callout {
                padding: 0.75rem 1rem;
            }

            .info-box {
                margin-bottom: 1rem;
            }

            .info-box-icon {
                width: 70px;
            }

            .info-box-icon i {
                font-size: 2rem;
            }

            .small-box h3 {
                font-size: 1.5rem;
            }

            .small-box p {
                font-size: 0.85rem;
            }

            .small-box .icon {
                font-size: 3rem;
            }

            .empty-state i {
                font-size: 3rem !important;
            }

            .btn-lg {
                padding: 0.6rem 1.5rem;
                font-size: 0.95rem;
            }

            .breadcrumb {
                font-size: 0.85rem;
            }

            .btn-block {
                width: 100%;
            }
        }

        @media (min-width: 576px) {
            .btn-sm-inline {
                width: auto;
                display: inline-block;
                min-width: 200px;
            }
        }

        @media (min-width: 576px) and (max-width: 767.98px) {
            .col-sm-6.col-md-4:last-child {
                max-width: 50%;
                margin-left: 25%;
            }
        }

        @media (min-width: 768px) {
            .card-body {
                padding: 1.5rem 1.5rem;
            }
        }

        @media (min-width: 992px) {
            .card-body {
                padding: 2rem 1.5rem;
            }
        }
    </style>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Auto-hide alert after 5 seconds
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 5000);

            // Tooltip activation
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
