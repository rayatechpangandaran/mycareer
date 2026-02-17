@extends('adminlte::page')

@section('title', 'Tambah Lowongan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Form Tambah Lowongan</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.lowongan.index') }}">Lowongan</a></li>
            <li class="breadcrumb-item active">Tambah Lowongan</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.lowongan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Perusahaan --}}
                <div class="form-group">
                    <label>Perusahaan *</label>
                    <select name="perusahaan_id" class="form-control @error('perusahaan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($perusahaan as $p)
                            <option value="{{ $p->usaha_id }}"
                                {{ old('perusahaan_id') == $p->usaha_id ? 'selected' : '' }}>
                                {{ $p->nama_bisnis_usaha }}
                            </option>
                        @endforeach
                    </select>
                    @error('perusahaan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Judul --}}
                <div class="form-group">
                    <label>Posisi Lowongan *</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul') }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="form-group">
                    <label>Kategori Pekerjaan *</label>
                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="IT & Digital" {{ old('kategori') == 'IT & Digital' ? 'selected' : '' }}>IT & Digital
                        </option>
                        <option value="Administrasi & Perkantoran"
                            {{ old('kategori') == 'Administrasi & Perkantoran' ? 'selected' : '' }}>Administrasi &
                            Perkantoran
                        </option>
                        <option value="Pendidikan & Training"
                            {{ old('kategori') == 'Pendidikan & Training' ? 'selected' : '' }}>
                            Pendidikan & Training</option>
                        <option value="Kesehatan & Medis" {{ old('kategori') == 'Kesehatan & Medis' ? 'selected' : '' }}>
                            Kesehatan & Medis</option>
                        <option value="Teknik & Produksi" {{ old('kategori') == 'Teknik & Produksi' ? 'selected' : '' }}>
                            Teknik &
                            Produksi</option>
                        <option value="Jasa & Pelayanan" {{ old('kategori') == 'Jasa & Pelayanan' ? 'selected' : '' }}>Jasa
                            &
                            Pelayanan</option>
                        <option value="Transportasi & Logistik"
                            {{ old('kategori') == 'Transportasi & Logistik' ? 'selected' : '' }}>Transportasi & Logistik
                        </option>
                        <option value="Creative & Media" {{ old('kategori') == 'Creative & Media' ? 'selected' : '' }}>
                            Creative &
                            Media</option>
                    </select>
                    @error('kategori')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tipe Pekerjaan --}}
                <div class="form-group">
                    <label>Tipe Pekerjaan *</label>
                    <select name="tipe_pekerjaan" class="form-control @error('tipe_pekerjaan') is-invalid @enderror"
                        required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Fulltime" {{ old('tipe_pekerjaan') == 'Fulltime' ? 'selected' : '' }}>Fulltime
                        </option>
                        <option value="Parttime" {{ old('tipe_pekerjaan') == 'Parttime' ? 'selected' : '' }}>Parttime
                        </option>
                        <option value="Magang" {{ old('tipe_pekerjaan') == 'Magang' ? 'selected' : '' }}>Magang</option>
                        <option value="Freelance" {{ old('tipe_pekerjaan') == 'Freelance' ? 'selected' : '' }}>Freelance
                        </option>
                        <option value="Kontrak" {{ old('tipe_pekerjaan') == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                    </select>
                    @error('tipe_pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pendidikan Terakhir --}}
                <div class="form-group">
                    <label>Pendidikan Terakhir *</label>
                    <select name="pendidikan_terakhir"
                        class="form-control @error('pendidikan_terakhir') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="SD/MI" {{ old('pendidikan_terakhir') == 'SD/MI' ? 'selected' : '' }}>SD/MI</option>
                        <option value="SMP/MTS" {{ old('pendidikan_terakhir') == 'SMP/MTS' ? 'selected' : '' }}>SMP/MTS
                        </option>
                        <option value="SMA/SMK/MA" {{ old('pendidikan_terakhir') == 'SMA/SMK/MA' ? 'selected' : '' }}>
                            SMA/SMK/MA
                        </option>
                        <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('pendidikan_terakhir') == 'S3' ? 'selected' : '' }}>S3</option>
                    </select>
                    @error('pendidikan_terakhir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jurusan (Opsional) --}}
                <div class="form-group d-none" id="jurusan-wrapper">
                    <label>Jurusan</label>
                    <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror"
                        value="{{ old('jurusan') }}" placeholder="Contoh: Teknik Informatika, Manajemen">
                    @error('jurusan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                {{-- Lokasi IndoRegion --}}
                <div class="form-group">
                    <label>Provinsi *</label>
                    <select id="province" class="form-control" required>
                        <option value="">-- Pilih Provinsi --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kabupaten/Kota *</label>
                    <select id="city" class="form-control" disabled required>
                        <option value="">-- Pilih Kota --</option>
                    </select>
                </div>

                <input type="hidden" name="lokasi" id="lokasi">

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kualifikasi --}}
                <div class="form-group">
                    <label>Kualifikasi *</label>
                    <textarea name="kualifikasi" rows="3" class="form-control @error('kualifikasi') is-invalid @enderror" required>{{ old('kualifikasi') }}</textarea>
                    @error('kualifikasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Gaji & Jumlah --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gaji Minimum</label>
                            <input type="text" id="gaji_min" class="form-control" placeholder="Rp 2.000.000">
                            <input type="hidden" name="gaji_min" id="gaji_min_value" value="{{ old('gaji_min') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gaji Maksimum</label>
                            <input type="text" id="gaji_max" class="form-control" placeholder="Rp 3.000.000">
                            <input type="hidden" name="gaji_max" id="gaji_max_value" value="{{ old('gaji_max') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah Lowongan *</label>
                            <input type="number" name="jumlah_lowongan" class="form-control" min="1"
                                value="{{ old('jumlah_lowongan') }}" required>
                        </div>
                    </div>
                </div>

                {{-- Deadline --}}
                <div class="form-group">
                    <label>Deadline *</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
                </div>

                {{-- Brosur --}}
                <div class="form-group">
                    <label>Brosur (Opsional)</label>
                    <input type="file" name="brosur" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Lowongan</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Format Rupiah
        function formatRupiah(angka) {
            return 'Rp ' + angka.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function bindRupiah(inputId, hiddenId) {
            const input = document.getElementById(inputId);
            const hidden = document.getElementById(hiddenId);
            input.addEventListener('input', function() {
                let angka = this.value.replace(/\D/g, '');
                hidden.value = angka;
                this.value = formatRupiah(angka);
            });
        }
        bindRupiah('gaji_min', 'gaji_min_value');
        bindRupiah('gaji_max', 'gaji_max_value');

        // IndoRegion
        const province = document.getElementById('province');
        const city = document.getElementById('city');
        const lokasiInput = document.getElementById('lokasi');

        fetch('/provinces').then(res => res.json()).then(data => {
            data.forEach(p => province.innerHTML += `<option value="${p.code}">${p.name}</option>`);
        });

        province.addEventListener('change', function() {
            city.innerHTML = '<option value="">-- Pilih Kota --</option>';
            city.disabled = false;
            fetch(`/cities/${this.value}`).then(res => res.json()).then(data => {
                if (!data.length) city.innerHTML += `<option value="">(Tidak ada data kota)</option>`;
                data.forEach(c => city.innerHTML += `<option value="${c.name}">${c.name}</option>`);
            });
        });

        city.addEventListener('change', function() {
            const provText = province.options[province.selectedIndex].text;
            lokasiInput.value = `${this.value}, ${provText}`;
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pendidikanSelect = document.querySelector('select[name="pendidikan_terakhir"]');
            const jurusanWrapper = document.getElementById('jurusan-wrapper');
            const jurusanInput = jurusanWrapper.querySelector('input');

            function toggleJurusan() {
                const val = pendidikanSelect.value;
                const allowed = ['D3', 'S1', 'S2', 'S3'];

                if (allowed.includes(val)) {
                    jurusanWrapper.classList.remove('d-none');
                } else {
                    jurusanWrapper.classList.add('d-none');
                    jurusanInput.value = '';
                }
            }

            pendidikanSelect.addEventListener('change', toggleJurusan);
            toggleJurusan(); // trigger saat reload (old input)
        });
    </script>

@stop
