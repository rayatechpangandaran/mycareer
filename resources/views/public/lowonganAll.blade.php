@extends('layouts.public')

@section('title', 'Temukan Lowongan Kerja Pangandaran')
@section('hero')
@section('hero_title', 'Lowongan Kerja')
@section('hero_subtitle', 'Daftar Lowongan Kerja yang tersedia')
@endsection
@section('content')

<section class="container my-4" id="lowongan">
    <div class="mb-3 small text-muted">
        <a href="{{ url('/') }}" class="text-decoration-none text-muted">
            Beranda
        </a>
        <span class="mx-1">›</span>
        <span class="fw-semibold text-dark">
            Lowongan
        </span>
    </div>
    <div class="hero text-center shadow-lg p-4 rounded">
        <h4 class="fw-bold mb-4">Cari Lowongan Pekerjaan</h4>
        <div class="row g-2 justify-content-center">
            <div class="col-md-4">
                <input id="searchInput" type="text" class="form-control" placeholder="Posisi Lowongan, keyword">
            </div>
            <div class="col-md-3">
                <select id="locationInput">
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <a href="{{ route('lowonganAll') }}" class="btn-search">
                    <i class="bi bi-arrow-clockwise"></i> Reset
                </a>
            </div>
        </div>
    </div>
</section>

<section class="container my-4">
    <div class="row">
        <aside class="col-lg-3 mb-3">
            <div class="card filter-card shadow-lg">
                <div class="card-body">
                    <label>Kategori</label>
                    <select id="kategoriFilter" class="form-select mb-3">
                        <option value="">Semua Kategori</option>
                        @foreach ($lowongans->pluck('kategori')->unique() as $kategori)
                            @if ($kategori)
                                <option value="{{ strtolower($kategori) }}">{{ $kategori }}</option>
                            @endif
                        @endforeach
                    </select>

                    <label>Pendidikan</label>
                    <select id="pendidikanFilter" class="form-select mb-3">
                        <option value="">Minimal Pendidikan</option>
                        @foreach ($lowongans->pluck('pendidikan_terakhir')->unique() as $pendidikan)
                            @if ($pendidikan)
                                <option value="{{ strtolower($pendidikan) }}">{{ $pendidikan }}</option>
                            @endif
                        @endforeach
                    </select>

                    <label>Gaji</label>
                    <select id="gajiFilter" class="form-select mb-3">
                        <option value="">Kisaran Gaji</option>
                        <option value="0-2000000">0 - 2 juta</option>
                        <option value="2000000-5000000">2 - 5 juta</option>
                        <option value="5000000-10000000">5 - 10 juta</option>
                        <option value="10000000-50000000">10 - 50 juta</option>
                    </select>

                    <label>Tipe</label>
                    <select id="tipeFilter" class="form-select">
                        <option value="">Semua Tipe</option>
                        @foreach ($lowongans->pluck('tipe_pekerjaan')->unique() as $tipe)
                            @if ($tipe)
                                <option value="{{ strtolower($tipe) }}">{{ $tipe }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </aside>

        <div class="col-lg-9 job-scroll" id="jobList">
            @forelse($lowongans as $loker)
                <div class="card job-card mb-4 shadow-lg" data-judul="{{ strtolower($loker->judul) }}"
                    data-lokasi="{{ strtolower($loker->lokasi) }}"
                    data-kategori="{{ strtolower($loker->kategori ?? '') }}"
                    data-pendidikan="{{ strtolower($loker->pendidikan_terakhir ?? '') }}"
                    data-tipe="{{ strtolower($loker->tipe_pekerjaan ?? '') }}"
                    data-gaji-min="{{ $loker->gaji_min ?? 0 }}" data-gaji-max="{{ $loker->gaji_max ?? 0 }}">

                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $loker->perusahaan && $loker->perusahaan->banner_logo_usaha ? asset('storage/' . $loker->perusahaan->banner_logo_usaha) : asset('assets/img/logo-default.png') }}"
                                class="job-logo" alt="Logo">
                            <div>
                                <!-- Judul + pesan di samping -->
                                <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                    <h6 class="fw-bold mb-0">{{ $loker->judul }}</h6>
                                    @auth
                                        @if (in_array($loker->id, $lamaranUser))
                                            <div class="already-applied-message">
                                                <i class="bi bi-exclamation-circle-fill"></i>
                                                Posisi ini sudah Anda lamar
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                                <code>{{ $loker->perusahaan->nama_bisnis_usaha ?? '-' }}</code><br>
                                <small class="text-muted">
                                    {{ 'Rp.' . number_format($loker->gaji_min) . ' - Rp.' . number_format($loker->gaji_max) }}
                                    | <span
                                        class="badge bg-primary">{{ ucfirst($loker->tipe_pekerjaan ?? 'Full Time') }}</span>
                                </small><br>
                                <small class="text-muted">{{ $loker->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <a href="{{ route('lamaranDetail', $loker->id) }}"
                                class="btn-apply d-flex align-items-center gap-2 justify-content-center">
                                <i class="bi bi-lightning-charge-fill"></i>
                                Lamar Cepat
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-jobs text-center py-5">
                    <i class="bi bi-emoji-frown fs-1 mb-2 text-muted"></i>
                    <p class="text-muted fs-5">Ups! Tidak ada lowongan yang sesuai dengan pencarian atau filter kamu.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {
        $('#locationInput').select2({
            placeholder: "Pilih Provinsi",
            width: '100%'
        });
    });
</script>
@endsection
