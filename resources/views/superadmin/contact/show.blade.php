@extends('adminlte::page')

@section('title', 'Detail Pesan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pesan</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.contacts.index') }}">Pesan</a></li>
            <li class="breadcrumb-item">Detail Pesan</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Informasi Pengirim</strong>
            </div>

            <div class="card-body">

                {{-- INFORMASI --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted mb-1">Nama</label>
                        <div class="font-weight-bold">
                            {{ $contact->name }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted mb-1">Email</label>
                        <div>
                            <a href="mailto:{{ $contact->email }}">
                                {{ $contact->email }}
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted mb-1">Subjek</label>
                    <div class="font-italic">
                        {{ $contact->subject ?? '-' }}
                    </div>
                </div>

                <hr>

                {{-- PESAN --}}
                <div class="mb-4">
                    <label class="text-muted mb-1">Isi Pesan</label>
                    <div class="border rounded p-3 bg-light" style="white-space: pre-line">
                        {{ $contact->message }}
                    </div>
                </div>

                <hr>

                {{-- FOOTER ACTION --}}
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="far fa-clock"></i>
                        {{ $contact->created_at->format('d M Y, H:i') }}
                    </small>

                    <div>
                        <form action="{{ route('superadmin.contacts.destroy', $contact->id) }}" method="POST"
                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
