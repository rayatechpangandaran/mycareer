@extends('layouts.public')

@section('title', 'Dashboard Pelamar - Loker Pangandaran')

@section('content')

    <!-- SECTION 1: WELCOME & PROFIL -->
    <section class="container mt-4 mt-md-5 mb-4">
        <div class="row g-3 g-md-4 align-items-center">
            <div class="col-12 col-md-8">
                <div class="d-flex align-items-center gap-3 gap-md-4">
                    <div class="position-relative">
                        @php
                            $avatarUrl =
                                Auth::user()->avatar ??
                                'https://ui-avatars.com/api/?name=' .
                                    urlencode(Auth::user()->nama ?? 'User') .
                                    '&background=ff6600&color=fff&bold=true';
                        @endphp
                        <img src="{{ $avatarUrl }}" class="profile-img rounded-4 border border-4 border-white shadow-sm"
                            alt="Avatar">
                        <span
                            class="position-absolute top-100 start-100 translate-middle p-2 bg-success border border-2 border-white rounded-circle shadow-sm">
                            <span class="visually-hidden">Online</span>
                        </span>
                    </div>
                    <div class="overflow-hidden">
                        <h3 class="fw-bold mb-1 text-dark text-truncate fs-4 fs-md-3">Halo,
                            {{ explode(' ', Auth::user()->nama)[0] }}! 👋</h3>
                        <p class="text-muted mb-0 small"><i class="bi bi-geo-alt-fill text-orange me-1"></i> Pangandaran,
                            Jawa Barat</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 text-md-end">
                <button class="btn btn-white shadow-sm rounded-pill px-4 fw-600 border w-100 w-md-auto">
                    <i class="bi bi-gear me-2"></i>Edit Profil
                </button>
            </div>
        </div>
    </section>

    <!-- SECTION 2: STATS OVERVIEW -->
    <section class="container mb-4 mb-md-5">
        <div class="row g-2 g-md-4">
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-2 p-md-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="stats-icon bg-soft-orange text-orange d-none d-sm-flex">
                            <i class="bi bi-send-fill"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 extra-small fw-bold text-uppercase">Lamaran</p>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4">
                                {{ Auth::user()->lamaran ? Auth::user()->lamaran->count() : 12 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-2 p-md-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="stats-icon bg-soft-blue text-primary d-none d-sm-flex">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 extra-small fw-bold text-uppercase">Dilihat</p>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4">8</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-2 p-md-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="stats-icon bg-soft-success text-success d-none d-sm-flex">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 extra-small fw-bold text-uppercase">Interview</p>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4">2</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-2 p-md-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-2 gap-md-3">
                        <div class="stats-icon bg-soft-purple text-purple d-none d-sm-flex">
                            <i class="bi bi-bookmark-star-fill"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-0 extra-small fw-bold text-uppercase">Disimpan</p>
                            <h4 class="fw-bold mb-0 fs-5 fs-md-4">5</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN CONTENT -->
    <section class="container mb-5">
        <div class="row g-4">
            <!-- LEFT: FILTER -->
            <aside class="col-12 col-lg-4 order-2 order-lg-1">
                <div class="card border-0 shadow-sm rounded-4 p-3 p-md-4 sticky-sidebar">
                    <h6 class="fw-bold mb-3 mb-md-4">Cari Peluang Baru</h6>

                    <div class="mb-3 mb-md-4">
                        <div class="input-group search-group rounded-3">
                            <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control bg-light border-0 py-2" placeholder="Cari posisi...">
                        </div>
                    </div>

                    <div class="filter-section mb-3 mb-md-4">
                        <label class="small fw-bold text-dark mb-2 d-block">Tipe Pekerjaan</label>
                        <div class="d-flex flex-wrap gap-2">
                            <input type="checkbox" class="btn-check" id="ft" checked>
                            <label class="btn btn-outline-light-custom btn-sm rounded-pill" for="ft">Full Time</label>

                            <input type="checkbox" class="btn-check" id="pt">
                            <label class="btn btn-outline-light-custom btn-sm rounded-pill" for="pt">Part Time</label>
                        </div>
                    </div>

                    <div class="filter-section mb-3 mb-md-4">
                        <label class="small fw-bold text-dark mb-2 d-block">Estimasi Gaji</label>
                        <select class="form-select border-0 bg-light rounded-3">
                            <option>Semua Kisaran</option>
                            <option>Rp 1jt - 3jt</option>
                        </select>
                    </div>

                    <button class="btn btn-orange w-100 rounded-3 fw-bold py-2 shadow-sm">
                        Terapkan
                    </button>
                </div>
            </aside>

            <!-- RIGHT: CONTENT -->
            <div class="col-12 col-lg-8 order-1 order-lg-2">
                <!-- TABS -->
                <div class="overflow-auto pb-2 mb-3">
                    <ul class="nav nav-pills flex-nowrap gap-2" id="pills-tab" role="tablist"
                        style="min-width: max-content;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4 fw-600" data-bs-toggle="pill"
                                data-bs-target="#jobs">Lowongan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-4 fw-600" data-bs-toggle="pill"
                                data-bs-target="#history">Riwayat</button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    <!-- JOB TAB -->
                    <div class="tab-pane fade show active" id="jobs">
                        <!-- JOB CARD -->
                        <div class="job-card card border-0 shadow-sm rounded-4 p-3 p-md-4 mb-3">
                            <div class="d-flex flex-column flex-sm-row gap-3 gap-md-4">
                                <div
                                    class="company-logo bg-light rounded-4 p-2 d-flex align-items-center justify-content-center mx-auto mx-sm-0">
                                    <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/5c/LogoMieGacoan.png/250px-LogoMieGacoan.png"
                                        width="45" alt="Logo">
                                </div>
                                <div class="flex-grow-1 text-center text-sm-start">
                                    <div
                                        class="d-flex flex-column flex-sm-row justify-content-between align-items-center align-items-sm-start mb-2">
                                        <div>
                                            <h5 class="fw-bold mb-1 fs-6 fs-md-5">Crew Store / Waiters</h5>
                                            <p class="text-orange fw-bold small mb-0">Mie Gacoan Pangandaran</p>
                                        </div>
                                        <span
                                            class="badge bg-soft-orange text-orange rounded-pill mt-2 mt-sm-0">Baru</span>
                                    </div>
                                    <div
                                        class="d-flex flex-wrap justify-content-center justify-content-sm-start gap-2 gap-md-3 mb-3">
                                        <span class="text-muted extra-small"><i class="bi bi-geo-alt me-1"></i>
                                            Parigi</span>
                                        <span class="text-muted extra-small"><i class="bi bi-cash-stack me-1"></i> Rp
                                            1.8jt - 2.5jt</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                        <small class="text-muted extra-small">2 jam lalu</small>
                                        <a href="#" class="btn btn-dark btn-sm rounded-pill px-4 fw-bold">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- HISTORY TAB -->
                    <div class="tab-pane fade" id="history">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-3 py-3 small text-muted">Perusahaan</th>
                                            <th class="py-3 small text-muted d-none d-md-table-cell">Tanggal</th>
                                            <th class="py-3 small text-muted">Status</th>
                                            <th class="pe-3 py-3 text-end small text-muted">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="ps-3 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <img src="https://upload.wikimedia.org/wikipedia/id/thumb/5/5c/LogoMieGacoan.png/250px-LogoMieGacoan.png"
                                                        width="24" class="d-none d-sm-block">
                                                    <div>
                                                        <p class="mb-0 fw-bold small">Admin</p>
                                                        <p class="mb-0 text-muted extra-small d-md-none">12 Feb</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="small d-none d-md-table-cell">12 Feb 2024</td>
                                            <td><span class="badge-status pending">Proses</span></td>
                                            <td class="pe-3 text-end">
                                                <button class="btn-icon"><i class="bi bi-chevron-right"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
            --brand-orange: #ff6600;
            --brand-orange-soft: rgba(255, 102, 0, 0.08);
            --bg-body: #f8f9fa;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: #2d3436;
            overflow-x: hidden;
        }

        .profile-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .profile-img {
                width: 100px;
                height: 100px;
            }
        }

        .text-orange {
            color: var(--brand-orange) !important;
        }

        .bg-soft-orange {
            background-color: var(--brand-orange-soft) !important;
        }

        .bg-soft-blue {
            background: #e7f1ff;
        }

        .bg-soft-success {
            background: #e1f6eb;
        }

        .bg-soft-purple {
            background: #f3ebff;
        }

        .text-purple {
            color: #6f42c1;
        }

        .extra-small {
            font-size: 0.75rem;
        }

        .fw-600 {
            font-weight: 600;
        }

        .stats-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sidebar Responsive Fix */
        @media (min-width: 992px) {
            .sticky-sidebar {
                position: sticky;
                top: 20px;
            }
        }

        .btn-outline-light-custom {
            border: 1px solid #dee2e6;
            background: white;
            color: #6c757d;
        }

        .btn-check:checked+.btn-outline-light-custom {
            background-color: var(--brand-orange);
            border-color: var(--brand-orange);
            color: white;
        }

        .btn-orange {
            background: var(--brand-orange);
            color: white;
            border: none;
        }

        .nav-pills .nav-link {
            color: #6c757d;
            background: white;
            border: 1px solid #dee2e6;
            white-space: nowrap;
        }

        .nav-pills .nav-link.active {
            background-color: #212529 !important;
            border-color: #212529;
        }

        .job-card {
            transition: transform 0.2s;
            border: 1px solid transparent !important;
        }

        .job-card:active {
            transform: scale(0.98);
        }

        .company-logo {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
        }

        /* Status Badges */
        .badge-status {
            padding: 4px 10px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-status.pending {
            background: #fff4e5;
            color: #b05d00;
        }

        .badge-status.success {
            background: #e6fffa;
            color: #047857;
        }

        .btn-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f8f9fa;
            border: none;
            color: #adb5bd;
        }

        /* Hide scrollbar for nav-pills overflow */
        .overflow-auto::-webkit-scrollbar {
            display: none;
        }

        .overflow-auto {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

@endsection
