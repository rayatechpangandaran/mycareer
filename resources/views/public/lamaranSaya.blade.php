@extends('layouts.public')

@section('title', 'Temukan Lowongan Kerja Pangandaran')

@section('content')
    <style>
        .skill-tags .badge {
            background: linear-gradient(135deg, #6f42c1, #6610f2);
            color: #fff;
            font-weight: 500;
            transition: transform 0.2s;
        }

        .skill-tags .badge:hover {
            transform: scale(1.1);
        }

        .meta-box {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-radius: 12px;
            background: #f8f9fa;
            transition: 0.3s ease;
        }

        .meta-box:hover {
            background: #eef2ff;
            transform: translateY(-3px);
        }

        .meta-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        /* Skill pill modern */
        .skill-pill {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 50px;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 13px;
            font-weight: 500;
            margin: 4px 4px 4px 0;
            transition: 0.3s ease;
        }

        .skill-pill:hover {
            background: #4f46e5;
            color: white;
        }

        .cv-box {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border-radius: 12px;
            background: #f8f9fa;
            transition: 0.3s ease;
            cursor: pointer;
        }

        .cv-box:hover {
            background: #eef2ff;
            transform: translateY(-3px);
        }

        .cv-box:hover .bi-arrow-right {
            transform: translateX(5px);
            transition: 0.3s ease;
        }

        .lamaran-card {
            border-radius: 12px;
        }

        .table-hover tbody tr {
            transition: 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background: #f8f9fa;
        }

        .filter-select {
            max-width: 180px;
        }

        @media (max-width: 768px) {

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                padding: 15px;
                margin-bottom: 15px;
                border-bottom: 2px solid #f1f1f1;
                background: #fff;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 6px 0;
                font-size: 14px;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6c757d;
            }

            .modal-modern .modal-content {
                border-radius: 18px;
                overflow: hidden;
                animation: modalZoom 0.3s ease;
            }

            @keyframes modalZoom {
                from {
                    transform: scale(0.9);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .job-logo-lg {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 12px;
            }

            .job-meta span {
                margin-right: 15px;
                font-size: 14px;
                color: #6c757d;
            }

            .job-meta i {
                margin-right: 5px;
            }

            .modal-modern .modal-body {
                background: #fff;
            }

            .modal-content {
                border-radius: 18px;
                overflow: hidden;
            }

            @media (max-width: 576px) {
                .modal-dialog {
                    margin: 1rem;
                }
            }

        }
    </style>

    <section class="container my-4">
        <div class="row g-4">
            <div class="col-lg-8">

                {{-- Profile Card --}}
                <div class="card shadow-sm border-0 mb-4 profile-card">
                    <div class="card-body">

                        <div class="row align-items-center">

                            {{-- FOTO (TETAP TENGAH) --}}
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}"
                                    class="rounded-circle img-fluid" alt="Foto Profil" style="max-width:150px;">
                            </div>

                            {{-- DETAIL --}}
                            <div class="col-md-6">

                                {{-- NAMA (TENGAH MOBILE) --}}
                                <h5 class="fw-bold mb-1 text-center text-md-start">
                                    {{ auth()->user()->nama }}
                                </h5>

                                {{-- EMAIL (TENGAH MOBILE) --}}
                                <div class="small text-muted text-center text-md-start mb-2">
                                    <i class="bi bi-envelope"></i>
                                    {{ auth()->user()->email }}
                                </div>

                                {{-- WA (PAKSA KIRI) --}}
                                <div class="small text-muted text-start">
                                    <i class="bi bi-telephone"></i>
                                    {{ $profile->no_wa ?? '-' }}
                                </div>

                                {{-- ALAMAT (PAKSA KIRI) --}}
                                <div class="small text-muted text-start">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $profile->alamat ?? '-' }}
                                </div>

                            </div>

                            {{-- ACTION --}}
                            <div class="col-md-3 text-start text-md-end mt-3 mt-md-0">
                                <button type="button" class="btn btn-apply-lg" data-bs-toggle="offcanvas"
                                    data-bs-target="#editProfileMeta">
                                    <i class="bi bi-pencil"></i> Edit Profil
                                </button>
                            </div>

                        </div>

                        <hr>

                        {{-- INFO TAMBAHAN --}}
                        <div class="row g-3">

                            {{-- Pendidikan --}}
                            <div class="col-md-4">
                                <div class="meta-box">
                                    <div class="meta-icon bg-primary">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Pendidikan</small>
                                        <div class="fw-semibold">
                                            {{ $profile->pendidikan_terakhir ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Jurusan --}}
                            <div class="col-md-4">
                                <div class="meta-box">
                                    <div class="meta-icon bg-success">
                                        <i class="bi bi-book"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Jurusan</small>
                                        <div class="fw-semibold">
                                            {{ $profile->jurusan ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Lamaran --}}
                            <div class="col-md-4">
                                <div class="meta-box">
                                    <div class="meta-icon bg-warning">
                                        <i class="bi bi-briefcase"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Total Lamaran</small>
                                        <div class="fw-semibold">
                                            {{ $lamaran->count() }} Lamaran
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>


                {{-- Skill & CV --}}
                <div class="card shadow-sm border-0 cv-card mb-4">
                    <div class="card-body">

                        {{-- SKILL --}}
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-stars me-2 text-warning"></i>Skill
                        </h6>

                        <div class="skill-tags">
                            @php
                                $skills = explode(',', $profile->keahlian ?? '');
                            @endphp

                            @if ($skills && count($skills) > 0 && trim($skills[0]) != '')
                                @foreach ($skills as $skill)
                                    <span class="skill-pill">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            @else
                                <small class="text-muted">Belum ada skill</small>
                            @endif
                        </div>
                        <br>
                        {{-- CV --}}
                        @if ($profile->cv)
                            <a href="{{ Storage::url($profile->cv) }}" target="_blank" class="cv-box text-decoration-none">

                                <div>
                                    <i class="bi bi-file-earmark-text text-primary fs-4"></i>
                                </div>

                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">Curriculum Vitae</div>
                                    <small class="text-muted">Klik untuk melihat CV</small>
                                </div>

                                <div>
                                    <i class="bi bi-arrow-right text-muted"></i>
                                </div>

                            </a>
                        @endif


                    </div>
                </div>


                {{-- Lamaran Saya --}}

                <div class="card shadow-sm border-0 lamaran-card">

                    <div class="card-header bg-white border-0">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-2">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-briefcase me-2 text-primary"></i>
                                Lamaran Saya
                            </h5>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <div class="container">
                                <table class="table align-middle table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Posisi</th>
                                            <th>Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($lamaran as $item)
                                            @php
                                                $statusClass = match ($item->status) {
                                                    'Diterima' => 'success',
                                                    'Ditolak' => 'danger',
                                                    'Dikirim' => 'warning',
                                                    default => 'secondary',
                                                };
                                            @endphp

                                            <tr>
                                                <td data-label="Posisi" class="fw-semibold">
                                                    {{ $item->lowongan->judul ?? '-' }}
                                                </td>

                                                <td data-label="Status" class="fw-semibold">
                                                    <span class="badge bg-{{ $statusClass }} px-3 py-2">
                                                        {{ $item->status }}
                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    <button class="btn btn-apply-lg"
                                                        onclick="loadDetail({{ $item->id }})">
                                                        Detail
                                                    </button>
                                                </td>
                                            </tr>

                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">
                                                    Belum ada lamaran
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <br>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

            {{-- Sidebar filter --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Rekomendasi Lowongan Kerja</h6>
                        <hr>
                        @if ($lowonganAll->isEmpty())
                            <small class="text-muted text-center">Belum ada lowongan sesuai pendidikan mu <br>
                                Cek Semua Lowongan <a href="{{ route('lowonganAll') }}">disini</a></small>
                        @else
                            <ul class="list-unstyled job-mini-list">

                                @foreach ($lowonganAll as $low)
                                    <li>
                                        <img src="{{ asset('storage/' . $low->perusahaan->banner_logo_usaha) }}">
                                        <div>
                                            <a href="{{ route('lamaranDetail', $low->id) }}"><?php echo $low->judul; ?></a>
                                            <small><?php echo $low->perusahaan->nama_bisnis_usaha; ?> • {{ $low->created_at->diffForHumans() }} </small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Detail Lamaran -->
        <div class="modal fade" id="detailModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detail Lamaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        Memuat detail...
                    </div>
                </div>
            </div>
        </div>



        {{-- Offcanvas Edit Profil --}}
        <div class="offcanvas offcanvas-end offcanvas-scroll" tabindex="-1" id="editProfileMeta" style="width:780px">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title">{{ auth()->user()->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <form action="{{ route('pelamar.updateProfil') }}" method="POST" enctype="multipart/form-data"
                id="formProfilPelamar">
                @csrf

                @php
                    $skillList = [
                        'Komunikasi',
                        'Kerja Tim',
                        'Manajemen Waktu',
                        'Problem Solving',
                        'Kepemimpinan',
                        'Adaptif',
                        'Public Speaking',
                        'Administrasi',
                        'Data Entry',
                        'Customer Service',
                        'Sales',
                        'Negosiasi',
                        'Manajemen Proyek',
                        'Desain Grafis',
                        'Editing Video',
                        'Content Writing',
                        'Social Media',
                        'Copywriting',
                        'Microsoft Office',
                        'Excel',
                        'Web Dasar',
                        'Analisis Data',
                    ];
                    $selectedSkills = explode(',', $profile->keahlian ?? '');
                    $alamatParts = explode(',', $profile->alamat ?? '');
                @endphp

                <div class="offcanvas-body">
                    {{-- Pendidikan --}}
                    <div class="mb-3">
                        <label class="form-label">Pendidikan Terakhir</label>
                        <select name="pendidikan_terakhir" id="pendidikanSelect" class="form-control">
                            <option value="">-- Pilih --</option>
                            <option value="SD/MI"
                                {{ ($profile->pendidikan_terakhir ?? '') == 'SD/MI' ? 'selected' : '' }}>SD/MI
                            </option>
                            <option value="SMP/MTS"
                                {{ ($profile->pendidikan_terakhir ?? '') == 'SMP/MTS' ? 'selected' : '' }}>
                                SMP/MTS</option>
                            <option value="SMA/SMK/MA"
                                {{ ($profile->pendidikan_terakhir ?? '') == 'SMA/SMK/MA' ? 'selected' : '' }}>SMA/SMK/MA
                            </option>
                            <option value="S1" {{ ($profile->pendidikan_terakhir ?? '') == 'S1' ? 'selected' : '' }}>
                                S1
                            </option>
                            <option value="S2" {{ ($profile->pendidikan_terakhir ?? '') == 'S2' ? 'selected' : '' }}>
                                S2
                            </option>
                            <option value="S3" {{ ($profile->pendidikan_terakhir ?? '') == 'S3' ? 'selected' : '' }}>
                                S3
                            </option>
                        </select>
                    </div>

                    {{-- Jurusan --}}
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" id="jurusan" class="form-control"
                            value="{{ $profile->jurusan ?? '' }}">
                    </div>

                    {{-- Skill --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Skill (maksimal 5)</label>
                        <div class="row g-2" id="skillWrapper">
                            @foreach ($skillList as $skill)
                                <div class="col-lg-3 col-md-4 col-6">
                                    <label class="skill-check">
                                        <input type="checkbox" name="keahlian[]" value="{{ $skill }}"
                                            class="skill-input" {{ in_array($skill, $selectedSkills) ? 'checked' : '' }}>
                                        <span>{{ $skill }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted d-block mt-2" id="skillInfo">Pilih maksimal 5 skill</small>
                    </div>

                    {{-- No WhatsApp --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No WhatsApp</label>
                        <input type="text" name="no_wa" class="form-control" value="{{ $profile->no_wa ?? '' }}">
                    </div>
                    @php
                        $alamatParts = explode(',', $profile->alamat ?? '');
                        $alamatDetail = trim($alamatParts[0] ?? '');
                        $villageName = trim($alamatParts[1] ?? '');
                        $districtName = trim($alamatParts[2] ?? '');
                        $cityName = trim($alamatParts[3] ?? '');
                        $provinceName = trim($alamatParts[4] ?? '');
                    @endphp
                    {{-- Alamat --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat</label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <select id="provinceSelect" class="form-select" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <select id="citySelect" class="form-select" required disabled>
                                    <option value="">-- Pilih Kota/Kabupaten --</option>
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <select id="districtSelect" class="form-select" required disabled>
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>

                            <div class="col-md-6 mt-2">
                                <select id="villageSelect" class="form-select" required disabled>
                                    <option value="">-- Pilih Desa --</option>
                                </select>
                            </div>

                            <div class="col-12 mt-2">
                                <input type="text" id="alamatDetail" class="form-control" placeholder="Jl./RT/RW"
                                    value="{{ $alamatParts[0] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="alamat_old" value="{{ $profile->alamat }}">
                    <input type="hidden" name="alamat" id="alamat" value="{{ $profile->alamat }}">


                    {{-- CV --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Upload CV (PDF)</label>
                        @if ($profile->cv)
                            <div class="alert alert-light border d-flex align-items-center gap-3">
                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-3"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">CV sudah diupload <i
                                            class="fa fa-check-circle text-success"></i></div>
                                    <a href="{{ Storage::url($profile->cv) }}" target="_blank">
                                        <small class="text-muted">Klik lihat untuk preview</small>
                                    </a>
                                </div>
                            </div>
                        @endif
                        <input type="file" name="cv" class="form-control" accept="application/pdf">
                        <small class="text-muted">Format PDF • Maksimal 2MB</small>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn-apply-full">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="offcanvas-footer p-3 border-top">
                    <h5 class="offcanvas-title">Edit Profil {{ auth()->user()->nama }}</h5>

                </div>

            </form>
        </div>
        <!-- Modal Detail Lamaran -->
        <div class="modal fade" id="detailLamaranModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0 shadow">

                    <div class="modal-header">
                        <h5 class="modal-title">Detail Lamaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body" id="detailLamaranContent">
                        <div class="text-center text-muted py-5">
                            <div class="spinner-border"></div>
                            <p class="mt-2">Memuat detail...</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>

    {{-- Script Dinamis Skill & Alamat --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /** =======================
             * SKILL MAX 5
             * ======================= */
            const maxSkill = 5;
            const checkboxes = document.querySelectorAll('.skill-input');
            const info = document.getElementById('skillInfo');

            function updateSkillState() {
                const checked = document.querySelectorAll('.skill-input:checked').length;
                checkboxes.forEach(cb => {
                    if (!cb.checked) cb.disabled = checked >= maxSkill;
                });
                info.textContent = checked >= maxSkill ?
                    `Maksimal ${maxSkill} skill dipilih` :
                    `Pilih maksimal ${maxSkill} skill (${checked}/${maxSkill})`;
            }

            checkboxes.forEach(cb => cb.addEventListener('change', updateSkillState));
            updateSkillState();

            /** =======================
             * ALAMAT DINAMIS (PROVINSI -> KOTA -> KECAMATAN -> DESA)
             * ======================= */
            const province = document.getElementById('provinceSelect');
            const city = document.getElementById('citySelect');
            const district = document.getElementById('districtSelect');
            const village = document.getElementById('villageSelect');
            const alamatDetail = document.getElementById('alamatDetail');
            const alamatInput = document.getElementById('alamat');

            function resetSelect(select, placeholder) {
                select.innerHTML = `<option value="">${placeholder}</option>`;
                select.disabled = true;
            }

            // Preload alamat lama
            let oldAddressParts = {!! json_encode($alamatParts) !!}; // [detail, desa, kec, kota, prov]

            // Old value tracker supaya klik tapi tidak ubah value tidak reset
            let oldProvince = oldAddressParts[4] || '';
            let oldCity = oldAddressParts[3] || '';
            let oldDistrict = oldAddressParts[2] || '';

            // Load provinsi
            fetch('/provinces').then(res => res.json()).then(data => {
                data.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.code;
                    option.textContent = p.name;
                    if (oldProvince && oldProvince.trim() === p.name.trim()) {
                        option.selected = true;
                    }
                    province.appendChild(option);
                });

                if (province.value) loadCities(province.value, true);
            });

            function loadCities(provinceCode, isInitial = false) {
                resetSelect(city, '-- Pilih Kota/Kabupaten --');
                resetSelect(district, '-- Pilih Kecamatan --');
                resetSelect(village, '-- Pilih Desa --');

                fetch(`/cities/${provinceCode}`).then(res => res.json()).then(data => {
                    data.forEach(c => {
                        const option = document.createElement('option');
                        option.value = c.code;
                        option.textContent = c.name;
                        if (isInitial && oldCity && oldCity.trim() === c.name.trim()) {
                            option.selected = true;
                        }
                        city.appendChild(option);
                    });
                    city.disabled = false;
                    if (isInitial && city.value) loadDistricts(city.value, true);
                });
            }

            function loadDistricts(cityCode, isInitial = false) {
                resetSelect(district, '-- Pilih Kecamatan --');
                resetSelect(village, '-- Pilih Desa --');

                fetch(`/districts/${cityCode}`).then(res => res.json()).then(data => {
                    data.forEach(d => {
                        const option = document.createElement('option');
                        option.value = d.code;
                        option.textContent = d.name;
                        if (isInitial && oldDistrict && oldDistrict.trim() === d.name.trim()) {
                            option.selected = true;
                        }
                        district.appendChild(option);
                    });
                    district.disabled = false;
                    if (isInitial && district.value) loadVillages(district.value, true);
                });
            }

            function loadVillages(districtCode, isInitial = false) {
                resetSelect(village, '-- Pilih Desa --');

                fetch(`/villages/${districtCode}`).then(res => res.json()).then(data => {
                    data.forEach(v => {
                        const option = document.createElement('option');
                        option.value = v.code;
                        option.textContent = v.name;
                        if (isInitial && oldAddressParts[1] && oldAddressParts[1].trim() === v.name
                            .trim()) {
                            option.selected = true;
                        }
                        village.appendChild(option);
                    });
                    village.disabled = false;
                });
            }

            // Event listener dengan check oldValue supaya klik tapi tidak ubah tidak reset
            province.addEventListener('change', function() {
                if (this.value && this.value !== oldProvince) {
                    oldProvince = this.value;
                    loadCities(this.value);
                }
                setAlamat();
            });

            city.addEventListener('change', function() {
                if (this.value && this.value !== oldCity) {
                    oldCity = this.value;
                    loadDistricts(this.value);
                }
                setAlamat();
            });

            district.addEventListener('change', function() {
                if (this.value && this.value !== oldDistrict) {
                    oldDistrict = this.value;
                    loadVillages(this.value);
                }
                setAlamat();
            });

            [province, city, district, village, alamatDetail].forEach(el =>
                el.addEventListener('change', setAlamat)
            );

            function getSelectedText(select) {
                if (!select.value) return '';
                const text = select.options[select.selectedIndex]?.text || '';
                return text.includes('Pilih') ? '' : text;
            }

            function setAlamat() {
                const provText = getSelectedText(province);
                const cityText = getSelectedText(city);
                const districtText = getSelectedText(district);
                const villageText = getSelectedText(village);
                const detailText = alamatDetail.value?.trim() || '';

                const alamatBaru = [
                    detailText,
                    villageText,
                    districtText,
                    cityText,
                    provText
                ].filter(v => v !== '').join(', ');

                // Kalau user tidak ubah alamat → pakai alamat lama
                alamatInput.value = alamatBaru !== '' ? alamatBaru : document.getElementById('alamat_old').value;
            }



            // Initial set alamat supaya preload langsung ke input
            setAlamat();
            const form = document.querySelector('#formProfilPelamar');

            if (form) {
                form.addEventListener('submit', function() {
                    setAlamat();
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modalEl = document.getElementById('detailLamaranModal');
            const modal = new bootstrap.Modal(modalEl);
            const content = document.getElementById('detailLamaranContent');

            document.querySelectorAll('.btn-detail-lamaran').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;

                    content.innerHTML = `
                <div class="text-center text-muted py-5">
                    <div class="spinner-border"></div>
                    <p class="mt-2">Memuat detail...</p>
                </div>
            `;

                    modal.show();

                    fetch(`/lamaran/${id}/detail-json`)
                        .then(res => {
                            if (!res.ok) throw new Error('Gagal mengambil data');
                            return res.json();
                        })
                        .then(res => {
                            const data = res.data;

                            content.innerHTML = `
                        <div class="mb-3">
                            <h5 class="fw-bold">${data.lowongan.judul}</h5>
                            <small class="text-muted">
                                ${data.lowongan.perusahaan.nama_bisnis_usaha}
                            </small>
                        </div>

                        <hr>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <strong>Status</strong><br>
                                <span class="badge bg-info">${data.status}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Tanggal Lamar</strong><br>
                                ${new Date(data.created_at).toLocaleDateString('id-ID')}
                            </div>
                        </div>

                        ${data.catatan ? `
                                                                                                                                                                                                                                                                                                                                                                                                            <div class="alert alert-warning mt-3">
                                                                                                                                                                                                                                                                                                                                                                                                                <strong>Catatan Admin:</strong><br>
                                                                                                                                                                                                                                                                                                                                                                                                                ${data.catatan}
                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                        ` : ''}

                        <div class="mt-3">
                            <a href="/storage/${data.cv}" 
                               target="_blank" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> Lihat CV
                            </a>
                        </div>
                    `;
                        })
                        .catch(() => {
                            content.innerHTML = `
                        <div class="alert alert-danger">
                            Gagal memuat detail lamaran.
                        </div>
                    `;
                        });
                });
            });

        });
    </script>

    <script>
        const detailUrlTemplate = "{{ route('user.lamaran.json', ':id') }}";

        function loadDetail(id) {

            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
            const content = document.getElementById('modalContent');

            content.innerHTML = `
                <div class="text-center py-3">
                    <div class="spinner-border text-primary"></div>
                    <div class="mt-2">Memuat detail...</div>
                </div>
            `;

            modal.show();

            let url = detailUrlTemplate.replace(':id', id);

            fetch(url)
                .then(response => {

                    if (!response.ok) {
                        throw new Error("Server error " + response.status);
                    }

                    return response.json();
                })
                .then(res => {

                    if (!res.success) {
                        content.innerHTML = "Data tidak ditemukan";
                        return;
                    }

                    const data = res.data;

                    let statusBadge;

                    switch (data.status) {
                        case 'Diterima':
                            statusBadge = '<span class="badge bg-success">Diterima</span>';
                            break;

                        case 'Ditolak':
                            statusBadge = '<span class="badge bg-danger">Ditolak</span>';
                            break;

                        case 'Dikirim':
                            statusBadge = '<span class="badge bg-warning text-white">Dikirim</span>';
                            break;

                        default:
                            statusBadge = '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                            break;
                    }
                    let cvSection = data.cv_url ?
                        `
                        <div onclick="window.open('${data.cv_url}', '_blank')" 
                            style="
                                cursor:pointer;
                                display:flex;
                                align-items:center;
                                gap:10px;
                                padding:12px;
                                background:#fd7e14; /* orange */
                                color:white;
                                border-radius:10px;
                                transition:0.3s;
                                font-weight:500;
                                box-shadow:0 2px 6px rgba(0,0,0,0.15);
                            "
                            onmouseover="this.style.background='#e06a0d'"
                            onmouseout="this.style.background='#fd7e14'">
                            📄 <span>Lihat CV</span>
                        </div>
                    ` :
                        `
                        <div class="text-muted">
                            CV tidak tersedia
                        </div>
                    `;

                    let SuratTerima = data.surat_diterima ?
                        `
                        <div onclick="window.open('${data.surat_diterima}', '_blank')" 
                            style="
                                cursor:pointer;
                                display:flex;
                                align-items:center;
                                gap:10px;
                                padding:12px;
                                background:#fd7e14; 
                                color:white;
                                border-radius:10px;
                                transition:0.3s;
                                font-weight:500;
                                box-shadow:0 2px 6px rgba(0,0,0,0.15);
                            "
                            onmouseover="this.style.background='#e06a0d'"
                            onmouseout="this.style.background='#fd7e14'">
                            📄 <span>Lihat Surat</span>
                        </div>
                    ` :
                        `
                        <div class="text-muted text-italic">
                            Surat tidak tersedia
                        </div>
                    `;



                    content.innerHTML = `
                    <div class="container-fluid p-3 p-md-4" 
                        style="background:#F7D6B7; border-radius:16px;">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h5 class="fw-bold mb-1">${data.judul ?? '-'}</h5>
                            <div class="text-muted small">${data.perusahaan ?? '-'}</div>
                        </div>

                        <!-- Detail Card -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">

                                <div class="mb-3">
                                    <div class="text-muted small">📍 Lokasi</div>
                                    <div class="fw-semibold fs-6">
                                        ${data.lokasi ?? '-'}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-muted small">💼 Tipe</div>
                                    <div class="fw-semibold fs-6">
                                        ${data.tipe ?? '-'}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-muted small">📅 Tanggal Lamar</div>
                                    <div class="fw-semibold fs-6">
                                        ${data.tanggal ?? '-'}
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <div class="text-muted small mb-1">📌 Status</div>
                                    ${statusBadge}
                                </div>
                                <div class="mb-3 mt-2">
                                <div class="text-muted small">📄 Catatan</div>
                                    <p class="text-italic text-muted">
                                        ${data.catatan ?? 'Tidak ada catatan'}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <!-- CV Section -->
                        <div class="mt-3">
                            ${cvSection}
                        </div>
                        
                        <div class="mt-3">
                            ${SuratTerima}
                        </div>

                    </div>
                    `;

                })
                .catch(error => {
                    content.innerHTML = `
                <div class="text-danger">
                    Terjadi kesalahan saat memuat data
                </div>
            `;
                    console.error(error);
                });
        }
    </script>


@endsection
