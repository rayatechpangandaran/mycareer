@extends('admin_usaha.layouts.app')

@section('title', 'Detail Lowongan Kerja')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.lowongan.index') }}">Lowongan Kerja</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Lowongan Kerja</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Detail Lowongan Kerja</h4>
                    <p class="card-description text-muted">Informasi lengkap lowongan kerja</p>

                    <h3>Posisi Lowongan : {{ $lowongan->judul }}</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status: </strong>
                                @if ($lowongan->status === 'Draft')
                                    <span class="badge bg-warning">Draft</span>
                                @else
                                    <span class="badge bg-success">Aktif</span>
                                @endif
                            </p>
                            <p><strong>Kategori Pekerjaan: </strong> {{ $lowongan->kategori ?? '-' }}
                            </p>
                            <p><strong>Tanggal Kadaluarsa: </strong>
                                {{ \Carbon\Carbon::parse($lowongan->deadline)->translatedFormat('l, d F Y') }}</p>
                            <p><strong>Dibuat: </strong>
                                {{ \Carbon\Carbon::parse($lowongan->created_at)->translatedFormat('l, d F Y H:i') }}</p>
                            <p><strong>Perusahaan: </strong> {{ $lowongan->perusahaan->nama_bisnis_usaha ?? '-' }}</p>
                            <p>
                                <strong>Pendidikan Terakhir:</strong>
                                @if ($lowongan->jurusan)
                                    {{ $lowongan->pendidikan_terakhir }} {{ $lowongan->jurusan }}
                                @else
                                    {{ $lowongan->pendidikan_terakhir }}
                                @endif
                            </p>


                        </div>

                        <div class="col-md-6 text-center">
                            @php
                                $brosurPath =
                                    $lowongan->brosur && $lowongan->brosur != 'assets/img/brosur/brosur-default.png'
                                        ? asset('storage/' . $lowongan->brosur)
                                        : asset('assets/img/brosur/brosur-default.png');
                            @endphp

                            <img src="{{ $brosurPath }}" alt="Brosur Lowongan" class="img-fluid rounded"
                                style="max-height: 200px;">

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="col-md-6 grid-margin transparent">
            <div class="row">
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-tale">
                        <div class="card-body">
                            <p class="mb-4">Gaji Minimum</p>
                            <p class="fs-30 mb-2">Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }}</p>
                            <p>per Bulan</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Gaji Maksimum</p>
                            <p class="fs-30 mb-2">Rp {{ number_format($lowongan->gaji_max, 0, ',', '.') }}</p>
                            <p>per Bulan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                    <div class="card card-light-blue">
                        <div class="card-body">
                            <p class="mb-4">Tipe Pekerjaan</p>
                            <p class="fs-30 mb-2">{{ $lowongan->tipe_pekerjaan }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Lokasi</p>
                            <p class="fs-20 mb-2 lokasi-text">
                                {{ \Illuminate\Support\Str::title(strtolower($lowongan->lokasi)) }}
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deskripsi & Persyaratan -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-primary">Deskripsi</h4>
                    <p class="card-description"> Deskripsi Pekerjaan </p>
                    <p class="text-lowercase">{{ $lowongan->deskripsi }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Persyaratan</h4>
                    <p class="card-description"> Persyaratan Kerja </p>
                    <ul class="list-ticked">
                        @foreach (explode("\n", $lowongan->kualifikasi) as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
