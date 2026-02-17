@extends('adminlte::page')

@section('title', 'Profile Superadmin')

@section('content_header')
    <h1>Profile</h1>
@stop

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-body">

                        @php
                            $user = auth()->user();
                            $gravatar =
                                'https://www.gravatar.com/avatar/' .
                                md5(strtolower(trim($user->email))) .
                                '?s=200&d=mp';
                        @endphp

                        <div class="text-center mb-4">
                            <img src="{{ Auth::user()->avatar }}" class="rounded-circle shadow" width="120" height="120">
                            <h4 class="mt-3">{{ $user->nama }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('superadmin.profile.update') }}" method="POST">

                            @csrf
                            @method('PUT')

                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control"
                                    value="{{ old('nama', $user->nama) }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Email (Tidak bisa diubah)</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            </div>

                            <hr>

                            <div class="form-group mb-3">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Kosongkan jika tidak ingin mengganti">
                            </div>

                            <div class="form-group mb-3">
                                <label>Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Update Profile
                            </button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
