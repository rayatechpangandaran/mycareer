@extends('adminlte::page')

@section('title', 'Edit Artikel')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Form Edit Artikel</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Artikel Management</a></li>
            <li class="breadcrumb-item active">Form Edit Artikel</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $article->title) }}">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konten --}}
                <div class="form-group">
                    <label for="content">Konten</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="8">{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Thumbnail --}}
                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail"
                        class="form-control @error('thumbnail') is-invalid @enderror">
                    @if ($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="Thumbnail" class="img-thumbnail mt-2"
                            style="max-height: 150px;">
                    @endif
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status', $article->status) == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="published" {{ old('status', $article->status) == 'published' ? 'selected' : '' }}>
                            Published</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Artikel
                </button>
            </form>
        </div>
    </div>
    @include('superadmin.components.logout-modal')
    @include('superadmin.components.toastr')
@stop

@section('css')
@stop

@section('js')
@stop
