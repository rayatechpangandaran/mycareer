@extends('layouts.public')

@section('title', $article->title)
@section('content')
@section('hero')
@section('hero_title', 'Informasi')
@section('hero_subtitle', $article->title)
@endsection
<div class="container my-5">
<div class="mb-3 small text-muted">
    <a href="{{ url('/') }}" class="text-decoration-none text-muted">
        Beranda
    </a>
    <span class="mx-1">›</span>
    <a href="{{ url('/articles') }}" class="text-decoration-none text-muted">
        Informasi
    </a>
    <span class="mx-1">›</span>
    <span class="fw-semibold text-dark">
        {{ $article->title }}
    </span>
</div>


<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- ================= HEADER ARTIKEL ================= --}}
        <header class="mb-4">
            <h1 class="fw-bold mb-3">
                {{ $article->title }}
            </h1>

            <div class="text-muted small d-flex flex-wrap gap-3 align-items-center">
                <span>
                    <i class="fas fa-user"></i>
                    {{ $article->author->nama ?? 'Admin' }}
                </span>

                <span>
                    <i class="fas fa-calendar-alt"></i>
                    {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                </span>

                <span>
                    <i class="fas fa-eye"></i>
                    {{ number_format($article->views) }} views
                </span>
            </div>
        </header>

        {{-- ================= THUMBNAIL ================= --}}
        @if ($article->thumbnail)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="img-fluid rounded shadow-sm w-100"
                    style="max-height: 420px; object-fit: cover;" alt="{{ $article->title }}">
            </div>
        @endif

        {{-- ================= LIKE & BOOKMARK ================= --}}
        @auth
            <div class="mb-4 d-flex gap-3">
                <button id="likeBtn" class="btn btn-outline-danger" data-liked="{{ $isLiked ? '1' : '0' }}">
                    <i class="fas fa-heart"></i>
                    <span id="likeCount">{{ $article->likes_count }}</span>
                </button>

                <button id="bookmarkBtn" class="btn btn-outline-warning"
                    data-bookmarked="{{ $isBookmarked ? '1' : '0' }}">
                    <i class="fas fa-bookmark"></i>
                    <span id="bookmarkCount">{{ $article->bookmarks_count }}</span>
                </button>
            </div>
        @endauth

        {{-- ================= ISI ARTIKEL ================= --}}
        <article class="article-content fs-6 lh-lg mb-5">
            {!! nl2br(e($article->content)) !!}
        </article>

    </div>
</div>

{{-- ================= BERITA LAINNYA ================= --}}
@if ($beritaLainnya->count())
    <div class="mt-5">
        <h5 class="fw-bold mb-4">Berita Lainnya</h5>

        <div class="row g-4">
            @foreach ($beritaLainnya as $item)
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">

                        @if ($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="card-img-top"
                                style="height: 160px; object-fit: cover;">
                        @endif

                        <div class="card-body">
                            <h6 class="fw-semibold mb-2">
                                <a href="{{ route('public.articles.show', $item->slug) }}"
                                    class="text-dark text-decoration-none">
                                    {{ Str::limit($item->title, 60) }}
                                </a>
                            </h6>

                            <small class="text-muted">
                                {{ $item->published_at ? $item->published_at->format('d M Y') : $item->created_at->format('d M Y') }}
                            </small>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

</div>

@auth
{{-- ================= AJAX LIKE & BOOKMARK ================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const likeBtn = document.getElementById('likeBtn');
        const bookmarkBtn = document.getElementById('bookmarkBtn');

        likeBtn?.addEventListener('click', function() {
            fetch("{{ route('article.like', $article->id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    likeBtn.dataset.liked = data.liked ? '1' : '0';
                    document.getElementById('likeCount').textContent = data.count;
                    likeBtn.classList.toggle('btn-danger', data.liked);
                    likeBtn.classList.toggle('btn-outline-danger', !data.liked);
                });
        });

        bookmarkBtn?.addEventListener('click', function() {
            fetch("{{ route('article.bookmark', $article->id) }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    bookmarkBtn.dataset.bookmarked = data.bookmarked ? '1' : '0';
                    document.getElementById('bookmarkCount').textContent = data.count;
                    bookmarkBtn.classList.toggle('btn-warning', data.bookmarked);
                    bookmarkBtn.classList.toggle('btn-outline-warning', !data.bookmarked);
                });
        });
    });
</script>
@endauth

@endsection
