@extends('adminlte::page')

@section('title', 'Edit Lowongan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Form Edit Lowongan</h1>
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('superadmin.lowongan.index') }}">Lowongan</a></li>
            <li class="breadcrumb-item active">Edit Lowongan</li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('superadmin.lowongan.update', $lowongan->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Perusahaan --}}
                <div class="form-group">
                    <label>Perusahaan *</label>
                    <select name="perusahaan_id" class="form-control @error('perusahaan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($perusahaan as $p)
                            <option value="{{ $p->usaha_id }}"
                                {{ old('perusahaan_id', $lowongan->perusahaan_id) == $p->usaha_id ? 'selected' : '' }}>
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
                    <label>Judul Lowongan *</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $lowongan->judul) }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div class="form-group">
                    <label>Kategori Pekerjaan *</label>
                    <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        @php
                            $kategoriList = [
                                'IT & Digital',
                                'Administrasi & Perkantoran',
                                'Pendidikan & Training',
                                'Kesehatan & Medis',
                                'Teknik & Produksi',
                                'Jasa & Pelayanan',
                                'Transportasi & Logistik',
                                'Creative & Media',
                            ];
                        @endphp
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori }}"
                                {{ old('kategori', $lowongan->kategori) == $kategori ? 'selected' : '' }}>
                                {{ $kategori }}
                            </option>
                        @endforeach
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
                        @foreach (['Fulltime', 'Parttime', 'Magang', 'Freelance', 'Kontrak'] as $tipe)
                            <option value="{{ $tipe }}"
                                {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == $tipe ? 'selected' : '' }}>
                                {{ $tipe }}
                            </option>
                        @endforeach
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
                        @foreach (['SD/MI', 'SMP/MTS', 'SMA/SMK/MA', 'D3', 'S1', 'S2', 'S3'] as $pendidikan)
                            <option value="{{ $pendidikan }}"
                                {{ old('pendidikan_terakhir', $lowongan->pendidikan_terakhir) == $pendidikan ? 'selected' : '' }}>
                                {{ $pendidikan }}
                            </option>
                        @endforeach
                    </select>
                    @error('pendidikan_terakhir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jurusan --}}
                <div class="form-group" id="jurusan-wrapper" style="display: none;">
                    <label>Jurusan (Opsional)</label>
                    <input type="text" name="jurusan" id="jurusan" class="form-control"
                        placeholder="Contoh: Teknik Informatika, Manajemen"
                        value="{{ old('jurusan', $lowongan->jurusan) }}">
                    <small class="text-muted">
                        Kosongkan jika tidak mensyaratkan jurusan tertentu
                    </small>
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
                <input type="hidden" name="lokasi" id="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}">

                {{-- Deskripsi --}}
                <div class="form-group">
                    <label>Deskripsi *</label>
                    <textarea name="deskripsi" rows="5" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Kualifikasi --}}
                <div class="form-group">
                    <label>Kualifikasi *</label>
                    <textarea name="kualifikasi" rows="3" class="form-control @error('kualifikasi') is-invalid @enderror" required>{{ old('kualifikasi', $lowongan->kualifikasi) }}</textarea>
                    @error('kualifikasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Gaji & Jumlah --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gaji Minimum</label>
                            <input type="text" id="gaji_min" class="form-control" placeholder="Rp 2.000.000"
                                value="{{ old('gaji_min', number_format($lowongan->gaji_min, 0, '.', '.')) }}">
                            <input type="hidden" name="gaji_min" id="gaji_min_value"
                                value="{{ old('gaji_min', $lowongan->gaji_min) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Gaji Maksimum</label>
                            <input type="text" id="gaji_max" class="form-control" placeholder="Rp 3.000.000"
                                value="{{ old('gaji_max', number_format($lowongan->gaji_max, 0, '.', '.')) }}">
                            <input type="hidden" name="gaji_max" id="gaji_max_value"
                                value="{{ old('gaji_max', $lowongan->gaji_max) }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah Lowongan *</label>
                            <input type="number" name="jumlah_lowongan" class="form-control" min="1"
                                value="{{ old('jumlah_lowongan', $lowongan->jumlah_lowongan) }}" required>
                        </div>
                    </div>
                </div>

                {{-- Deadline --}}
                <div class="form-group">
                    <label>Deadline *</label>
                    <input type="date" name="deadline" class="form-control"
                        value="{{ old('deadline', $lowongan->deadline) }}" required>
                </div>

                {{-- Brosur --}}
                <div class="form-group">
                    <label>Brosur (Opsional)</label>
                    <input type="file" name="brosur" class="form-control">
                    @if ($lowongan->brosur)
                        <small>File saat ini: <a href="{{ asset('uploads/brosur/' . $lowongan->brosur) }}"
                                target="_blank">{{ $lowongan->brosur }}</a></small>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Lowongan</button>
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

        // Load provinsi
        fetch('/provinces').then(res => res.json()).then(data => {
            data.forEach(p => province.innerHTML += `<option value="${p.code}">${p.name}</option>`);

            // Set provinsi dan kota lama
            const oldLokasi = "{{ old('lokasi', $lowongan->lokasi) }}";
            if (oldLokasi) {
                const [kota, prov] = oldLokasi.split(',').map(s => s.trim());
                const provOption = Array.from(province.options).find(o => o.text === prov);
                if (provOption) {
                    provOption.selected = true;
                    fetch(`/cities/${provOption.value}`).then(res => res.json()).then(cities => {
                        city.innerHTML = '<option value="">-- Pilih Kota --</option>';
                        cities.forEach(c => city.innerHTML +=
                            `<option value="${c.name}">${c.name}</option>`);
                        const kotaOption = Array.from(city.options).find(o => o.value === kota);
                        if (kotaOption) kotaOption.selected = true;
                        city.disabled = false;
                    });
                }
            }
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
        const pendidikanSelect = document.querySelector('select[name="pendidikan_terakhir"]');
        const jurusanWrapper = document.getElementById('jurusan-wrapper');

        function toggleJurusan() {
            const pendidikan = pendidikanSelect.value;
            const pendidikanButuhJurusan = ['D3', 'S1', 'S2', 'S3'];

            if (pendidikanButuhJurusan.includes(pendidikan)) {
                jurusanWrapper.style.display = 'block';
            } else {
                jurusanWrapper.style.display = 'none';
                document.getElementById('jurusan').value = '';
            }
        }

        pendidikanSelect.addEventListener('change', toggleJurusan);

        // trigger saat halaman edit dibuka
        toggleJurusan();
    </script>

@stop
