    @extends('adminlte::page')

    @section('title', 'Ubah Mitra Usaha')

    @section('content_header')
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    Ubah Mitra Usaha
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mitra.index') }}">Mitra Usaha</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ubah Mitra Usaha</li>
                </ol>
            </div>
        </div>
    @stop
    @section('css')
        <style>
            .form-step {
                display: none;
            }

            .form-step.active {
                display: block;
            }

            .step-indicator {
                display: flex;
                justify-content: center;
                gap: 10px;
            }

            .step-indicator span {
                width: 25px;
                height: 6px;
                background: #ddd;
                border-radius: 10px;
            }

            .step-indicator span.active {
                background: #2a2826;
            }
        </style>
    @endsection

    @section('content')
        <div class="card">
            <div class="card-body">
                <p class="text-muted text-center mb-4">
                    Lengkapi data untuk Mitra Usaha Anda
                </p>

                <!-- STEP INDICATOR -->
                <div class="step-indicator mb-4">
                    <span class="active"></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                <form id="businessForm" action="{{ route('mitra.update', $usaha->usaha_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- STEP 1 -->
                    <div class="form-step active">
                        <h5 class="text-primary">Data Dasar Bisnis</h5>
                        <hr>
                        <label class="form-label">Nama Bisnis</label>
                        <input type="text" class="form-control mb-3" placeholder="Nama Perusahaanmu"
                            name="nama_bisnis_usaha" value="{{ old('nama_bisnis_usaha', $usaha->nama_bisnis_usaha) }}"
                            required>

                        <label class="form-label">Jenis Usaha</label>
                        <select class="form-control mb-3" name="jenis_usaha" required>
                            <option value="UMKM"
                                {{ old('jenis_usaha', $usaha->jenis_usaha) == 'UMKM' ? 'selected' : '' }}>UMKM</option>
                            <option value="CV" {{ old('jenis_usaha', $usaha->jenis_usaha) == 'CV' ? 'selected' : '' }}>
                                CV</option>
                            <option value="PT" {{ old('jenis_usaha', $usaha->jenis_usaha) == 'PT' ? 'selected' : '' }}>
                                PT</option>
                            <option value="Hotel"
                                {{ old('jenis_usaha', $usaha->jenis_usaha) == 'Hotel' ? 'selected' : '' }}>Hotel</option>
                        </select>

                        <label class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" class="form-control mb-3" placeholder="Nama orang penanggung jawab"
                            name="nama_penanggung_jawab"
                            value="{{ old('nama_penanggung_jawab', $usaha->nama_penanggung_jawab) }}" required>

                        <label class="form-label">Email Bisnis</label>
                        <input type="email" value="{{ old('email', $usaha->email) }}" class="form-control mb-3"
                            name="email" placeholder="Masukan Email Aktif" required>

                        <label class="form-label">Nomor WhatsApp Aktif</label>
                        <input type="number" class="form-control mb-3" name="no_wa"
                            placeholder="Pastikan Nomor terdaftar WA" value="{{ old('no_wa', $usaha->no_wa) }}" required>

                        <div class="text-end">
                            <button type="button" class="btn btn-primary nextBtn">
                                Lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 2 -->
                    <div class="form-step">
                        <h5 class="text-primary">Informasi Operasional</h5>
                        <hr>
                        <label class="form-label">Alamat Lengkap Usaha</label>
                        <textarea class="form-control mb-3" name="alamat_lengkap" placeholder="Alamat Kantor Lengkap" required>{{ old('alamat_lengkap', $usaha->alamat_lengkap) }}
                        </textarea>

                        <label class="form-label">Kota / Kabupaten</label>
                        <input type="text" class="form-control mb-3" value="{{ old('kota', $usaha->kota) }}"
                            name="kota" placeholder="Kota Tempat Usaha" required>

                        <label class="form-label">Bidang Usaha</label>
                        <select class="form-control mb-3" name="bidang_usaha" required>
                            <option value="Kuliner"
                                {{ old('bidang_usaha', $usaha->bidang_usaha) == 'Kuliner' ? 'selected' : '' }}>Kuliner
                            </option>
                            <option value="Retail"
                                {{ old('bidang_usaha', $usaha->bidang_usaha) == 'Retail' ? 'selected' : '' }}>Retail
                            </option>
                            <option value="Jasa"
                                {{ old('bidang_usaha', $usaha->bidang_usaha) == 'Jasa' ? 'selected' : '' }}>Jasa</option>
                            <option value="Manufaktur"
                                {{ old('bidang_usaha', $usaha->bidang_usaha) == 'Manufaktur' ? 'selected' : '' }}>
                                Manufaktur</option>
                        </select>

                        <label class="form-label">Jumlah Karyawan</label>
                        <select class="form-control mb-3" name="jml_karyawan" required>
                            <option value="1-5"
                                {{ old('jml_karyawan', $usaha->jml_karyawan) == '1-5' ? 'selected' : '' }}>1 – 5</option>
                            <option value="6-20"
                                {{ old('jml_karyawan', $usaha->jml_karyawan) == '6-20' ? 'selected' : '' }}>6 – 20</option>
                            <option value="> 20"
                                {{ old('jml_karyawan', $usaha->jml_karyawan) == '> 20' ? 'selected' : '' }}>> 20</option>
                        </select>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light prevBtn">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary nextBtn">
                                Lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 3 -->
                    <div class="form-step">
                        <h5 class="text-primary">Dokumen & Bukti Bisnis</h5>
                        <hr>
                        <label class="form-label">NIB (Opsional)</label>
                        <input type="number" value="{{ old('nib', $usaha->nib) }}" class="form-control mb-3"
                            placeholder="kalau tidak ada tulis 0" name="nib">

                        <label class="form-label">Upload Bukti Bisnis (Minimal 1)</label>
                        <br>
                        <input type="file" class="mb-2" name="bukti_usaha">

                        <small class="hint d-block mb-3">
                            * foto tempat usaha, banner, Google Maps, SKU<br>
                            * Bisa berupa foto,dokumen legalitas
                        </small>
                        @if ($usaha->bukti_usaha)
                            @php
                                $ext = pathinfo($usaha->bukti_usaha, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array($ext, ['jpg', 'jpeg', 'png']))
                                <img src="{{ asset('storage/' . $usaha->bukti_usaha) }}" alt="Thumbnail"
                                    class="img-thumbnail mt-2" style="max-height: 150px;">
                            @else
                                <a href="{{ asset('storage/' . $usaha->bukti_usaha) }}" target="_blank">
                                    Lihat dokumen lama
                                </a>
                            @endif
                        @endif

                        <br>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light prevBtn">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </button>
                            <button type="button" class="btn btn-primary nextBtn">
                                Lanjut <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>

                    <!-- STEP 4 -->
                    <div class="form-step">
                        <h5 class="text-primary">Komitmen & Verifikasi</h5>
                        <hr>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="agree1" required>
                            <label class="form-check-label" for="agree1">
                                Data yang saya isi benar dan dapat dipertanggung jawabkan
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-light prevBtn">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </button>
                            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>
                                Perbarui
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <br>
    @endsection
    @section('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const steps = document.querySelectorAll('.form-step');
                const indicators = document.querySelectorAll('.step-indicator span');
                const nextBtns = document.querySelectorAll('.nextBtn');
                const prevBtns = document.querySelectorAll('.prevBtn');
                const submitBtn = document.getElementById('submitBtn');
                const agree1 = document.getElementById('agree1');

                let currentStep = 0;

                function showStep(step) {
                    steps.forEach((s, i) => {
                        s.classList.toggle('active', i === step);
                        indicators[i].classList.toggle('active', i <= step);
                    });
                }

                nextBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (currentStep < steps.length - 1) {
                            currentStep++;
                            showStep(currentStep);
                        }
                    });
                });

                prevBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (currentStep > 0) {
                            currentStep--;
                            showStep(currentStep);
                        }
                    });
                });

                agree1.addEventListener('change', function() {
                    submitBtn.disabled = !this.checked;
                });

                showStep(currentStep);
            });
        </script>
    @endsection
