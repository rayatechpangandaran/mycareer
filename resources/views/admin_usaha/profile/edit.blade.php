@extends('admin_usaha.layouts.app')

@section('title', 'Profil Mitra Usaha')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil Mitra Usaha</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-3">
                        <i class="mdi mdi-storefront-outline"></i> Profil Mitra Usaha
                    </h3>

                    <form action="{{ route('admin_usaha.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama Bisnis --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Bisnis</label>
                            <input type="text" class="form-control" name="nama_bisnis_usaha"
                                value="{{ old('nama_bisnis_usaha', $usaha->nama_bisnis_usaha) }}" required>
                        </div>

                        {{-- Jenis Usaha --}}
                        <div class="mb-3">
                            <label class="form-label">Jenis Usaha</label>
                            <select class="form-select" name="jenis_usaha" required>
                                @foreach (['UMKM', 'CV', 'PT', 'Hotel'] as $jenis)
                                    <option value="{{ $jenis }}"
                                        {{ $usaha->jenis_usaha == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Penanggung Jawab --}}
                        <div class="mb-3">
                            <label class="form-label">Nama Penanggung Jawab</label>
                            <input type="text" class="form-control" name="nama_penanggung_jawab"
                                value="{{ old('nama_penanggung_jawab', $usaha->nama_penanggung_jawab) }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $usaha->email }}" disabled>
                        </div>

                        {{-- No WA --}}
                        <div class="mb-3">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" class="form-control" name="no_wa"
                                value="{{ old('no_wa', $usaha->no_wa) }}" required>
                        </div>
                        @php
                            $alamatParts = explode(',', $usaha->alamat_lengkap ?? '');
                            $alamatDetail = trim($alamatParts[0] ?? '');
                            $villageName = trim($alamatParts[1] ?? '');
                            $districtName = trim($alamatParts[2] ?? '');
                            $cityName = trim($alamatParts[3] ?? '');
                            $provinceName = trim($alamatParts[4] ?? '');
                        @endphp
                        {{-- Alamat Dinamis --}}
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <select id="provinceSelect" class="form-select" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kota / Kabupaten</label>
                                <select id="citySelect" class="form-select" required disabled>
                                    <option value="">-- Pilih Kota/Kabupaten --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kecamatan</label>
                                <select id="districtSelect" class="form-select" required disabled>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Desa</label>
                                <select id="villageSelect" class="form-select" required disabled>
                                    <option value="">-- Pilih Desa --</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Detail Jalan</label>
                                <input type="text" id="alamatDetail" class="form-control"
                                    placeholder="Jalan, RT/RW, No Rumah" required
                                    value="{{ old('alamat_detail', $alamatParts[0] ?? '') }}">
                            </div>
                        </div>

                        {{-- Hidden input untuk alamat lengkap --}}
                        <input type="hidden" name="alamat_lengkap" id="alamatLengkap"
                            value="{{ $usaha->alamat_lengkap }}">
                        <input type="hidden" id="alamat_old" value="{{ old('alamat_lengkap', $usaha->alamat_lengkap) }}">
                        {{-- Bidang Usaha --}}
                        <div class="mb-3">
                            <label class="form-label">Bidang Usaha</label>
                            <select class="form-select" name="bidang_usaha" required>
                                @foreach (['Kuliner', 'Retail', 'Jasa', 'Manufaktur'] as $bidang)
                                    <option value="{{ $bidang }}"
                                        {{ $usaha->bidang_usaha == $bidang ? 'selected' : '' }}>{{ $bidang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Jumlah Karyawan --}}
                        <div class="mb-3">
                            <label class="form-label">Jumlah Karyawan</label>
                            <select class="form-select" name="jml_karyawan" required>
                                @foreach (['1-5', '6-20', '> 20'] as $jumlah)
                                    <option value="{{ $jumlah }}"
                                        {{ $usaha->jml_karyawan == $jumlah ? 'selected' : '' }}>{{ $jumlah }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- NIB --}}
                        <div class="mb-3">
                            <label class="form-label">NIB (Opsional)</label>
                            <input type="text" class="form-control" name="nib"
                                value="{{ old('nib', $usaha->nib) }}">
                        </div>

                        {{-- Banner/Logo --}}
                        <div class="mb-3">
                            <label class="form-label">Logo / Banner</label>
                            @if ($usaha->banner_logo_usaha)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $usaha->banner_logo_usaha) }}" width="150"
                                        class="img-thumbnail">
                                </div>
                            @endif
                            <input type="file" class="form-control" name="banner_logo_usaha" accept="image/*">
                            <small class="text-muted">Format JPG/PNG max 4MB</small>
                        </div>

                        {{-- Bukti Usaha --}}
                        {{-- <div class="mb-3">
                            <label class="form-label">Bukti Usaha</label>
                            @if ($usaha->bukti_usaha)
                                <div class="mb-2 border rounded overflow-hidden" style="max-height:300px;">
                                    <iframe src="{{ asset('storage/' . $usaha->bukti_usaha) }}"
                                        style="width:100%;height:100%;" frameborder="0"></iframe>
                                </div>
                            @endif
                            <input type="file" class="form-control" name="bukti_usaha" accept="image/*,.pdf">
                        </div> --}}

                        {{-- Status Verifikasi --}}
                        <div class="mb-3">
                            <strong>Status Verifikasi:</strong>
                            @if ($usaha->is_verify)
                                <span class="badge bg-success">Terverifikasi</span>
                            @else
                                <span class="badge bg-warning">Belum Terverifikasi</span>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.oldAddressParts = @json($alamatParts);
        </script>

        <script src="{{ asset('assets/skydash/js/profileUsaha.js') }}"></script>
    @endpush

@endsection
