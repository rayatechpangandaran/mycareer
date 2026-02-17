    @extends('adminlte::page')

    @section('title', 'Tambah Mitra Usaha')

    @section('content_header')
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">
                    Tambah Mitra Usaha
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('mitra.index') }}">Mitra Usaha</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Mitra Usaha</li>
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

                <form id="businessForm" action="{{ route('mitra.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- STEP 1 -->
                    <div class="form-step active">
                        <h5 class="text-primary">Data Dasar Bisnis</h5>
                        <hr>
                        <label class="form-label">Nama Bisnis</label>
                        <input type="text" class="form-control mb-3" placeholder="Nama Perusahaanmu"
                            name="nama_bisnis_usaha" required>

                        <label class="form-label">Jenis Usaha</label>
                        <select class="form-control mb-3" name="jenis_usaha" required>
                            <option value="UMKM">UMKM</option>
                            <option value="CV">CV</option>
                            <option value="PT">PT</option>
                            <option value="Hotel">Hotel</option>
                        </select>

                        <label class="form-label">Nama Penanggung Jawab</label>
                        <input type="text" class="form-control mb-3" placeholder="Nama orang penanggung jawab"
                            name="nama_penanggung_jawab" required>

                        <label class="form-label">Email Bisnis</label>
                        <input type="email" class="form-control mb-3" name="email" placeholder="Masukan Email Aktif"
                            required>

                        <label class="form-label">Nomor WhatsApp Aktif</label>
                        <input type="number" class="form-control mb-3" name="no_wa"
                            placeholder="Pastikan Nomor terdaftar WA" required>

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
                        <textarea class="form-control mb-3" name="alamat_lengkap" placeholder="Alamat Kantor Lengkap" required></textarea>

                        <label class="form-label">Kota / Kabupaten</label>
                        <input type="text" class="form-control mb-3" name="kota" placeholder="Kota Tempat Usaha"
                            required>

                        <label class="form-label">Bidang Usaha</label>
                        <select class="form-control mb-3" name="bidang_usaha" required>
                            <option value="Kuliner">Kuliner</option>
                            <option value="Retail">Retail</option>
                            <option value="Jasa">Jasa</option>
                            <option value="Manufaktur">Manufaktur</option>
                        </select>

                        <label class="form-label">Jumlah Karyawan</label>
                        <select class="form-control mb-3" name="jml_karyawan" required>
                            <option value="1-5">1 – 5</option>
                            <option value="6-20">6 – 20</option>
                            <option value="> 20">> 20</option>
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
                        <input type="number" class="form-control mb-3" placeholder="kalau tidak ada tulis 0"
                            name="nib">

                        <label class="form-label">Upload Bukti Bisnis (Minimal 1)</label>
                        <br>
                        <input type="file" class="mb-2" name="bukti_usaha" required>

                        <small class="hint d-block mb-3">
                            * foto tempat usaha, banner, Google Maps, SKU<br>
                            * Bisa berupa foto,dokumen legalitas
                        </small>

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
                                Simpan
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
