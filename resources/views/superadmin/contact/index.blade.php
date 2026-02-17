@extends('adminlte::page')

@section('title', 'Data Contact')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Pesan</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Pesan</li>
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

        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="bg-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="120">Status</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($contacts as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $item->name }}</strong><br>
                                <small class="text-muted">
                                    {{ $item->created_at->diffForHumans() }}
                                </small>
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->is_read)
                                    <span class="badge badge-success">
                                        Dibaca
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Baru
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('superadmin.contacts.show', $item->id) }}" class="btn btn-xs btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <form action="{{ route('superadmin.contacts.destroy', $item->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-xs btn-danger" onclick="return confirm('Hapus pesan ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                Belum ada pesan masuk
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
