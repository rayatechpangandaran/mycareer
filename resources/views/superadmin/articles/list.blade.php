@extends('adminlte::page')

@section('title', 'Artikel Management')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Artikel</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Artikel</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('articles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="articleTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Author</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $i => $article)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $article->title }}</td>
                        <td>
                            @if ($article->status === 'published')
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </td>
                        <td>{{ $article->views }}</td>
                        <td>{{ $article->author?->nama ?? '-' }}</td>
                        <td>
                            <a href="{{ route('articles.show', $article->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete"
                                    data-name="{{ $article->title }}">
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

    {{ $articles->links('pagination::bootstrap-4') }}
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
                    title: 'Hapus Artikel?',
                    html: 'Apakah Anda yakin ingin menghapus Artikel : <strong>' + name +
                        '</strong>?',
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
