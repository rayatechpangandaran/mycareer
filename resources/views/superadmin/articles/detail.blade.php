@extends('adminlte::page')

@section('title', 'Detail Artikel')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Detail Artikel</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Artikel Management</a></li>
            <li class="breadcrumb-item active">Detail Artikel</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            <h2>{{ $article->title }}</h2>
            <p class="text-muted">
                Ditulis oleh <strong>{{ $article->author->nama }}</strong>
                | Dipublikasikan: {{ $article->published_at?->format('d M Y') ?? '-' }}
                | Views: {{ $article->views }}
            </p>

            @if ($article->thumbnail)
                <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="img-fluid mb-3">
            @endif

            <div class="article-content">
                {!! nl2br(e($article->content)) !!}
            </div>

            {{-- Like & Bookmark --}}
            @auth
                <div class="mt-4">
                    <button type="button"
                        class="btn btn-sm btn-like {{ $article->likes->contains(auth()->user()->user_id) ? 'btn-success' : 'btn-outline-success' }}"
                        data-id="{{ $article->id }}">
                        <i class="fas fa-thumbs-up"></i>
                        <span class="like-count">{{ $article->likes->count() }}</span>
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-bookmark {{ $article->bookmarks->contains(auth()->user()->user_id) ? 'btn-primary' : 'btn-outline-primary' }}"
                        data-id="{{ $article->id }}">
                        <i class="fas fa-bookmark"></i>
                        <span class="bookmark-count">{{ $article->bookmarks->count() }}</span>
                    </button>

                </div>
            @endauth

        </div>
    </div>

    @include('superadmin.components.logout-modal')
    @include('superadmin.components.toastr')
@stop

@section('css')
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrf = '{{ csrf_token() }}';

            // LIKE
            document.querySelector('.btn-like')?.addEventListener('click', function() {
                const btn = this;
                const id = btn.dataset.id;

                fetch(`/article/${id}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        btn.classList.toggle('btn-success', data.liked);
                        btn.classList.toggle('btn-outline-success', !data.liked);
                        btn.querySelector('.like-count').innerText = data.count;
                    });
            });

            // BOOKMARK
            document.querySelector('.btn-bookmark')?.addEventListener('click', function() {
                const btn = this;
                const id = btn.dataset.id;

                fetch(`/article/${id}/bookmark`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        btn.classList.toggle('btn-primary', data.bookmarked);
                        btn.classList.toggle('btn-outline-primary', !data.bookmarked);
                        btn.querySelector('.bookmark-count').innerText = data.count;
                    });
            });
        });
    </script>
@stop
