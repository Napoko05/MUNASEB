
document.addEventListener("DOMContentLoaded", function () {

    const toggles = document.querySelectorAll(".dropdown-toggle");
    const menuToggle = document.getElementById("menuToggle");
    const navMenu = document.getElementById("navMenu");

    // MOBILE MENU
    menuToggle.addEventListener("click", () => {
        navMenu.classList.toggle("active");
    });

    // DROPDOWN
    toggles.forEach(toggle => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();

            const parent = this.parentElement;
            const submenu = parent.querySelector(".dropdown-menu");

            // fermer autres
            document.querySelectorAll(".dropdown").forEach(d => {
                if (d !== parent) {
                    d.classList.remove("open");
                    d.querySelector(".dropdown-menu")?.classList.remove("show");
                }
            });

            parent.classList.toggle("open");
            submenu.classList.toggle("show");
        });
    });

    // click outside
    document.addEventListener("click", function (e) {
        if (!e.target.closest(".dropdown")) {
            document.querySelectorAll(".dropdown").forEach(d => {
                d.classList.remove("open");
                d.querySelector(".dropdown-menu")?.classList.remove("show");
            });
        }
    });

});
