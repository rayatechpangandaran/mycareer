@extends('admin_usaha.layouts.app')

@section('title', 'Edit Lowongan Kerja')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.lowongan.index') }}">Lowongan Kerja</a></li>
            <li class="breadcrumb-item active">Edit Lowongan</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Edit Lowongan Kerja</h4>
                    <p class="text-danger">* Wajib diisi</p>

                    <form id="form-lowongan" action="{{ route('admin_usaha.lowongan.update', $lowongan->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- TIPE PEKERJAAN --}}
                        <div class="form-group mb-3">
                            <label>Tipe Pekerjaan *</label>
                            <select name="tipe_pekerjaan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @foreach (['Fulltime', 'Parttime', 'Magang', 'Freelance', 'Kontrak'] as $tipe)
                                    <option value="{{ $tipe }}"
                                        {{ $lowongan->tipe_pekerjaan == $tipe ? 'selected' : '' }}>
                                        {{ $tipe }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- JUDUL --}}
                        <div class="form-group mb-3">
                            <label>Posisi Lowongan *</label>
                            <input type="text" name="judul" class="form-control" value="{{ $lowongan->judul }}"
                                required>
                        </div>

                        {{-- KATEGORI --}}
                        <div class="form-group mb-3">
                            <label>Kategori Pekerjaan *</label>
                            <input type="text" name="kategori" class="form-control" value="{{ $lowongan->kategori }}"
                                required>
                        </div>

                        {{-- PENDIDIKAN TERAKHIR --}}
                        <div class="form-group mb-3">
                            <label>Pendidikan Terakhir *</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select" required>
                                @php
                                    $pendidikanOptions = ['SD/MI', 'SMP/MTS', 'SMA/SMK/MA', 'S1', 'S2', 'S3'];
                                @endphp
                                <option value="">-- Pilih --</option>
                                @foreach ($pendidikanOptions as $pendidikan)
                                    <option value="{{ $pendidikan }}"
                                        {{ $lowongan->pendidikan_terakhir == $pendidikan ? 'selected' : '' }}>
                                        {{ $pendidikan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- JURUSAN (OPSIONAL) --}}
                        <div class="form-group mb-3" id="jurusanWrapper" style="display:none">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" id="jurusan" class="form-control"
                                placeholder="Contoh: Manajemen, Informatika"
                                value="{{ old('jurusan', $lowongan->jurusan) }}">
                            <small class="text-muted">
                                Kosongkan jika tidak mensyaratkan jurusan tertentu
                            </small>
                        </div>

                        {{-- LOKASI --}}
                        @php
                            $lokasi = explode(',', $lowongan->lokasi);
                            $kota = trim($lokasi[0] ?? '');
                            $provinsi = trim($lokasi[1] ?? '');
                        @endphp

                        <div class="form-group mb-3">
                            <label>Provinsi *</label>
                            <select id="province" class="form-select" required>
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Kabupaten / Kota *</label>
                            <select id="city" class="form-select" required disabled>
                                <option value="">-- Pilih Kota --</option>
                            </select>
                        </div>

                        <input type="hidden" name="lokasi" id="lokasi" value="{{ $lowongan->lokasi }}">

                        {{-- DESKRIPSI --}}
                        <div class="form-group mb-3">
                            <label>Deskripsi Pekerjaan *</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required>{{ $lowongan->deskripsi }}</textarea>
                        </div>

                        {{-- KUALIFIKASI --}}
                        <div class="form-group mb-3">
                            <label>Kualifikasi Pekerjaan *</label>
                            <textarea name="kualifikasi" class="form-control" rows="4" required>{{ $lowongan->kualifikasi }}</textarea>
                        </div>

                        {{-- JUMLAH --}}
                        <div class="form-group mb-3">
                            <label>Jumlah Lowongan *</label>
                            <input type="number" name="jumlah_lowongan" class="form-control"
                                value="{{ $lowongan->jumlah_lowongan }}" min="1" required>
                        </div>

                        {{-- GAJI --}}
                        <div class="form-group mb-3">
                            <label>Gaji Minimum</label>
                            <input type="text" id="gaji_min" class="form-control"
                                value="{{ number_format($lowongan->gaji_min, 0, ',', '.') }}">
                            <input type="hidden" name="gaji_min" id="gaji_min_value" value="{{ $lowongan->gaji_min }}">
                        </div>

                        <div class="form-group mb-3">
                            <label>Gaji Maksimum</label>
                            <input type="text" id="gaji_max" class="form-control"
                                value="{{ number_format($lowongan->gaji_max, 0, ',', '.') }}">
                            <input type="hidden" name="gaji_max" id="gaji_max_value" value="{{ $lowongan->gaji_max }}">
                        </div>

                        {{-- DEADLINE --}}
                        <div class="form-group mb-4">
                            <label>Deadline *</label>
                            <input type="date" name="deadline" class="form-control"
                                value="{{ date('Y-m-d', strtotime($lowongan->deadline)) }}" required>
                        </div>

                        {{-- BROSUR --}}
                        <div class="form-group mb-4">
                            <label>Brosur Lowongan (Opsional)</label>
                            <div id="drop-area" class="border rounded p-4 text-center"
                                style="border-style: dashed; cursor:pointer">
                                <p class="text-muted mb-2">Drag & drop brosur di sini<br>atau klik untuk pilih file</p>
                                <input type="file" name="brosur" id="brosurInput" class="d-none" accept="image/*">
                                <img id="previewBrosur" class="img-fluid mt-3 rounded" style="max-height:200px"
                                    src="{{ $lowongan->brosur != 'assets/img/brosur/brosur-default.png'
                                        ? asset('storage/' . $lowongan->brosur)
                                        : asset($lowongan->brosur) }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Perbarui</button>
                        <a href="{{ route('admin_usaha.lowongan.index') }}" class="btn btn-light">Batal</a>
                    </form>

                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            window.selectedProv = @json($provinsi);
            window.selectedCity = @json($kota);
        </script>
        <script src="{{ asset('assets/skydash/js/editLowongan.js') }}"></script>
    @endpush

@endsection
