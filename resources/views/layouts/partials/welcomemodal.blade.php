<div class="floating-wrapper">
    <button class="floating-btn faq-btn" data-bs-toggle="modal" data-bs-target="#faqModal">
        <i class="bi bi-question-circle"></i>
    </button>

    <button class="back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </button>
</div>

{{-- FAQ MODAL --}}
<div class="modal fade" id="faqModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">❓ Pertanyaan Umum (FAQ)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="accordion accordion-flush" id="faqAccordion">
                    @foreach ($faqs as $i => $faq)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#faq{{ $i }}">
                                    {{ $faq->question }}
                                </button>
                            </h2>
                            <div id="faq{{ $i }}" class="accordion-collapse collapse">
                                <div class="accordion-body bg-light shadow-lg p-3 rounded">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

{{-- WELCOME MODAL --}}
<div class="modal fade" id="welcomeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg border-0">
            <div class="modal-body text-center p-4">
                <span class="badge bg-warning text-dark mb-2">Selamat Datang</span>

                <h5 class="fw-bold mt-2">Selamat Datang di Portal Lowongan Kerja</h5>

                <p class="text-muted mt-2 mb-4">
                    Temukan lowongan terbaik atau pasang lowongan untuk UMKM, CV, PT, dan Hotel dengan mudah & gratis.
                </p>

                <div class="d-flex gap-2 justify-content-center flex-wrap">
                    <button class="btn btn-outline-secondary px-4" id="dontShowAgain">
                        Jangan tampilkan lagi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JS untuk mengingat modal welcome --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
        const dontShowBtn = document.getElementById('dontShowAgain');

        // Cek sessionStorage
        if (!sessionStorage.getItem('welcomeShown')) {
            welcomeModal.show();
        }

        dontShowBtn.addEventListener('click', function() {
            sessionStorage.setItem('welcomeShown', 'true');
            welcomeModal.hide();
        });
    });
</script>
