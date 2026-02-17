import * as bootstrap from 'bootstrap';
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