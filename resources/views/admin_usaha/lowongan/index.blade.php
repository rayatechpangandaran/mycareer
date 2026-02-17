@extends('admin_usaha.layouts.app')

@section('title', 'Lowongan Kerja')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin_usaha.dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Lowongan Kerja</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h4 class="card-title mb-0">Data Lowongan Kerja</h4>

                        <div class="input-group input-group-sm w-auto">
                            <span class="input-group-text bg-light fw-semibold">
                                <i class="mdi mdi-filter me-1" id="filterIcon"></i>
                                Filter
                            </span>
                            <select id="filterStatus" class="form-select fw-semibold">
                                <option value="all">Semua Status</option>
                                <option value="Publish">Dipublish</option>
                                <option value="Draft">Draft</option>
                                <option value="Rejected">Ditolak Admin</option>
                                <option value="Trash">Riwayat</option>
                            </select>
                        </div>

                    </div>

                    <a href="{{ route('admin_usaha.lowongan.create') }}" class="btn btn-primary btn-rounded btn-fw mb-3">
                        Add <i class="mdi mdi-book-plus"></i>
                    </a>

                    {{-- ================= TABLE ================= --}}
                    <div class="table-responsive">
                        <table class="table table-striped" id="lowonganTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Lowongan</th>
                                    <th>Tipe Pekerjaan</th>
                                    <th>Status</th>
                                    <th>Settings</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lowongans as $row)
                                    <tr data-status="{{ $row->deleted_at ? 'Trash' : $row->status }}">
                                        <td class="row-number">{{ $loop->iteration }}</td>

                                        <td>
                                            <h6 class="mb-0">{{ $row->judul }}</h6>
                                        </td>

                                        <td><code>{{ $row->tipe_pekerjaan }}</code></td>

                                        <td>
                                            @if ($row->deleted_at)
                                                <span class="badge bg-dark">Riwayat</span>
                                            @elseif ($row->status === 'Draft')
                                                <span class="badge bg-warning">Draft</span>
                                            @elseif ($row->status === 'Rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-success">Published</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{-- DETAIL --}}
                                            <a href="{{ route('admin_usaha.lowongan.show', $row->id) }}"
                                                class="btn btn-sm btn-inverse-info btn-fw">
                                                <i class="mdi mdi-information"></i>
                                            </a>

                                            @if ($row->status === 'Draft' && !$row->deleted_at)
                                                <a href="{{ route('admin_usaha.lowongan.edit', $row->id) }}"
                                                    class="btn btn-sm btn-inverse-warning btn-fw" title="Edit Lowongan">
                                                    <i class="mdi mdi-tooltip-edit"></i>
                                                </a>
                                            @endif


                                            {{-- DELETE --}}
                                            <form action="{{ route('admin_usaha.lowongan.destroy', $row->id) }}"
                                                method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-inverse-danger btn-fw btn-delete">
                                                    <i class="mdi mdi-delete-sweep"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada lowongan
                                        </td>
                                    </tr>
                                @endforelse
                                <tr id="emptyRow" style="display: none;">
                                    <td colspan="5" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="mdi mdi-database-off fs-1 d-block mb-2"></i>
                                            <strong>Tidak ada lowongan</strong>
                                            <div class="small mt-1">
                                                Data tidak ditemukan untuk filter yang dipilih
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/skydash/js/custom.js') }}"></script>
        <script src="{{ asset('assets/skydash/js/confirmDelete.js') }}"></script>
    @endpush


@endsection
