
const backToTop = document.getElementById("backToTop");

window.addEventListener("scroll", () => {
    if (window.scrollY > 300) {
        backToTop.classList.add("show");
    } else {
        backToTop.classList.remove("show");
    }
});

backToTop.addEventListener("click", () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});

document.addEventListener("DOMContentLoaded", function () {

    
    if (!sessionStorage.getItem("welcomeModalShown")) {
        const welcomeModal = new bootstrap.Modal(
            document.getElementById("welcomeModal")
        );
        welcomeModal.show();
    }

    
    document.getElementById("dontShowAgain")
        .addEventListener("click", function () {

            sessionStorage.setItem("welcomeModalShown", "true");

            const modalEl = document.getElementById("welcomeModal");
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
        });
});

   /**
     * Contact Page JavaScript
     * Handles FAQ accordion interactions
     */

    document.addEventListener('DOMContentLoaded', function() {
        // FAQ Accordion Functionality
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', function() {
                // Close other open items (optional - remove if you want multiple open at once)
                faqItems.forEach(otherItem => {
                    if (otherItem !== item && otherItem.classList.contains('active')) {
                        otherItem.classList.remove('active');
                    }
                });

                // Toggle current item
                item.classList.toggle('active');
            });
        });

        // Form validation and submission feedback
        const contactForm = document.querySelector('.contact-form');

        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                // Add loading state to button
                const submitBtn = this.querySelector('.btn-primary');
                const originalText = submitBtn.innerHTML;

                submitBtn.innerHTML = '<span>Sending...</span>';
                submitBtn.disabled = true;

                // You can add additional validation here if needed

                // Note: Form will submit normally, this just provides visual feedback
                // If you want to prevent default and use AJAX, uncomment below:
                /*
                e.preventDefault();
                
                // Example AJAX submission
                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Handle success
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    
                    // Show success message
                    alert('Message sent successfully!');
                    this.reset();
                })
                .catch(error => {
                    // Handle error
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    alert('An error occurred. Please try again.');
                });
                */
            });
        }

        // Smooth scroll for anchor links (if any)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const target = document.querySelector(this.getAttribute('href'));

                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Form input animation effects
        const formInputs = document.querySelectorAll('.form-control');

        formInputs.forEach(input => {
            // Add floating label effect if needed
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });

            // Check if input has value on load
            if (input.value !== '') {
                input.parentElement.classList.add('focused');
            }
        });
    });

    // Optional: Add animation on scroll for sections
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe sections for scroll animation
    document.querySelectorAll('.contact-form-wrapper, .info-card, .social-card, .faq-item').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });


        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('#searchInput');
            const locationInput = $('#locationInput'); // Select2
            const kategoriSelect = document.querySelector('#kategoriFilter');
            const pendidikanSelect = document.querySelector('#pendidikanFilter');
            const gajiSelect = document.querySelector('#gajiFilter');
            const tipeSelect = document.querySelector('#tipeFilter');
            const jobCards = Array.from(document.querySelectorAll('.job-card'));
            const btnSearch = document.querySelector('#btnSearch');
            const jobListContainer = document.querySelector('#jobList');

            const provinsi = [
                "Aceh", "Sumatera Utara", "Sumatera Barat", "Riau", "Jambi", "Sumatera Selatan", "Bengkulu",
                "Lampung", "Kepulauan Bangka Belitung", "Kepulauan Riau", "DKI Jakarta", "Jawa Barat",
                "Jawa Tengah", "DI Yogyakarta", "Jawa Timur", "Banten", "Bali", "Nusa Tenggara Barat",
                "Nusa Tenggara Timur", "Kalimantan Barat", "Kalimantan Tengah", "Kalimantan Selatan",
                "Kalimantan Timur", "Kalimantan Utara", "Sulawesi Utara", "Sulawesi Tengah",
                "Sulawesi Selatan", "Sulawesi Tenggara", "Gorontalo", "Sulawesi Barat", "Maluku",
                "Maluku Utara", "Papua Barat", "Papua"
            ];

            provinsi.forEach(p => {
                const option = new Option(p, p.toLowerCase());
                locationInput.append(option);
            });

            $('#locationInput').select2({
                placeholder: "Pilih Provinsi",
                width: '100%'
            });

            function filterJobs() {
                const searchVal = searchInput.value.toLowerCase();
                const locationVal = locationInput.val() ? locationInput.val().toLowerCase() : '';
                const kategoriVal = kategoriSelect.value.toLowerCase();
                const pendidikanVal = pendidikanSelect.value.toLowerCase();
                const tipeVal = tipeSelect.value.toLowerCase();
                const gajiVal = gajiSelect.value;

                let anyVisible = false;

                jobCards.forEach(card => {
                    const judul = card.dataset.judul.toLowerCase();
                    const lokasi = card.dataset.lokasi.toLowerCase();
                    const kategori = card.dataset.kategori.toLowerCase();
                    const pendidikan = card.dataset.pendidikan.toLowerCase();
                    const tipe = card.dataset.tipe.toLowerCase();
                    const gajiMin = parseInt(card.dataset.gajiMin);
                    const gajiMax = parseInt(card.dataset.gajiMax);

                    let show = true;

                    if (searchVal && !judul.includes(searchVal)) show = false;
                    if (locationVal && !lokasi.includes(locationVal)) show = false;
                    if (kategoriVal && kategoriVal !== '' && kategori !== kategoriVal) show = false;
                    if (pendidikanVal && pendidikanVal !== '' && pendidikan !== pendidikanVal) show = false;
                    if (tipeVal && tipeVal !== '' && tipe !== tipeVal) show = false;

                    if (gajiVal) {
                        const [min, max] = gajiVal.split('-').map(Number);
                        if (gajiMax < min || gajiMin > max) show = false;
                    }

                    card.style.display = show ? '' : 'none';
                    if (show) anyVisible = true;
                });

                let noJobs = document.querySelector('#jobList .no-jobs');
                if (!anyVisible) {
                    if (!noJobs) {
                        noJobs = document.createElement('div');
                        noJobs.className = 'no-jobs text-center py-5';
                        noJobs.innerHTML = `
                    <i class="bi bi-emoji-frown fs-1 mb-2 text-muted"></i>
                    <p class="text-muted fs-5">Ups! Tidak ada lowongan yang sesuai dengan pencarian atau filter kamu.</p>
                `;
                        jobListContainer.appendChild(noJobs);
                    }
                } else {
                    if (noJobs) noJobs.remove();
                }
            }

            searchInput.addEventListener('input', filterJobs);
            locationInput.on('change', filterJobs);
            kategoriSelect.addEventListener('change', filterJobs);
            pendidikanSelect.addEventListener('change', filterJobs);
            tipeSelect.addEventListener('change', filterJobs);
            gajiSelect.addEventListener('change', filterJobs);
            btnSearch.addEventListener('click', filterJobs);
        });

document.addEventListener('DOMContentLoaded', function () {

    var carousel = document.getElementById('mitraCarousel');
    var bsCarousel = new bootstrap.Carousel(carousel, {
        interval: 3000,
        wrap: true
    });

    var currentSlide = document.getElementById('currentSlide');

    carousel.addEventListener('slid.bs.carousel', function (event) {
        currentSlide.textContent = event.to + 1;
    });

});