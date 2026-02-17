@extends('layouts.public')

@section('title', 'Temukan Lowongan Kerja Pangandaran')

@section('hero')
@section('hero_title', 'Mitra Usaha')
@section('hero_subtitle', 'Daftar Mitra Usaha yang Bekerjasama')
@endsection
@section('content')
<section class="mitra-section py-5">
    <div class="container">
        <div class="row g-4">

            {{-- CARD MITRA --}}
            @foreach ($usaha as $mitra)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="partner-card" data-name="{{ $mitra->nama_bisnis_usaha }}" data-city="{{ $mitra->kota }}"
                        data-desc="{{ $mitra->deskripsi_perusahaan }}"
                        data-logo="{{ $mitra->banner_logo_usaha ? asset('storage/' . $mitra->banner_logo_usaha) : asset('assets/img/logoCareer.jpeg') }}">

                        <div class="partner-logo-wrap">
                            <img src="{{ $mitra->banner_logo_usaha ? asset('storage/' . $mitra->banner_logo_usaha) : asset('assets/img/logoCareer.jpeg') }}"
                                alt="{{ $mitra->nama_bisnis_usaha }}"
                                onerror="this.src='{{ asset('assets/img/logoCareer.jpeg') }}'">
                        </div>

                        <div class="partner-body">
                            <h5 class="partner-name">{{ $mitra->nama_bisnis_usaha }}</h5>
                            <span class="partner-city">{{ $mitra->kota }}</span>
                            <p class="partner-desc">
                                {{ Str::limit($mitra->deskripsi_perusahaan, 70) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
<div id="partnerModal" class="partner-modal">
    <div class="partner-modal-panel">
        <button class="partner-modal-close">&times;</button>

        <div class="partner-modal-header">
            <img id="partnerModalLogo" src="" alt="Logo">
            <h3 id="partnerModalName"></h3>
            <span id="partnerModalCity"></span>
        </div>

        <div class="partner-modal-body">
            <p id="partnerModalDesc"></p>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.partner-card').forEach(card => {
        card.addEventListener('click', function() {
            document.getElementById('partnerModalName').innerText = this.dataset.name;
            document.getElementById('partnerModalCity').innerText = this.dataset.city;
            document.getElementById('partnerModalDesc').innerText = this.dataset.desc;
            document.getElementById('partnerModalLogo').src = this.dataset.logo;

            document.getElementById('partnerModal').classList.add('active');
        });
    });

    document.querySelector('.partner-modal-close').addEventListener('click', closePartnerModal);

    document.getElementById('partnerModal').addEventListener('click', function(e) {
        if (e.target === this) closePartnerModal();
    });

    function closePartnerModal() {
        document.getElementById('partnerModal').classList.remove('active');
    }
</script>


@endsection
