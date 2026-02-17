@extends('adminlte::page')

@section('title', 'Request Mitra Usaha')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Request Mitra Usaha
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Request</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Usaha</th>
                    <th>Jenis</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usaha as $u)
                    <tr>
                        <td>{{ $u->nama_bisnis_usaha }}</td>
                        <td>{{ $u->jenis_usaha }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            @if ($u->is_verify == 0)
                                <span class="badge badge-warning">Pending</span>
                            @elseif($u->is_verify == 1)
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('superadmin/usaha/' . $u->usaha_id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
    @include('../superadmin.components.toastr')

@endsection
