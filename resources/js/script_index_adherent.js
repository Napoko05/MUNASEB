document.addEventListener("DOMContentLoaded", function () {

    /* =========================
       ANIMATION CARDS HOVER
    ========================= */

    const cards = document.querySelectorAll(".card");

    cards.forEach(card => {

        card.addEventListener("mouseenter", () => {
            card.style.transform = "translateY(-8px) scale(1.01)";
            card.style.boxShadow = "0 12px 28px rgba(0,0,0,0.18)";
        });

        card.addEventListener("mouseleave", () => {
            card.style.transform = "translateY(0)";
            card.style.boxShadow = "none";
        });

    });


    /* =========================
       APPARITION AU SCROLL
    ========================= */

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {
                entry.target.classList.add("card-visible");
            }

        });

    }, { threshold: 0.2 });

    cards.forEach(card => {
        observer.observe(card);
    });


    /* =========================
       ANIMATION IMAGE BANNER
    ========================= */

    const banner = document.querySelector(".banner-img");

    if (banner) {

        banner.addEventListener("mousemove", (e) => {

            const rect = banner.getBoundingClientRect();

            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const moveX = (x - rect.width / 2) / 25;
            const moveY = (y - rect.height / 2) / 25;

            banner.style.transform = `translate(${moveX}px, ${moveY}px) scale(1.03)`;

        });

        banner.addEventListener("mouseleave", () => {
            banner.style.transform = "translate(0,0) scale(1)";
        });

    }


    /* =========================
       FAQ ACCORDION SMOOTH
    ========================= */

    const accordionButtons = document.querySelectorAll(".accordion-button");

    accordionButtons.forEach(btn => {

        btn.addEventListener("click", () => {

            btn.classList.toggle("faq-active");

        });

    });

});