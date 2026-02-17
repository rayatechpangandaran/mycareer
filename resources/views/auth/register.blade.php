<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi Bisnis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/logoCareer.jpeg') }}" type="image/jpeg">

</head>

<body>
    <div class="form-wrapper">

        <h4 class="fw-bold mb-1 text-center">Daftar Akun Bisnis</h4>
        <p class="text-muted text-center mb-4">
            Lengkapi data untuk memverifikasi usaha Anda
        </p>

        <!-- STEP INDICATOR -->
        <div class="step-indicator mb-4">
            <span class="active"></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <form id="businessForm" action="{{ route('register.usaha') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- STEP 1 -->
            <div class="form-step active">
                <h6 class="fw-bold mb-3">Data Dasar Bisnis</h6>

                <label class="form-label">Nama Bisnis</label>
                <input type="text" class="form-control mb-3" placeholder="Nama Perusahaanmu" name="nama_bisnis_usaha"
                    required>

                <label class="form-label">Jenis Usaha</label>
                <select class="form-select mb-3" name="jenis_usaha" required>
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
                <input type="number" class="form-control mb-3" name="no_wa" placeholder="Pastikan Nomor terdaftar WA"
                    required>

                <div class="text-end">
                    <button type="button" class="btn btn-orange nextBtn">
                        Lanjut <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="form-step">
                <h6 class="fw-bold mb-3">Informasi Operasional</h6>

                <label class="form-label fw-semibold">Alamat Usaha</label>
                <div class="row g-2 mb-3">

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

                    <div class="col-md-6">
                        <select id="districtSelect" class="form-select" required disabled>
                            <option value="">-- Pilih Kecamatan --</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <select id="villageSelect" class="form-select" required disabled>
                            <option value="">-- Pilih Desa --</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <input type="text" id="alamatDetail" class="form-control"
                            placeholder="Detail Jalan, RT/RW, No Rumah" required>
                    </div>
                </div>

                <input type="hidden" name="alamat_lengkap" id="alamatLengkap">

                <label class="form-label">Bidang Usaha</label>
                <select class="form-select mb-3" name="bidang_usaha" required>
                    <option value="Kuliner">Kuliner</option>
                    <option value="Retail">Retail</option>
                    <option value="Jasa">Jasa</option>
                    <option value="Manufaktur">Manufaktur</option>
                </select>

                <label class="form-label">Jumlah Karyawan</label>
                <select class="form-select mb-3" name="jml_karyawan" required>
                    <option value="1-5">1 – 5</option>
                    <option value="6-20">6 – 20</option>
                    <option value="> 20">> 20</option>
                </select>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-light prevBtn">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-orange nextBtn">
                        Lanjut <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="form-step">
                <h6 class="fw-bold mb-3">Dokumen & Bukti Bisnis</h6>

                <label class="form-label">NIB (Opsional)</label>
                <input type="number" class="form-control mb-3" placeholder="kalau tidak ada tulis 0"
                    name="nib">
                <label class="form-label">Logo / Banner Bisnis</label>
                <input type="file" class="form-control mb-3" name="banner_logo_usaha" accept="image/*">

                <small class="text-muted d-block mb-3">
                    * Format JPG/PNG, maksimal 4MB
                </small>
                <label class="form-label">Upload Bukti Bisnis (Minimal 1)</label>
                <input type="file" class="form-control mb-2" name="bukti_usaha" required>

                <small class="hint d-block mb-3">
                    * foto tempat usaha, banner, Google Maps, SKU<br>
                    * Bisa berupa foto,dokumen legalitas
                </small>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-light prevBtn">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                    <button type="button" class="btn btn-orange nextBtn">
                        Lanjut <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="form-step">
                <h6 class="fw-bold mb-3">Komitmen & Verifikasi</h6>

                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" id="agree1" required>
                    <label class="form-check-label" for="agree1">
                        Data yang saya isi benar dan dapat dipertanggungjawabkan
                    </label>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="agree2">
                    <label class="form-check-label" for="agree2">
                        Tidak memungut biaya dari pelamar kerja
                    </label>
                </div>

                <small class="hint d-block mb-3">
                    Akun bisnis akan diverifikasi sebelum dapat memasang lowongan
                </small>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-light prevBtn">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" id="submitBtn" class="btn btn-orange" disabled>
                        Ajukan Akun Bisnis
                    </button>
                </div>
            </div>

        </form>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/js/register.js') }}"></script>
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'Perbaiki',
            confirmButtonColor: '#dc3545'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc3545'
        });
    </script>
@endif

@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#28a745'
        });
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const province = document.getElementById('provinceSelect');
        const city = document.getElementById('citySelect');
        const district = document.getElementById('districtSelect');
        const village = document.getElementById('villageSelect');
        const detail = document.getElementById('alamatDetail');
        const alamatFinal = document.getElementById('alamatLengkap');

        function resetSelect(select, placeholder) {
            select.innerHTML = `<option value="">${placeholder}</option>`;
            select.disabled = true;
        }

        function getSelectedText(select) {
            if (!select.value) return '';
            const text = select.options[select.selectedIndex]?.text || '';
            return text.includes('Pilih') ? '' : text;
        }

        function setAlamat() {
            const alamatBaru = [
                detail.value.trim(),
                getSelectedText(village),
                getSelectedText(district),
                getSelectedText(city),
                getSelectedText(province)
            ].filter(v => v !== '').join(', ');

            alamatFinal.value = alamatBaru;
        }

        /* =======================
           LOAD PROVINCE
        ======================= */
        fetch('/provinces')
            .then(res => res.json())
            .then(data => {
                data.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.code;
                    option.textContent = p.name;
                    province.appendChild(option);
                });
            });

        /* =======================
           PROVINCE CHANGE
        ======================= */
        province.addEventListener('change', function() {

            resetSelect(city, '-- Pilih Kota/Kabupaten --');
            resetSelect(district, '-- Pilih Kecamatan --');
            resetSelect(village, '-- Pilih Desa --');

            if (!this.value) return;

            fetch(`/cities/${this.value}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(c => {
                        const option = document.createElement('option');
                        option.value = c.code;
                        option.textContent = c.name;
                        city.appendChild(option);
                    });
                    city.disabled = false;
                });

            setAlamat();
        });

        /* =======================
           CITY CHANGE
        ======================= */
        city.addEventListener('change', function() {

            resetSelect(district, '-- Pilih Kecamatan --');
            resetSelect(village, '-- Pilih Desa --');

            if (!this.value) return;

            fetch(`/districts/${this.value}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(d => {
                        const option = document.createElement('option');
                        option.value = d.code;
                        option.textContent = d.name;
                        district.appendChild(option);
                    });
                    district.disabled = false;
                });

            setAlamat();
        });

        /* =======================
           DISTRICT CHANGE
        ======================= */
        district.addEventListener('change', function() {

            resetSelect(village, '-- Pilih Desa --');

            if (!this.value) return;

            fetch(`/villages/${this.value}`)
                .then(res => res.json())
                .then(data => {
                    data.forEach(v => {
                        const option = document.createElement('option');
                        option.value = v.code;
                        option.textContent = v.name;
                        village.appendChild(option);
                    });
                    village.disabled = false;
                });

            setAlamat();
        });

        /* =======================
           UPDATE ALAMAT OTOMATIS
        ======================= */
        [province, city, district, village, detail].forEach(el =>
            el.addEventListener('change', setAlamat)
        );

        // pastikan sebelum submit alamat terisi
        const form = document.getElementById('businessForm');
        form.addEventListener('submit', function() {
            setAlamat();
        });

    });
</script>

</html>
