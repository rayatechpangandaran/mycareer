@extends('adminlte::page')

@section('title', 'Data Users')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Data Users
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Users</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">Tambah Akun</a>
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $u)
                <tr>
                    <td>{{ $u->nama }}</td>
                    <td>{{ $u->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <nav>
        <ul class="pagination pagination-sm">

            {{-- Prev --}}
            <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ $page - 1 }}">Previous</a>
            </li>

            {{-- Number --}}
            @for ($i = 1; $i <= $totalPages; $i++)
                <li class="page-item {{ $page == $i ? 'active' : '' }}">
                    <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Next --}}
            <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ $page + 1 }}">Next</a>
            </li>

        </ul>
    </nav>
    <br>
@endsection
