@extends('layouts.public')
@section('title', 'Informasi Lowongna Kerja & Berita Pangandaran')
@section('content')

@section('hero')
@section('hero_title', 'Informasi')
@section('hero_subtitle', 'Informasi dan Berita Pangandaran')
@endsection
{{-- ================= HERO HEADER ================= --}}
<section class="bg-light border-bottom">
<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-8 mb-3 mb-lg-0">
            <h1 class="fw-bold display-6 mb-2">
                Informasi Terkait
            </h1>
        </div>

        <div class="col-lg-4">
            <form action="{{ route('public.articles.index') }}" method="GET">
                <div class="input-group search-group shadow-sm">
                    <input type="text" name="q" class="form-control" placeholder="Cari Informasi..."
                        value="{{ request('q') }}">
                    <button class="btn btn-orange search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>


    </div>
    <div class="mb-3 small text-muted">
        <a href="{{ url('/') }}" class="text-decoration-none text-muted">
            Beranda
        </a>
        <span class="mx-1">›</span>
        <span class="fw-semibold text-dark">
            Informasi
        </span>
    </div>

    {{-- ================= FILTER TABS ================= --}}
    <div class="mt-4 overflow-auto">
        <ul class="nav nav-pills gap-2 flex-nowrap">
            <li class="nav-item">
                <a href="{{ route('public.articles.index') }}"
                    class="nav-link nav-orange {{ request('filter') === null ? 'active text-white' : 'text-dark' }}">
                    <i class="fas fa-list {{ request('filter') === null ? 'text-white' : 'text-dark' }}"></i> Semua
                    Informasi
                </a>
            </li>
            @auth
                <li class="nav-item">
                    <a href="{{ route('public.articles.index', ['filter' => 'liked']) }}"
                        class="nav-link nav-orange {{ request('filter') === 'liked' ? 'active' : '' }}">
                        <i
                            class="fas fa-heart {{ request('filter') === 'liked' ? 'active text-white' : 'text-danger' }}"></i>
                        {{ $userLikedArticles->count() }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('public.articles.index', ['filter' => 'bookmarked']) }}"
                        class="nav-link nav-orange {{ request('filter') === 'bookmarked' ? 'active' : '' }}">
                        <i
                            class="fas fa-bookmark {{ request('filter') === 'bookmarked' ? 'active text-white' : 'text-warning' }}"></i>
                        {{ $userBookmarkedArticles->count() }}
                    </a>
                </li>
            @endauth
        </ul>
    </div>
</div>
</section>

{{-- ================= CONTENT ================= --}}
<section class="container my-5">
<div class="row g-4">
    {{-- ================= SIDEBAR ================= --}}
    <div class="col-lg-4 order-lg-2 order-1">
        <div class="sticky-wrapper">
            <div class="card shadow-sm border-0 sticky-sidebar mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-fire text-danger"></i> Informasi Populer</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach ($artikelPopuler as $populer)
                            <li class="d-flex gap-3 mb-3">
                                @if ($populer->thumbnail)
                                    <img src="{{ asset('storage/' . $populer->thumbnail) }}" width="100"
                                        class="rounded">
                                @endif
                                <div class="flex-grow-1">
                                    <a href="{{ route('public.articles.show', $populer->slug) }}"
                                        class="fw-semibold text-dark d-block text-decoration-none">
                                        {{ Str::limit($populer->title, 55) }}
                                    </a>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-heart text-danger"></i> {{ $populer->likes_count }}
                                        · <i class="fas fa-bookmark text-warning"></i>
                                        {{ $populer->bookmarks_count }}
                                        · <i class="fas fa-eye"></i> {{ number_format($populer->views) }}
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- ================= LIST ARTIKEL ================= --}}
    <div class="col-lg-8 order-lg-1 order-2">
        <div class="row g-4">
            @forelse ($articles as $article)
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        @if ($article->thumbnail)
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="card-img-top"
                                style="height:180px;object-fit:cover">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold mb-2">
                                <a href="{{ route('public.articles.show', $article->slug) }}"
                                    class="text-dark text-decoration-none">
                                    {{ $article->title }}
                                </a>
                            </h6>

                            <p class="text-muted small mb-2">
                                <i class="fas fa-user"></i>
                                {{ $article->author->nama ?? 'Admin' }}
                                ·
                                <i class="fas fa-calendar"></i>
                                {{ $article->created_at->diffForHumans() }}
                            </p>

                            <p class="text-muted small flex-grow-1">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>

                            {{-- Statistik like/bookmark/view --}}
                            <div class="d-flex gap-2 flex-wrap justify-content-start mb-2">
                                <span><i class="fas fa-heart text-danger"></i>
                                    {{ $article->likes_count ?? 0 }}</span>
                                <span><i class="fas fa-bookmark text-warning"></i>
                                    {{ $article->bookmarks_count ?? 0 }}</span>
                                <span><i class="fas fa-eye"></i> {{ number_format($article->views) }}</span>
                            </div>

                            {{-- Tombol Baca Selengkapnya --}}
                            <a href="{{ route('public.articles.show', $article->slug) }}"
                                class="btn btn-sm btn-outline-primary w-100 text-center">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-newspaper fa-2x mb-3"></i>
                    <p>Informasi tidak ditemukan</p>
                </div>
            @endforelse
        </div>

        {{-- ===== PAGINATION ===== --}}
        <div class="mt-5 d-flex justify-content-center">
            {{ $articles->withQueryString()->links() }}
        </div>
    </div>

</div>
</section>

@endsection
