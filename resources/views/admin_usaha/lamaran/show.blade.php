@extends('admin_usaha.layouts.app')

@section('title', 'Detail Pelamar')

@section('content')
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin_usaha.lamaran.index') }}">Data Pelamar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Pelamar</li>
        </ol>
    </nav>

    {{-- Main Card --}}
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    {{-- Judul Lowongan --}}
                    <h2 class="card-title mb-3">
                        <i class="mdi mdi-briefcase-variant-outline"></i> {{ $lowongan->judul }}
                    </h2>


                    {{-- Deskripsi --}}
                    <strong class="text-muted mb-3 d-block">{{ $lowongan->deskripsi ?? '-' }}</strong>

                    {{-- Info tambahan --}}
                    <div class="col-md-4 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-calendar-check-outline me-2 text-primary" style="font-size: 20px;"></i>
                            <div>
                                <div>{{ \Carbon\Carbon::parse($lowongan->created_at)->translatedFormat('l, d F Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 mb-4">
                        <div class="d-flex align-items-center">
                            <i class="mdi mdi-account-multiple-outline me-2 text-success" style="font-size: 20px;"></i>
                            <div>
                                <div><span class="badge bg-success">{{ $lowongan->lamaran->count() }} Pelamar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-start">
                            <i class="mdi mdi-school-outline me-2 text-warning" style="font-size: 20px;"></i>
                            <div>
                                <div class="text-muted small mb-1">Kualifikasi</div>
                                @if ($lowongan->kualifikasi)
                                    <ul class="mb-0">
                                        @foreach (explode("\n", $lowongan->kualifikasi) as $point)
                                            @if (trim($point) != '')
                                                <li>{{ $point }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <span>-</span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <hr>

                    {{-- Hitung jumlah pelamar per status --}}
                    @php
                        $totalAll = $lowongan->lamaran->count();
                        $totalDiterima = $lowongan->lamaran->where('status', 'Diterima')->count();
                        $totalTolak = $lowongan->lamaran->where('status', 'Ditolak')->count();
                    @endphp

                    {{-- Filter Dropdown --}}
                    <div class="d-flex justify-content-end mb-3">
                        <select id="statusFilter" class="form-select form-select-sm" style="width: 250px;">
                            <option value="all">Semua ({{ $totalAll }})</option>
                            <option value="Diterima">Diterima ({{ $totalDiterima }})</option>
                            <option value="Ditolak">Ditolak ({{ $totalTolak }})</option>
                        </select>
                    </div>

                    {{-- Tabel Pelamar --}}
                    <h4 class="card-title mb-3">Data Pelamar</h4>
                    <div class="table-responsive">
                        <table class="table table-striped" id="pelamarTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelamar</th>
                                    <th>Status</th>
                                    <th>CV</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowongan->lamaran as $lamaran)
                                    <tr data-status="{{ $lamaran->status }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $lamaran->pelamar->nama ?? '-' }}</td>
                                        <td>
                                            @if ($lamaran->status === 'Dikirim')
                                                <span class="badge bg-warning">Dikirim</span>
                                            @elseif ($lamaran->status === 'Diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @elseif ($lamaran->status === 'Ditolak')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($lamaran->cv)
                                                <a href="{{ asset('storage/' . $lamaran->cv) }}" target="_blank">Lihat
                                                    CV</a>
                                            @elseif($lamaran->pelamar->detail?->cv)
                                                <a href="{{ asset('storage/' . $lamaran->pelamar->detail->cv) }}"
                                                    target="_blank">Lihat CV Profil</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Tombol Detail --}}
                                            <button class="btn btn-sm btn-inverse-info btn-fw mb-1"
                                                data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasPelamar{{ $lamaran->id }}"
                                                title="Detail Pelamar">
                                                <i class="mdi mdi-account"></i>
                                            </button>

                                            {{-- Terima / Tolak --}}
                                            @if ($lamaran->status === 'Dikirim')
                                                <button type="button"
                                                    class="btn btn-sm btn-inverse-success btn-fw mb-1 update-status-btn"
                                                    data-id="{{ $lamaran->id }}" data-status="Diterima"
                                                    title="Terima Lamaran">
                                                    <i class="mdi mdi-check"></i>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-sm btn-inverse-danger btn-fw mb-1 update-status-btn"
                                                    data-id="{{ $lamaran->id }}" data-status="Ditolak"
                                                    title="Tolak Lamaran">
                                                    <i class="mdi mdi-close"></i>
                                                </button>
                                            @endif
                                            @php
                                                $pesan =
                                                    "Yth. {$lamaran->pelamar->nama},\n\n" .
                                                    "Kami dari {$namaUsaha->nama_bisnis_usaha} ingin menyampaikan bahwa lamaran Anda untuk posisi \"{$lowongan->judul}\" telah dinyatakan DITERIMA.\n\n" .
                                                    "Surat penerimaan resmi telah kami kirimkan melalui email yang terdaftar pada akun Anda di aplikasi CareerPangandaran.\n" .
                                                    "Silakan periksa kotak masuk (Inbox) atau folder Spam/Junk apabila email belum terlihat.\n\n" .
                                                    "Apabila dalam waktu 1x24 jam Anda belum menerima email tersebut, silakan menghubungi kami melalui nomor resmi perusahaan yang tersedia.\n\n" .
                                                    "Demikian informasi ini kami sampaikan.\n\n" .
                                                    "Hormat kami,\n{$namaUsaha->nama_bisnis_usaha}";

                                                $linkWa =
                                                    'https://wa.me/62' .
                                                    ltrim($lamaran->pelamar->detail->no_wa, '0') .
                                                    '?text=' .
                                                    urlencode($pesan);
                                            @endphp
                                            {{-- Tombol Email & WhatsApp jika sudah diterima --}}
                                            @if ($lamaran->status === 'Diterima')
                                                <button type="button"
                                                    class="btn btn-sm btn-inverse-primary btn-fw mb-1 ms-1 send-email-btn"
                                                    data-id="{{ $lamaran->id }}" title="Kirim Email Penerimaan">
                                                    <i class="mdi mdi-email"></i>
                                                </button>
                                                <a href="{{ $linkWa }}" target="_blank"
                                                    class="btn btn-sm btn-inverse-info btn-fw mb-1 ms-1"
                                                    title="Kirim WhatsApp Penerimaan">
                                                    <i class="mdi mdi-whatsapp"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- Offcanvas Detail Pelamar --}}
                                    <div class="offcanvas offcanvas-end" tabindex="-1"
                                        id="offcanvasPelamar{{ $lamaran->id }}" style="width:980px">
                                        <div class="offcanvas-header border-bottom">
                                            <h5 class="offcanvas-title">Detail Pelamar</h5>
                                            <button type="button" class="btn-close text-reset"
                                                data-bs-dismiss="offcanvas"></button>
                                        </div>
                                        <div class="offcanvas-body p-0">
                                            <div class="card shadow-sm border-0 h-100">
                                                <div class="row g-0 h-100">
                                                    <div
                                                        class="col-md-4 text-center p-3 border-end d-flex flex-column align-items-center">
                                                        <img src="{{ $lamaran->pelamar->avatar ?? asset('assets/img/avatar-default.jpg') }}"
                                                            class="img-fluid rounded-circle border mb-2" alt="Avatar"
                                                            style="max-width: 120px;">
                                                        <h5 class="mt-2">{{ $lamaran->pelamar->nama ?? '-' }}</h5>
                                                        <small
                                                            class="text-muted">{{ $lamaran->pelamar->email ?? '-' }}</small>
                                                    </div>
                                                    <div class="col-md-8 overflow-auto" style="max-height: 100vh;">
                                                        <div class="card-body">
                                                            <p class="mb-2"><strong>No. WA:</strong>
                                                                {{ $lamaran->pelamar->detail->no_wa ?? '-' }}</p>
                                                            <p class="mb-2"><strong>Alamat:</strong>
                                                                {{ $lamaran->pelamar->detail->alamat ?? '-' }}</p>
                                                            <p class="mb-2"><strong>Pendidikan Terakhir:</strong>
                                                                {{ $lamaran->pelamar->detail->pendidikan_terakhir ?? '-' }}
                                                            </p>
                                                            <p class="mb-2"><strong>Jurusan:</strong>
                                                                {{ $lamaran->pelamar->detail->jurusan ?? '-' }}</p>
                                                            <p class="mb-2"><strong>Keahlian:</strong>
                                                                @if ($lamaran->pelamar->detail->keahlian)
                                                                    @foreach (explode(',', $lamaran->pelamar->detail->keahlian) as $skill)
                                                                        <span
                                                                            class="badge bg-secondary">{{ $skill }}</span>
                                                                    @endforeach
                                                                @else
                                                                    -
                                                                @endif
                                                            </p>
                                                            <p class="mb-2"><strong>Status Lamaran:</strong>
                                                                {{ $lamaran->status }}</p>
                                                            <p class="mb-2"><strong>CV Terlampir:</strong></p>
                                                            @if ($lamaran->pelamar->detail->cv)
                                                                <div class="border rounded overflow-hidden"
                                                                    style="height: 400px;">
                                                                    <iframe
                                                                        src="{{ asset('storage/' . $lamaran->pelamar->detail->cv) }}"
                                                                        frameborder="0" style="width: 100%; height: 100%;"
                                                                        allowfullscreen></iframe>
                                                                </div>
                                                            @else
                                                                <p>-</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr class="no-data">
                                        <td colspan="6" class="text-center text-muted">
                                            <div class="text-muted"><i
                                                    class="mdi mdi-database-off fs-1 d-block mb-2"></i><strong>Tidak
                                                    ditemukan pelamar</strong>
                                                <div class="small mt-1">Belum ada pelamar diposisi ini</div>
                                            </div>
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
    <!-- Spinner Overlay -->
    <div id="loadingOverlay"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
           background:rgba(0,0,0,0.5); z-index:1050; justify-content:center; align-items:center;">
        <div class="spinner-border text-light" role="status" style="width:4rem; height:4rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>


    @push('scripts')
        <script>
            window.csrfToken = "{{ csrf_token() }}";
        </script>
        <script src="{{ asset('assets/skydash/js/detailPelamar.js') }}"></script>
    @endpush

@endsection
