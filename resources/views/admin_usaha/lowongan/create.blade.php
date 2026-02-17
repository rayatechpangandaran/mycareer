@extends('admin_usaha.layouts.app')

@section('title', 'Tambah Lowongan Kerja')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.lowongan.index') }}">Lowongan Kerja</a></li>
            <li class="breadcrumb-item active">Tambah Lowongan</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Tambah Lowongan Kerja</h4>
                    <p class="text-danger">* Wajib diisi</p>

                    <form id="form-lowongan" action="{{ route('admin_usaha.lowongan.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- TIPE PEKERJAAN --}}
                        <div class="form-group mb-3">
                            <label>Tipe Pekerjaan *</label>
                            <select name="tipe_pekerjaan" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Fulltime">Fulltime</option>
                                <option value="Parttime">Parttime</option>
                                <option value="Magang">Magang</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Kontrak">Kontrak</option>
                            </select>
                        </div>

                        {{-- JUDUL --}}
                        <div class="form-group mb-3">
                            <label>Posisi Lowongan *</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        {{-- KATEGORI --}}
                        <div class="form-group mb-3">
                            <label>Kategori Pekerjaan *</label>
                            <select name="kategori" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="IT & Digital">IT & Digital</option>
                                <option value="Administrasi & Perkantoran">Administrasi & Perkantoran</option>
                                <option value="Pendidikan & Training">Pendidikan & Training</option>
                                <option value="Kesehatan & Medis">Kesehatan & Medis</option>
                                <option value="Teknik & Produksi">Teknik & Produksi</option>
                                <option value="Jasa & Pelayanan">Jasa & Pelayanan</option>
                                <option value="Transportasi & Logistik">Transportasi & Logistik</option>
                                <option value="Creative & Media">Creative & Media</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Pendidikan Terakhir *</label>
                            <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="SD/MI">SD/MI</option>
                                <option value="SMP/MTS">SMP/MTS</option>
                                <option value="SMA/SMK/MA">SMA/SMK/MA</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>

                        {{-- JURUSAN (OPSIONAL) --}}
                        <div class="form-group mb-3" id="jurusanWrapper" style="display:none;">
                            <label>Jurusan (Opsional)</label>
                            <input type="text" name="jurusan" id="jurusan" class="form-control"
                                placeholder="Contoh: Manajemen, Informatika, Bisnis">
                            <small class="text-muted">
                                Kosongkan jika tidak ada jurusan khusus
                            </small>
                        </div>


                        {{-- LOKASI (INDO REGION) --}}
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

                        <input type="hidden" name="lokasi" id="lokasi">

                        {{-- DESKRIPSI --}}
                        <div class="form-group mb-3">
                            <label>Deskripsi Pekerjaan *</label>
                            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>

                        {{-- KUALIFIKASI --}}
                        <div class="form-group mb-3">
                            <label>Kualifikasi Pekerjaan *</label>
                            <textarea name="kualifikasi" class="form-control" rows="4" required></textarea>
                        </div>

                        {{-- JUMLAH LOWONGAN --}}
                        <div class="form-group mb-3">
                            <label>Jumlah Lowongan *</label>
                            <input type="number" name="jumlah_lowongan" class="form-control" min="1" required>
                        </div>

                        {{-- GAJI MIN --}}
                        <div class="form-group mb-3">
                            <label>Gaji Minimum</label>
                            <input type="text" id="gaji_min" class="form-control" placeholder="Rp 2.000.000">
                            <input type="hidden" name="gaji_min" id="gaji_min_value">
                        </div>

                        {{-- GAJI MAX --}}
                        <div class="form-group mb-3">
                            <label>Gaji Maksimum</label>
                            <input type="text" id="gaji_max" class="form-control" placeholder="Rp 3.000.000">
                            <input type="hidden" name="gaji_max" id="gaji_max_value">
                        </div>

                        {{-- DEADLINE --}}
                        <div class="form-group mb-4">
                            <label>Deadline *</label>
                            <input type="date" name="deadline" class="form-control" required>
                        </div>

                        {{-- BROSUR --}}
                        <div class="form-group mb-4">
                            <label>Brosur Lowongan (Opsional)</label>
                            <div id="drop-area" class="border rounded p-4 text-center"
                                style="border-style: dashed; cursor: pointer;">
                                <p class="text-muted mb-2">Drag & drop brosur di sini<br>atau klik untuk pilih file</p>
                                <input type="file" name="brosur" id="brosurInput" class="d-none" accept="image/*">
                                <img id="previewBrosur" class="img-fluid mt-3 rounded"
                                    src="{{ asset('assets/img/brosur/brosur-default.png') }}" style="max-height: 200px;">
                            </div>
                            <small class="text-muted">JPG / PNG • max 5MB • kosongkan jika ingin pakai brosur
                                default</small>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan (Draft)</button>
                        <a href="{{ route('admin_usaha.lowongan.index') }}" class="btn btn-light">Batal</a>
                    </form>

                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('assets/skydash/js/custom.js') }}"></script>
    @endpush

@endsection
