@extends('layouts.public')

@section('title', 'Temukan Lowongan Kerja Pangandaran')

@section('content')


    <script>
        $(document).ready(function() {
            $('#locationInput').select2({
                placeholder: "Pilih Provinsi",
                width: '100%'
            });
        });
    </script>

    <section class="container my-5">
        <div class="card about-card shadow-sm">
            <div class="row g-0 align-items-center">

                <div class="col-md-6 p-4 order-2 order-md-1">

                    <p class="text-danger fw-semibold mb-1">
                        Sulit cari kerja? Atau usaha kamu sepi pelamar?
                    </p>

                    <h3 class="fw-bold mt-2">
                        Buka & Cari Lowongan Kerja<br>
                        Sekaligus Promosi UMKM
                    </h3>

                    <p class="text-muted mt-3">
                        Platform ini mempertemukan <strong>UMKM, CV, PT, Hotel, dan pelaku usaha</strong>
                        dengan <strong>pencari kerja yang siap langsung melamar</strong>,
                        tanpa ribet dan tanpa biaya mahal.
                    </p>

                    <p class="text-muted">
                        Pasang lowongan, promosikan usaha, dan temukan kandidat terbaik
                        dalam satu tempat yang mudah diakses siapa saja.
                    </p>
                    <div class="benefit-list mt-3">
                        <div class="benefit-item">
                            <i class="bi bi-check-circle-fill"></i>
                            Pendaftaran Gratis
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-lightning-charge-fill"></i>
                            Website Mudah Digunakan
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-shop"></i>
                            Cocok untuk UMKM
                        </div>
                        <div class="benefit-item">
                            <i class="bi bi-briefcase-fill"></i>
                            Cocok untuk Pencari Kerja
                        </div>
                    </div>
                    <div class="d-flex flex-wrap gap-3 mt-3">
                        @if (!auth()->check() || auth()->user()->role !== 'pelamar')
                            <a href="{{ route('register') }}" class="btn-post-job" target="_blank">
                                <span class="icon"><i class="bi bi-megaphone"></i></span>
                                <span class="text">Pasang Lowongan</span>
                            </a>
                        @endif

                        <a href="#lowongan" class="btn-search-job">
                            <span class="icon">
                                <i class="bi bi-search"></i>
                            </span>
                            <span class="text">Cari Lowongan</span>
                        </a>

                    </div>


                </div>

                <div class="col-md-6 order-1 order-md-2">
                    <div id="aboutCarousel" class="carousel slide h-100" data-bs-ride="carousel">

                        {{-- Indicators --}}
                        <div class="carousel-indicators custom-indicators">
                            @foreach ($carousels as $key => $item)
                                <button type="button" data-bs-target="#aboutCarousel"
                                    data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}">
                                </button>
                            @endforeach
                        </div>

                        {{-- Slides --}}
                        <div class="carousel-inner h-100">
                            @foreach ($carousels as $key => $item)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}  carousel-fixed">
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                        class="d-block w-100 h-100 carousel-img" alt="Carousel {{ $key + 1 }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- BUTTON PREV -->
                        <button class="carousel-control-prev custom-carousel-btn" type="button"
                            data-bs-target="#aboutCarousel" data-bs-slide="prev">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <!-- BUTTON NEXT -->
                        <button class="carousel-control-next custom-carousel-btn" type="button"
                            data-bs-target="#aboutCarousel" data-bs-slide="next">
                            <i class="bi bi-chevron-right"></i>
                        </button>

                    </div>
                </div>


            </div>
        </div>
    </section>


    <section class="container my-5">

        <div class="text-center mb-4">
            <h4 class="fw-bold">Job Perusahaan</h4>
        </div>

        @php
            $chunks = $mitras->chunk(2);
        @endphp

        <div id="mitraCarousel" class="carousel slide" data-bs-ride="carousel">

            <!-- ICON INDICATOR -->
            <div class="carousel-indicators custom-indicators">
                @foreach ($chunks as $index => $chunk)
                    <button type="button" data-bs-target="#mitraCarousel" data-bs-slide-to="{{ $index }}"
                        class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}">
                        <i class="bi bi-circle-fill"></i>
                    </button>
                @endforeach
            </div>

            <div class="carousel-inner">

                @foreach ($chunks as $index => $chunk)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="row g-2 justify-content-center text-center">

                            @foreach ($chunk as $mitra)
                                <div class="col-6 col-lg-2">
                                    <div class="mitra-card">

                                        <div class="mitra-logo">
                                            @php
                                                $logo = $mitra->banner_logo_usaha
                                                    ? asset('storage/' . $mitra->banner_logo_usaha)
                                                    : asset('assets/img/logo-default.png');
                                            @endphp
                                            <img src="{{ $logo }}" alt="{{ $mitra->nama_bisnis_usaha }}">
                                        </div>

                                        <div class="mitra-name">
                                            {{ $mitra->nama_bisnis_usaha }}
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endforeach

            </div>

            <!-- CONTROL -->
            <button class="carousel-control-prev" type="button" data-bs-target="#mitraCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#mitraCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
            </button>

        </div>

    </section>

    <!-- HERO SEARCH -->
    <section class="container my-4" id="lowongan">
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
                    <a href="{{ route('home') }}" class="btn-search">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- LOKER & FILTER -->
    <section class="container my-4">
        <div class="row">

            <!-- FILTER -->
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

            <!-- JOB LIST -->
            <div class="col-lg-9 job-scroll" id="jobList">
                @forelse($lowongans as $loker)
                    <div class="card job-card mb-4 shadow-lg" data-judul="{{ strtolower($loker->judul) }}"
                        data-lokasi="{{ strtolower($loker->lokasi) }}"
                        data-kategori="{{ strtolower($loker->kategori ?? '') }}"
                        data-pendidikan="{{ strtolower($loker->pendidikan_terakhir ?? '') }}"
                        data-tipe="{{ strtolower($loker->tipe_pekerjaan ?? '') }}"
                        data-gaji-min="{{ $loker->gaji_min ?? 0 }}" data-gaji-max="{{ $loker->gaji_max ?? 0 }}">

                        <div
                            class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="d-flex gap-3">
                                <img src="{{ $loker->perusahaan && $loker->perusahaan->banner_logo_usaha ? asset('storage/' . $loker->perusahaan->banner_logo_usaha) : asset('assets/img/logo-default.png') }}"
                                    class="job-logo" alt="Logo" style="width:90px; height:90px; object-fit:cover;">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $loker->judul }}</h6>
                                    <code>{{ $loker->perusahaan->nama_bisnis_usaha ?? '-' }}
                                    </code><br>
                                    <small
                                        class="text-muted">{{ 'Rp.' . number_format($loker->gaji_min) . ' - Rp.' . number_format($loker->gaji_max) }}
                                        | <span
                                            class="badge bg-primary">{{ ucfirst($loker->tipe_pekerjaan ?? 'Full Time') }}</span></small><br>
                                    <small class="text-muted">
                                        {{ $loker->created_at->diffForHumans() }}
                                    </small>
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


    <!-- AWAS JANGAN DIRUSAK YA INI SECTION BAGIAN ARTIKEL HEHE -->

    <section class="container my-5">
        <div class="text-center mb-3">
            <h5 class="fw-bold">Informasi Terkait</h5>
        </div>
        <div class="row g-4">
            <div class="col-lg-6">
                <div id="artikelCarousel" class="carousel slide shadow-sm rounded-4 overflow-hidden"
                    data-bs-ride="carousel">

                    <div class="carousel-inner">

                        @forelse ($carouselArtikel as $i => $artikel)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $artikel->thumbnail) }}" class="d-block w-100"
                                    alt="{{ $artikel->title }}" style="height: 580px">

                                <div class="carousel-caption text-start">
                                    <h5 class="fw-bold">{{ $artikel->title }}</h5>

                                    <a href="{{ route('public.articles.show', $artikel->slug) }}"
                                        class="btn btn-sm btn-light">
                                        Baca Artikel
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="https://via.placeholder.com/800x400" class="d-block w-100">
                                <div class="carousel-caption">
                                    <p>Belum ada artikel</p>
                                </div>
                            </div>
                        @endforelse

                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#artikelCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#artikelCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm rounded-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Informasi Terbaru</h6>

                        <ul class="list-unstyled">
                            @forelse ($artikelTerbaru as $artikel)
                                <li class="d-flex gap-3 mb-3">

                                    <img src="{{ asset('storage/' . $artikel->thumbnail) }}" height="90px"
                                        width="90px" class="rounded">

                                    <div class="flex-grow-1">
                                        <a href="{{ route('public.articles.show', $artikel->slug) }}"
                                            class="fw-semibold d-block text-dark text-decoration-none">
                                            {{ $artikel->title }}
                                        </a>

                                        <small class="text-muted d-block mb-1">
                                            {{ $artikel->created_at->diffForHumans() }}
                                        </small>

                                        {{-- INFO LIKE & BOOKMARK (READ ONLY) --}}
                                        <div class="d-flex gap-3 text-muted small"
                                            title="Login untuk menyukai atau menyimpan artikel">
                                            <span>
                                                <i class="fas fa-thumbs-up"></i>
                                                {{ $artikel->likes_count }}
                                            </span>

                                            <span>
                                                <i class="fas fa-bookmark"></i>
                                                {{ $artikel->bookmarks_count }}
                                            </span>
                                            <span>
                                                <i class="fas fa-eye"></i>
                                                {{ number_format($artikel->views) }}x Dilihat
                                            </span>
                                        </div>
                                    </div>

                                </li>
                            @empty
                                <li class="text-muted">Belum ada artikel</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </section>

@endsection
