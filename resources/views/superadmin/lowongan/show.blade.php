@extends('adminlte::page')

@section('title', 'Detail Lowongan')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ $lowongan->judul }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.lowongan.index') }}">Lowongan</a></li>
                <li class="breadcrumb-item active">Detail Lowongan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">

        {{-- KIRI : DETAIL LOWONGAN --}}
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-briefcase"></i> Informasi Lowongan</h3>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="35%">Judul Lowongan</th>
                            <td>{{ $lowongan->judul }}</td>
                        </tr>
                        <tr>
                            <th>Perusahaan</th>
                            <td>{{ $lowongan->perusahaan->nama_bisnis_usaha ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $lowongan->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Tipe Pekerjaan</th>
                            <td>{{ $lowongan->tipe_pekerjaan }}</td>
                        </tr>
                        <tr>
                            <th>Pendidikan Minimum</th>
                            <td>
                                @if (in_array($lowongan->pendidikan_terakhir, ['D3', 'S1', 'S2', 'S3']) && $lowongan->jurusan)
                                    {{ $lowongan->pendidikan_terakhir }} {{ $lowongan->jurusan }}
                                @else
                                    {{ $lowongan->pendidikan_terakhir ?? '-' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $lowongan->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Gaji</th>
                            <td>
                                @if ($lowongan->gaji_min && $lowongan->gaji_max)
                                    Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }} - Rp
                                    {{ number_format($lowongan->gaji_max, 0, ',', '.') }}
                                @elseif($lowongan->gaji_min)
                                    Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }}
                                @elseif($lowongan->gaji_max)
                                    Rp {{ number_format($lowongan->gaji_max, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah Lowongan</th>
                            <td>{{ $lowongan->jumlah_lowongan }}</td>
                        </tr>
                        <tr>
                            <th>Deadline</th>
                            <td>{{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $lowongan->status }}</td>
                        </tr>
                    </table>

                    <hr>
                    <h5 class="mb-2"><i class="fas fa-align-left"></i> Deskripsi Lowongan</h5>
                    <div class="p-3 bg-light rounded">{{ $lowongan->deskripsi }}</div>

                    <hr>
                    <h5 class="mb-2"><i class="fas fa-list"></i> Kualifikasi</h5>
                    <div class="p-3 bg-light rounded">{{ $lowongan->kualifikasi }}</div>
                </div>
            </div>
        </div>

        {{-- KANAN : BROSUR / FILE --}}
        <div class="col-md-4">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt"></i> Brosur / File Pendukung</h3>
                </div>

                <div class="card-body text-center">
                    @php
                        // Tentukan path brosur
                        $fileUrl =
                            $lowongan->brosur && $lowongan->brosur != 'assets/img/brosur/brosur-default.png'
                                ? asset('storage/' . $lowongan->brosur)
                                : asset('assets/img/brosur/brosur-default.png');

                        // Ekstensi file
                        $ext = strtolower(pathinfo($lowongan->brosur ?? '', PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                    @endphp

                    {{-- Preview jika image --}}
                    @if ($isImage)
                        <img src="{{ $fileUrl }}" class="img-fluid img-thumbnail mb-2" style="max-height: 200px;">
                    @endif

                    {{-- Selalu tampilkan link --}}
                    <div>
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-link btn-sm mt-2">
                            <i class="fas fa-external-link-alt"></i> Buka Brosur / File
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
