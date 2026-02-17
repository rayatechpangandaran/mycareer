@extends('layouts.public')

@section('title', 'Kontak Kami')

@section('content')

@section('hero')
@section('hero_title', 'Kontak Kami')
@section('hero_subtitle', 'Hubungi Kami Untuk Info Lebih Lengkap')
@endsection

<section class="contact-main">
<div class="container px-2 py-4 small text-muted">
    <a href="{{ url('/') }}" class="text-decoration-none text-muted">
        Beranda
    </a>
    <span class="mx-1">›</span>
    <span class="fw-semibold text-dark">
        Kontak
    </span>
</div>
<div class="contact-grid">

    {{-- CONTACT FORM --}}
    <div class="contact-form-wrapper">

        <h2>Kirim Pesan</h2>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm" style="background-color: #d4edda; color: #155724;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
            @csrf

            <div class="form-group">
                <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" id="name" name="name"
                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap Anda" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" id="email" name="email"
                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                    placeholder="contoh@email.com" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">Subjek</label>
                <input type="text" id="subject" name="subject"
                    class="form-control @error('subject') is-invalid @enderror"
                    placeholder="Apa yang ingin Anda tanyakan?" value="{{ old('subject') }}">
            </div>

            <div class="form-group">
                <label for="message">Pesan <span class="text-danger">*</span></label>
                <textarea id="message" name="message" class="form-control @error('message') is-invalid @enderror" rows="5"
                    placeholder="Tuliskan pesan Anda di sini..." required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @auth

                <button type="submit" class="btn btn-orange w-100 justify-content-center">
                    <span>Kirim Pesan</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
                    </svg>
                </button>
            @else
                <a href="{{ route('login') }}" class="btn btn-orange w-100 justify-content-center">
                    <span>Login Terlebih Dahulu</span>
                </a>
            @endauth
        </form>
    </div>

    {{-- CONTACT INFO --}}
    <div class="contact-side">
        <div class="info-card">
            <h3>Informasi Kantor</h3>
            <div class="info-items">
                <div class="info-item">
                    <div class="icon">📍</div>
                    <div>
                        <strong>Lokasi</strong>
                        <p>Pangandaran, Jawa Barat</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="icon">📞</div>
                    <div>
                        <strong>Telepon / WA</strong>
                        <p>+62 821 3075 7061</p>
                    </div>
                </div>
                <div class="info-item">
                    <div class="icon">✉</div>
                    <div>
                        <strong>Email</strong>
                        <p>careerpangandaran@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="social-card">
            <h3>Ikuti Kami</h3>
            <div class="social-links">
                <a href="#" class="social-link facebook" title="Facebook">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </a>
                <a href="#" class="social-link linkedin" title="LinkedIn">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                    </svg>
                </a>
                <a href="#" class="social-link instagram" title="Instagram">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

</section>

{{-- MAP SECTION --}}

<section class="map-section">
<h2>Lokasi Kami</h2>
<div class="map-container-inner">
    <div class="map-badge">
        <div class="dot"></div>
        <span style="font-weight: 600; font-size: 0.9rem; color: #2d3436;">Pangandaran Career Center</span>
    </div>
    <div class="map-wrapper">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56211042117!2d108.54894364453125!3d-7.684923899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65913ee76b2813%3A0xf843e4fa9c414c4e!2sPangandaran%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>
</div>
</section>

@endsection
