@extends('adminlte::page')

@section('title', 'Tambah Artikel')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Form Tambah Artikel</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">Artikel Management</a></li>
            <li class="breadcrumb-item active">Form Tambah Artikel</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul --}}
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" id="title"
                        class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                        placeholder="Masukkan judul artikel">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Konten --}}
                <div class="form-group">
                    <label for="content">Konten</label>
                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="8"
                        placeholder="Masukkan konten artikel">{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Thumbnail --}}
                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail"
                        class="form-control @error('thumbnail') is-invalid @enderror">
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Artikel
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
