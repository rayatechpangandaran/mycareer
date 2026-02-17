@extends('adminlte::page')


@section('title', 'Edit Carousel')

@section('content')
    <div class="container-fluid">
        <h4 class="mb-3">Edit Carousel</h4>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('superadmin.carousel.update', $carousel->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Gambar Carousel</label><br>
                        <img src="{{ asset('storage/' . $carousel->image) }}" class="img-thumbnail mb-2"
                            style="max-height: 150px;">
                        <input type="file" name="image" class="form-control">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="is_active" class="form-check-input"
                            {{ $carousel->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">Aktifkan Carousel</label>
                    </div>

                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('superadmin.carousel.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
