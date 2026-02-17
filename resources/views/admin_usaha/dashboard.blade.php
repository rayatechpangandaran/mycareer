@extends('admin_usaha.layouts.app')

@section('title', 'Dashboard Admin Usaha')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </nav>

    {{-- HEADER --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <h3 class="font-weight-bold">Selamat Datang, {{ auth()->user()->nama }}</h3>
            <h6 class="text-muted">{{ $namaUsaha->nama_bisnis_usaha }}</h6>
        </div>

        <div class="col-md-4 text-end">
            <img src="{{ asset('storage/' . $namaUsaha->banner_logo_usaha) }}" style="height:70px; object-fit:contain;">
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row">

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-tale">
                <div class="card-body text-center">
                    <h6>Total Lowongan Aktif</h6>
                    <h2 class="font-weight-bold">{{ $totalLowongan }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-dark-blue">
                <div class="card-body text-center">
                    <h6>Total Pelamar / Diterima</h6>
                    <h2 class="font-weight-bold">{{ $totalLamaran }} / {{ $lamaranDiterima }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-light-blue">
                <div class="card-body text-center">
                    <h6>Pelamar Belum Diproses</h6>
                    <h2 class="font-weight-bold">{{ $lamaranDiproses }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3 grid-margin stretch-card">
            <div class="card card-light-danger">
                <div class="card-body text-center">
                    <h6>Pelamar Ditolak</h6>
                    <h2 class="font-weight-bold">{{ $lamaranDitolak }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- PROGRESS REKRUTMEN --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Performa Rekrutmen</h5>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progressRekrutmen }}%">
                            {{ $progressRekrutmen }}%
                        </div>
                    </div>
                    <small class="text-muted">
                        Persentase pelamar yang diterima
                    </small>
                </div>
            </div>
        </div>

        {{-- PROFIL USAHA --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5>Profil Singkat Usaha</h5>
                    <table>
                        <tr>
                            <td>Bidang Usaha</td>
                            <td>:</td>
                            <td>{{ $namaUsaha->bidang_usaha }}</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>:</td>
                            <td>{{ $namaUsaha->alamat_lengkap }}</td>
                        </tr>
                        <tr>
                            <td>Status Akun Perusahaan</td>
                            <td>:</td>
                            <td>
                                @if ($namaUsaha->is_verify)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Verifikasi</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- LOWONGAN TERBARU --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Lowongan Terbaru</h5>
                    <ul class="list-group">
                        @forelse($lowonganTerbaru as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $item->judul }}
                                <span class="badge bg-info">
                                    Deadline: {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Belum ada lowongan</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        {{-- PELAMAR TERBARU --}}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-3">Pelamar Terbaru</h5>

                    <ul class="list-group">
                        @forelse($lamaranTerbaru as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">

                                <div>
                                    <strong>
                                        {{ $item->pelamar->nama ?? 'User tidak ditemukan' }}
                                        —
                                        <span class="text-primary">
                                            {{ $item->lowongan->judul ?? 'Lowongan tidak ditemukan' }}
                                        </span>
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                                    </small>
                                </div>

                                <span
                                    class="badge
                            @if ($item->status == 'Diterima') bg-success
                            @elseif($item->status == 'Dikirim') bg-warning text-dark
                            @elseif($item->status == 'Ditolak') bg-danger
                            @else bg-secondary @endif">
                                    {{ $item->status }}
                                </span>

                            </li>
                        @empty
                            <li class="list-group-item text-muted">
                                Belum ada lamaran
                            </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>

@endsection
