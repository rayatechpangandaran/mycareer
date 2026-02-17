@extends('adminlte::page')

@section('title', 'Lowongan Pekerjaan')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Lowongan Pekerjaan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Lowongan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('superadmin.lowongan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Lowongan
        </a>
    </div>

    {{-- Nav Tabs --}}
    <ul class="nav nav-tabs mb-3" id="lowonganTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="draft-tab" data-toggle="tab" href="#draft" role="tab" aria-controls="draft"
                aria-selected="true">
                Draft
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="publish-tab" data-toggle="tab" href="#publish" role="tab" aria-controls="publish"
                aria-selected="false">
                Publish
            </a>
        </li>
    </ul>

    <div class="tab-content" id="lowonganTabsContent">
        {{-- Draft Tab --}}
        <div class="tab-pane fade show active" id="draft" role="tabpanel" aria-labelledby="draft-tab">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Judul Lowongan</th>
                            <th>Perusahaan</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowongans->where('status','Draft') as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->judul }}</td>
                                <td>{{ $row->perusahaan->nama_bisnis_usaha ?? '-' }}</td>
                                <td><span class="badge badge-warning">Draft</span></td>
                                <td>
                                    <button class="btn btn-sm btn-success btn-acc" data-id="{{ $row->id }}"
                                        data-title="{{ $row->judul }}" title="ACC">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-reject" data-id="{{ $row->id }}"
                                        data-title="{{ $row->judul }}" title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <a href="{{ route('superadmin.lowongan.show', $row->id) }}" class="btn btn-sm btn-info"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('superadmin.lowongan.edit', $row->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada lowongan Draft</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Publish Tab --}}

        <div class="tab-pane fade" id="publish" role="tabpanel" aria-labelledby="publish-tab">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No</th>
                            <th>Judul Lowongan</th>
                            <th>Perusahaan</th>
                            <th>Status</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowongans->where('status','Publish') as $i => $row)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $row->judul }}</td>
                                <td>{{ $row->perusahaan->nama_bisnis_usaha ?? '-' }}</td>
                                <td><span class="badge badge-success">Publish</span></td>
                                <td>
                                    <a href="{{ route('superadmin.lowongan.show', $row->id) }}" class="btn btn-sm btn-info"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada lowongan Publish</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    @include('superadmin.components.toastr')

    {{-- Modal Status --}}
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="statusForm" method="POST">
                    @csrf
                    <input type="hidden" name="status" id="statusInput">
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <span id="statusMessage">Apakah Anda yakin ingin mengubah status lowongan ini?</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ya, Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Delegated events untuk tombol ACC / Reject
            $(document).on('click', '.btn-acc', function() {
                let id = $(this).data('id');
                let title = $(this).data('title');
                $('#statusForm').attr('action', `/superadmin/lowongan/${id}/status`);
                $('#statusInput').val('Publish');
                $('#statusMessage').text(`Apakah Anda yakin ingin ACC lowongan "${title}"?`);
                $('#statusModal').modal('show');
            });

            $(document).on('click', '.btn-reject', function() {
                let id = $(this).data('id');
                let title = $(this).data('title');
                $('#statusForm').attr('action', `/superadmin/lowongan/${id}/status`);
                $('#statusInput').val('Rejected');
                $('#statusMessage').text(`Apakah Anda yakin ingin menolak lowongan "${title}"?`);
                $('#statusModal').modal('show');
            });
        });
    </script>
@endpush
