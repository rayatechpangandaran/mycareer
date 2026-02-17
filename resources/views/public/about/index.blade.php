@extends('layouts.public')

@section('title', $about ? $about->title : 'Tentang Kami')
@section('hero')
@section('hero_title', 'Tentang Kami')
@section('hero_subtitle', 'Informasi Perusahaan Kami')
@endsection
@section('content')

<style>
    /* Hero Section - Updated to Orange Gradient */
    .about-hero {
        background: linear-gradient(135deg, #ff9a44 0%, #ff6a00 100%);
        padding: 80px 0;
        color: white;
        margin-bottom: 50px;
    }

    .about-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 15px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .about-hero p {
        font-size: 1.1rem;
        opacity: 0.95;
        max-width: 700px;
        margin: 0 auto;
    }

    /* About Card */
    .about-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease;
    }

    .about-card:hover {
        transform: translateY(-5px);
    }

    /* Vision Mission Cards - Updated to Orange accents */
    .vm-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: all 0.3s ease;
        border-left: 4px solid #ff9a44;
    }

    .vm-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(255, 106, 0, 0.15);
    }

    .vm-card.mission {
        border-left-color: #e65c00;
    }

    .vm-card h5 {
        font-weight: 700;
        color: #2d3436;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .vm-card h5 i {
        font-size: 1.5rem;
        color: #ff9a44;
    }

    .vm-card.mission h5 i {
        color: #e65c00;
    }

    .vm-card p {
        color: #636e72;
        line-height: 1.8;
        margin: 0;
    }

    /* Stats Section - Updated Icon background to Orange */
    .stats-section {
        background: #fffaf5;
        /* Very light orange tint */
        padding: 60px 0;
        margin: 50px 0;
    }

    .stat-card {
        text-align: center;
        padding: 20px;
    }

    .stat-card .stat-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #ff9a44 0%, #ff6a00 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: white;
        font-size: 1.8rem;
        box-shadow: 0 4px 10px rgba(255, 106, 0, 0.3);
    }

    .stat-card h3 {
        font-size: 2rem;
        font-weight: 800;
        color: #2d3436;
        margin-bottom: 5px;
    }

    /* Benefit List Icons */
    .benefit-item i {
        margin-right: 10px;
    }

    .text-orange-main {
        color: #ff6a00;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 100px 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #ffdcb8;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 2rem;
        }

        .about-hero {
            padding: 60px 0;
        }
    }
</style>

@if ($about)
    <!-- Hero Section -->
    <section class="about-hero text-center">
        <div class="container">
            <h1>{{ $about->title }}</h1>
            <p>{{ $about->description }}</p>
        </div>
    </section>

    <!-- Vision & Mission Section -->
    <section class="container my-5">
        <div class="row g-4">
            @if ($about->vision)
                <div class="col-lg-6">
                    <div class="vm-card vision">
                        <h5>
                            <i class="bi bi-eye-fill"></i>
                            Visi Kami
                        </h5>
                        <p>{{ $about->vision }}</p>
                    </div>
                </div>
            @endif

            @if ($about->mission)
                <div class="col-lg-6">
                    <div class="vm-card mission">
                        <h5>
                            <i class="bi bi-rocket-takeoff-fill"></i>
                            Misi Kami
                        </h5>
                        <p>{{ $about->mission }}</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-briefcase-fill"></i>
                        </div>
                        <h3>500+</h3>
                        <p>Lowongan Aktif</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3>1000+</h3>
                        <p>Pencari Kerja</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <h3>200+</h3>
                        <p>Perusahaan</p>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h3>300+</h3>
                        <p>Berhasil Diterima</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Content Section -->
    <section class="container my-5">
        <div class="card about-card">
            <div class="row g-0">
                <div class="col-md-5">
                    <img src="https://images.pexels.com/photos/3184436/pexels-photo-3184436.jpeg"
                        class="img-fluid h-100 object-fit-cover" alt="About Us">
                </div>
                <div class="col-md-7 p-4 p-md-5">
                    <h4 class="fw-bold mb-3">Mengapa Memilih Kami?</h4>
                    <div class="benefit-list">
                        <div class="benefit-item mb-3">
                            <i class="bi bi-patch-check-fill text-orange-main"></i>
                            <strong>Platform Terpercaya</strong> - Dipercaya oleh ratusan perusahaan lokal
                        </div>
                        <div class="benefit-item mb-3">
                            <i class="bi bi-lightning-charge-fill text-orange-main"></i>
                            <strong>Proses Cepat</strong> - Lamar pekerjaan dengan mudah dan cepat
                        </div>
                        <div class="benefit-item mb-3">
                            <i class="bi bi-shield-lock-fill text-orange-main"></i>
                            <strong>Data Aman</strong> - Informasi Anda terlindungi dengan baik
                        </div>
                        <div class="benefit-item mb-3">
                            <i class="bi bi-headset text-orange-main"></i>
                            <strong>Dukungan 24/7</strong> - Tim kami siap membantu kapan saja
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    <!-- Empty State -->
    <section class="container my-5">
        <div class="empty-state">
            <i class="bi bi-info-circle-fill"></i>
            <h5>Informasi Profil Perusahaan Belum Tersedia</h5>
            <p class="text-muted">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
        </div>
    </section>
@endif

@endsection
