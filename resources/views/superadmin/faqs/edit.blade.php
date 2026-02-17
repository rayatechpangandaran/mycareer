@extends('adminlte::page')

@section('title', 'Edit FAQ')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Form Edit FAQ</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">FAQ Management</a></li>
            <li class="breadcrumb-item active">Form Edit FAQ</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">

            {{-- Form edit FAQ --}}
            <form action="{{ route('faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Pertanyaan --}}
                <div class="form-group">
                    <label for="question">Pertanyaan</label>
                    <input type="text" name="question" id="question"
                        class="form-control @error('question') is-invalid @enderror"
                        value="{{ old('question', $faq->question) }}" placeholder="Masukkan pertanyaan">
                    @error('question')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jawaban --}}
                <div class="form-group">
                    <label for="answer">Jawaban</label>
                    <textarea name="answer" id="answer" class="form-control @error('answer') is-invalid @enderror" rows="5"
                        placeholder="Masukkan jawaban">{{ old('answer', $faq->answer) }}</textarea>
                    @error('answer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Urutan --}}
                <div class="form-group">
                    <label for="order">Urutan</label>
                    <input type="number" name="order" id="order" class="form-control"
                        value="{{ old('order', $faq->order) }}">
                    <small class="text-muted">Semakin kecil angkanya, semakin atas tampilannya.</small>
                </div>

                {{-- Status Aktif --}}
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                            {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Aktif</label>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update FAQ
                </button>
            </form>
        </div>
    </div>
    @include('superadmin.components.logout-modal')
    @include('superadmin.components.toastr')
@stop

@section('footer')
@stop

@section('css')
@stop

@section('js')
@stop
