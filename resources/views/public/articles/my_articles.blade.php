@extends('layouts.public')

@section('title', $title)
@section('content')

@section('hero')
@section('hero_title', 'Informasi')
@section('hero_subtitle', $title)
@endsection
<div class="container my-5">

<h3 class="fw-bold mb-4">{{ $title }}</h3>

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
                        {{ $article->created_at->format('d M Y') }}
                    </p>

                    <p class="text-muted small flex-grow-1">
                        {{ Str::limit(strip_tags($article->content), 100) }}
                    </p>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('public.articles.show', $article->slug) }}"
                            class="btn btn-sm btn-outline-primary">
                            Baca Selengkapnya
                        </a>

                        <small class="text-muted">
                            <i class="fas fa-heart text-danger"></i>
                            {{ $article->likes_count ?? 0 }}
                            ·
                            <i class="fas fa-bookmark text-warning"></i>
                            {{ $article->bookmarks_count ?? 0 }}
                            ·
                            <i class="fas fa-eye"></i>
                            {{ number_format($article->views) }}
                        </small>
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-5">
            <i class="fas fa-newspaper fa-2x mb-3"></i>
            <p>Tidak ada artikel ditemukan</p>
        </div>
    @endforelse
</div>

{{-- ===== PAGINATION ===== --}}
<div class="mt-5 d-flex justify-content-center">
    {{ $articles->links() }}
</div>

</div>
@endsection
