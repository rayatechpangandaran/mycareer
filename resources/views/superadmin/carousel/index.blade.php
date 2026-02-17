@extends('adminlte::page')

@section('title', 'Carousel')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Data Carousel</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Carousel</li>
        </ol>
    </div>
@stop
@section('content')
    <div class="container-fluid">

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-left-success" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle fa-2x mr-3"></i>
                    <div>
                        <strong>Berhasil!</strong><br>
                        {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- Info Card --}}
        {{-- <div class="row mb-3">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $carousels->count() }}</h3>
                        <p>Total Carousel</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-images"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $carousels->where('is_active', 1)->count() }}</h3>
                        <p>Carousel Aktif</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $carousels->where('is_active', 0)->count() }}</h3>
                        <p>Carousel Nonaktif</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div> --}}
        <!-- <div class="col-lg-3 col-6">
                                                                    <div class="small-box bg-gradient-primary">
                                                                        <div class="inner">
                                                                            <h3>&nbsp;</h3>
                                                                            <p>Tambah Carousel Baru</p>
                                                                        </div>
                                                                        <div class="icon">
                                                                            <i class="fas fa-plus"></i>
                                                                        </div>
                                                                        <a href="{{ route('superadmin.carousel.create') }}" class="small-box-footer">
                                                                            Tambah Sekarang <i class="fas fa-arrow-circle-right"></i>
                                                                        </a>
                                                                    </div>
                                                                </div> -->
        {{-- </div> --}}

        {{-- Main Card --}}
        <a href="{{ route('superadmin.carousel.create') }}" class="btn btn-primary mt-2 mb-2">
            <i class="fas fa-plus-circle"></i> Tambah Carousel
        </a>
        <div class="card shadow-sm">

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-valign-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="45%">Preview & Info</th>
                                <th width="15%" class="text-center">Status</th>
                                <th width="20%" class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($carousels as $item)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge badge-light badge-pill px-3 py-2">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    {{-- Image Preview & Info --}}
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="mr-3 position-relative">
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    class="img-thumbnail elevation-2"
                                                    style="height: 90px; width: 160px; object-fit: cover;"
                                                    alt="Carousel {{ $item->id }}">
                                                @if ($item->is_active)
                                                    <span class="badge badge-success position-absolute"
                                                        style="top: 5px; right: 5px; font-size: 0.7rem;">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                @endif
                                            </div>
                                            <div>
                                                <h6 class="mb-1 font-weight-bold">Carousel #{{ $item->id }}</h6>
                                                <small class="text-muted">
                                                    <i class="far fa-calendar-alt"></i>
                                                    {{ $item->created_at->format('d M Y') }}
                                                </small>
                                                @if ($item->updated_at != $item->created_at)
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="far fa-clock"></i>
                                                        Diupdate {{ $item->updated_at->diffForHumans() }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Status --}}
                                    <td class="text-center">
                                        @if ($item->is_active)
                                            <span class="badge badge-success px-3 py-2 elevation-1">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge badge-secondary px-3 py-2 elevation-1">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center">
                                        <div class="btn-group" role="group">

                                            <form action="{{ route('superadmin.carousel.destroy', $item->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('⚠️ Apakah Anda yakin ingin menghapus carousel ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger elevation-1" data-toggle="tooltip"
                                                    data-placement="top" title="Hapus Carousel">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-images fa-4x mb-3 opacity-50"></i>
                                            <h5>Belum Ada Data Carousel</h5>
                                            <p class="mb-3">Silakan tambahkan carousel pertama Anda</p>
                                            <a href="{{ route('superadmin.carousel.create') }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus-circle"></i> Tambah Carousel
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($carousels->count() > 0)
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Menampilkan {{ $carousels->count() }} carousel
                        </small>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection

@section('css')
    <style>
        .border-left-success {
            border-left: 4px solid #28a745;
        }

        .opacity-50 {
            opacity: 0.5;
        }

        .table-valign-middle td {
            vertical-align: middle;
        }

        .small-box {
            border-radius: 0.5rem;
        }

        .img-thumbnail {
            border-radius: 0.5rem;
            transition: transform 0.2s;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        .btn-group .btn {
            margin: 0 2px;
        }

        .badge-pill {
            font-size: 0.9rem;
        }
    </style>
@stop

@section('js')
    <script>
        $(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Auto dismiss alert after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
@stop
