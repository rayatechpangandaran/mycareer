@extends('admin_usaha.layouts.app')

@section('title', 'Lamaran Lowongan')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lamaran Lowongan</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Data Lowongan & Jumlah Pelamar</h4>

                    {{-- Search Input --}}
                    <div class="mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari lowongan...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped" id="lowonganTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Posisi Lowongan</th>
                                    <th>Tanggal Dibuat</th>
                                    <th>Jumlah Pelamar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lowongan as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->judul }}</td>
                                        <td>{{ \Carbon\Carbon::parse($row->created_at)->translatedFormat('l, d F Y') }}
                                        </td>
                                        <td>
                                            {{ $row->lamaran_count }}
                                            @if ($row->lamaran_count == 0)
                                                <span class="text-muted">(Belum ada pelamar)</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin_usaha.lamaran.show', $row->id) }}"
                                                class="btn btn-sm btn-inverse-info btn-fw" title="Lihat Pelamar">
                                                <i class="mdi mdi-information"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Belum ada lowongan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/skydash/js/custom.js') }}"></script>
    @endpush
@endsection
