@extends('layouts.public')

@section('title', 'Lamar Pekerjaan')

{{-- HERO --}}
@section('hero')
@section('hero_title', 'Lamar Cepat')
@section('hero_subtitle', 'Sesuaikan formulir untuk melakukan lamaran')
@endsection

@section('content')

<section class="container my-5">
    <div class="row g-4">

        {{-- ================= LEFT : APPLY FORM ================= --}}
        <div class="col-lg-8">
            <div class="apply-card shadow-sm rounded-4 p-4">

                {{-- HEADER LOWONGAN --}}
                <div class="apply-header d-flex align-items-center gap-3 mb-3">
                    <img src="{{ asset('storage/' . $lowongan->perusahaan->banner_logo_usaha) }}" class="company-logo"
                        alt="Logo">

                    <div>
                        <h4 class="fw-bold mb-1">{{ $lowongan->judul }}</h4>
                        <div class="text-muted">{{ $lowongan->perusahaan->nama_bisnis_usaha }}</div>
                        <small class="text-muted">
                            {{ $lowongan->perusahaan->kota }} • {{ $lowongan->tipe_pekerjaan }}
                        </small>
                    </div>
                </div>

                <hr>

                {{-- ================= FORM ================= --}}
                <form method="POST" action="{{ route('lamaran.store', $lowongan->id) }}" enctype="multipart/form-data"
                    class="mt-3">

                    @csrf

                    {{-- PILIH CV --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">CV yang digunakan</label>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="cv_option" value="profile"
                                id="cvProfile" checked>
                            <label class="form-check-label" for="cvProfile">
                                Gunakan CV dari Profil
                            </label>
                        </div>

                        <div class="form-check mt-1">
                            <input class="form-check-input" type="radio" name="cv_option" value="upload"
                                id="cvUpload">
                            <label class="form-check-label" for="cvUpload">
                                Upload CV Baru
                            </label>
                        </div>
                    </div>

                    {{-- PREVIEW CV PROFIL --}}
                    @if ($profile->cv)
                        <div id="profileCvPreview" class="alert alert-light border">
                            <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                            <a href="{{ Storage::url($profile->cv) }}" target="_blank">
                                Lihat CV Profil
                            </a>
                        </div>
                    @endif

                    {{-- UPLOAD CV --}}
                    <div id="uploadCvInput" class="mb-3 d-none">
                        <label class="form-label">Upload CV (PDF)</label>
                        <input type="file" name="cv_file" class="form-control" accept=".pdf">
                    </div>

                    {{-- SUBMIT --}}
                    <button type="submit" class="btn-apply-full">
                        <i class="bi bi-lightning-charge-fill me-1"></i>
                        Lamar Cepat Sekarang
                    </button>

                </form>
            </div>
        </div>

        {{-- ================= RIGHT : LOWONGAN TERBARU ================= --}}
        <div class="col-lg-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Lowongan Terbaru</h6>
                    <hr>

                    <ul class="list-unstyled job-mini-list">
                        @foreach ($lowonganAll as $low)
                            <li class="d-flex gap-2 mb-3">
                                <img src="{{ asset('storage/' . $low->perusahaan->banner_logo_usaha) }}" width="48"
                                    height="48" class="rounded">

                                <div>
                                    <a href="{{ route('lamaranDetail', $low->id) }}" class="fw-semibold d-block">
                                        {{ $low->judul }}
                                    </a>
                                    <small class="text-muted">
                                        {{ $low->perusahaan->nama_bisnis_usaha }}
                                        • {{ $low->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>

    </div>
</section>

{{-- ================= SCRIPT TOGGLE CV ================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name="cv_option"]').forEach(el => {
            el.addEventListener('change', function() {
                const upload = document.getElementById('uploadCvInput');
                const profile = document.getElementById('profileCvPreview');

                upload?.classList.toggle('d-none', this.value !== 'upload');
                profile?.classList.toggle('d-none', this.value !== 'profile');
            });
        });
    });
</script>

@endsection
