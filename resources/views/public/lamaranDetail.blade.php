@extends('layouts.public')

@section('title', 'Temukan Lowongan Kerja Pangandaran')
@section('hero')
@section('hero_title', 'Lowongan Detail')
@section('hero_subtitle', $lowongan->judul)
@endsection
@section('content')

<!--LOKER -->
<section class="container my-4">
    <div class="row">

        <!-- JOB DETAIL -->
        <div class="col-lg-12">
            <div class="mb-3 small text-muted">
                <a href="{{ url('/') }}" class="text-decoration-none text-muted">
                    Beranda
                </a>
                <span class="mx-1">›</span>

                <a href="{{ route('lowonganAll') }}" class="text-decoration-none text-muted">
                    Lowongan
                </a>
                <span class="mx-1">›</span>

                <span class="fw-semibold text-dark">
                    Detail Lowongan
                </span>
            </div>
            <div class="card job-detail-card shadow-sm mb-4">
                <div class="card-body">

                    {{-- ================= HEADER ================= --}}
                    <div class="job-header d-flex flex-column flex-md-row gap-3 align-items-md-center mb-3">
                        @php
                            $isExpired = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($lowongan->deadline));
                        @endphp

                        <img src="{{ asset('storage/' . $lowongan->perusahaan->banner_logo_usaha) }}"
                            class="job-logo-lg" alt="Logo">

                        <div class="flex-grow-1 job-info">

                            <h5 class="fw-bold mb-2">
                                {{ $lowongan->judul }}
                            </h5>

                            <div class="company-name mb-1">
                                <i class="bi bi-building"></i>
                                {{ $lowongan->perusahaan->nama_bisnis_usaha }}
                            </div>

                            <div class="job-meta">
                                <span>
                                    <i class="bi bi-geo-alt"></i>
                                    {{ ucwords(strtolower($lowongan->lokasi)) }}
                                </span>

                                <span>
                                    <i class="bi bi-briefcase"></i>
                                    {{ $lowongan->tipe_pekerjaan }}
                                </span>

                                <span>
                                    <i class="bi bi-clock"></i>
                                    {{ $lowongan->created_at->diffForHumans() }}
                                </span>
                            </div>

                        </div>
                    </div>


                    <hr>


                    {{-- ================= RINGKASAN INFO ================= --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <small class="text-muted">Kisaran Gaji</small>
                            <div class="fw-semibold">
                                Rp {{ number_format($lowongan->gaji_min) }}
                                – Rp {{ number_format($lowongan->gaji_max) }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Pendidikan Minimal</small>
                            <div class="fw-semibold">
                                {{ $lowongan->pendidikan_terakhir ?? 'Tidak ditentukan' }}

                                @if (in_array($lowongan->pendidikan_terakhir, ['D3', 'S1', 'S2', 'S3']) && !empty($lowongan->jurusan))
                                    <span class="text-muted">
                                        – {{ $lowongan->jurusan }}
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="col-md-4">
                            <small class="text-muted">Jumlah Lowongan</small>
                            <div class="fw-semibold">
                                {{ $lowongan->jumlah_lowongan }} Orang
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Jurusan</small>
                            <div class="fw-semibold">
                                {{ $lowongan->jurusan ?? 'Semua Jurusan' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Kategori</small>
                            <div class="fw-semibold">
                                {{ $lowongan->kategori }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Batas Lamaran</small>
                            <div class="fw-semibold {{ $isExpired ? 'text-danger' : 'text-success' }}">
                                {{ \Carbon\Carbon::parse($lowongan->deadline)->translatedFormat('d F Y') }}
                            </div>

                        </div>
                    </div>

                    {{-- ================= DESKRIPSI ================= --}}
                    <h6 class="fw-bold">Deskripsi Pekerjaan</h6>
                    @php
                        $deskripsi = preg_split("/\r\n|\n|\r/", $lowongan->deskripsi);
                    @endphp

                    <ul class="text-muted">
                        @foreach ($deskripsi as $item)
                            @if (trim($item))
                                <li>{{ $item }}</li>
                            @endif
                        @endforeach
                    </ul>

                    {{-- ================= KUALIFIKASI ================= --}}
                    <h6 class="fw-bold mt-3">Kualifikasi</h6>
                    @php
                        $kualifikasi = preg_split("/\r\n|\n|\r/", $lowongan->kualifikasi);
                    @endphp

                    <ul class="text-muted">
                        @foreach ($kualifikasi as $item)
                            @if (trim($item))
                                <li>{{ $item }}</li>
                            @endif
                        @endforeach
                    </ul>

                    <hr>

                    {{-- ================= CTA ================= --}}
                    <div
                        class="job-action d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-4">

                        {{-- STATUS --}}
                        <div>
                            @if ($isExpired)
                                <span class="badge bg-secondary px-3 py-2">
                                    <i class="bi bi-x-circle-fill me-1"></i>
                                    Lowongan Expired
                                </span>
                            @endif
                        </div>

                        {{-- ACTION BUTTON --}}
                        <div>

                            @if ($isExpired)
                                <button class="btn btn-secondary btn-lg" disabled>
                                    <i class="bi bi-lock-fill me-1"></i>
                                    Lowongan Ditutup
                                </button>
                            @else
                                @auth
                                    @if ($sudahMelamar)
                                        <button class="btn btn-secondary btn-lg" disabled>
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Sudah Melamar
                                        </button>
                                    @else
                                        <a href="{{ route('applyNow', $lowongan->id) }}" class="btn btn-apply-lg">
                                            <i class="bi bi-lightning-charge-fill me-1"></i>
                                            Lamar Sekarang
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-apply-lg">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>
                                        Login untuk Melamar
                                    </a>
                                @endauth

                            @endif

                        </div>

                    </div>



                </div>
            </div>


        </div>

    </div>
</section>

@endsection
