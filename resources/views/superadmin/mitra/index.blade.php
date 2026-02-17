@extends('adminlte::page')

@section('title', 'Request Mitra Usaha')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">
                Mitra Usaha
            </h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Mitra Usaha</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('mitra.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Mitra
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Usaha</th>
                    <th>Nama Penanggung Jawab</th>
                    <th>Jenis</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usaha as $u)
                    <tr>
                        <td>{{ $u->nama_bisnis_usaha }}</td>
                        <td>{{ $u->nama_penanggung_jawab }}</td>
                        <td>{{ $u->jenis_usaha }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <a href="{{ url('superadmin/mitra/' . $u->usaha_id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('mitra.edit', $u->usaha_id) }}" class="btn btn-warning text-white btn-sm">
                                <i class="fas fa-eye"></i> Ubah
                            </a>
                            <form action="{{ route('mitra.destroy', $u->usaha_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                    data-id="{{ $u->usaha_id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>


                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const name = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Mitra?',
                    html: 'Apakah Anda yakin ingin menghapus Mitra?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(function(result) {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        });
    </script>

@endsection
