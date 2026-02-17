@extends('adminlte::page')

@section('title', 'Detail Request')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                {{ $usaha->nama_bisnis_usaha }}
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('mitra.index') }}">Mitra Usaha</a></li>
                <li class="breadcrumb-item active">Detail Mitra Usaha</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">

        {{-- KIRI : DETAIL USAHA --}}
        <div class="col-md-8">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building"></i> Informasi Usaha
                    </h3>
                </div>

                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="35%">Nama Usaha</th>
                            <td>{{ $usaha->nama_bisnis_usaha }}</td>
                        </tr>
                        <tr>
                            <th width="35%">NIB</th>
                            <td>
                                @if ($usaha->nib == 0)
                                    Belum ada NIB
                                @else
                                    {{ $usaha->nib }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Penanggung Jawab</th>
                            <td>{{ $usaha->nama_penanggung_jawab }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $usaha->email }}</td>
                        </tr>
                        <tr>
                            <th>No WhatsApp</th>
                            <td>{{ $usaha->no_wa }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Lengkap</th>
                            <td>{{ $usaha->alamat_lengkap }}, {{ $usaha->kota }}</td>
                        </tr>
                        <tr>
                            <th>Bidang Usaha</th>
                            <td>{{ $usaha->bidang_usaha }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Karyawan</th>
                            <td>{{ $usaha->jml_karyawan }} orang</td>
                        </tr>
                    </table>

                    <hr>

                    <h5 class="mb-2">
                        <i class="fas fa-align-left"></i> Deskripsi Usaha
                    </h5>

                    <div class="p-3 bg-light rounded">
                        {{ $usaha->deskripsi_perusahaan ?? 'Tidak ada deskripsi usaha.' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN : BUKTI USAHA --}}
        <div class="col-md-4">
            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt"></i> Banner Usaha (logo)
                    </h3>
                </div>

                <div class="card-body text-center">
                    @if ($usaha->banner_logo_usaha)
                        @php
                            $fileUrl = asset('storage/' . $usaha->banner_logo_usaha);
                            $ext = strtolower(pathinfo($usaha->banner_logo_usaha, PATHINFO_EXTENSION));
                        @endphp

                        {{-- IMAGE --}}
                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                            <img src="{{ $fileUrl }}" class="img-fluid img-thumbnail mb-2">
                        @endif

                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-link btn-sm mt-2">
                            <i class="fas fa-external-link-alt"></i> Buka di tab baru
                        </a>
                    @else
                        <span class="text-muted">
                            Banner belum diupload
                        </span>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
