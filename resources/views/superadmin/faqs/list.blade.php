@extends('adminlte::page')

@section('title', 'FAQ Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>FAQ Management</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">FAQ Management</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('faqs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah FAQ
        </a>
    </div>
    <table class="table table-bordered table-striped" id="faqTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Status</th>
                <th>Urutan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($faqs as $i => $faq)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $faq->question }}</td>
                    <td>
                        @if ($faq->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>{{ $faq->order }}</td>
                    <td>
                        <a href="{{ route('faqs.edit', $faq->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('faqs.destroy', $faq->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger btn-delete"
                                data-name="{{ $faq->question }}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @include('superadmin.components.logout-modal')
    @include('superadmin.components.toastr')
@stop

@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@stop

@section('js')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-delete').click(function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                const name = $(this).data('name');

                Swal.fire({
                    title: 'Hapus FAQ?',
                    html: 'Apakah Anda yakin ingin menghapus FAQ: <strong>' + name + '</strong>?',
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

@stop
