document.addEventListener("DOMContentLoaded", function () {
    const toggles = document.querySelectorAll(".nav-link[data-bs-toggle='collapse']");

    toggles.forEach(toggle => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();
            const targetId = this.getAttribute("href");
            const target = document.querySelector(targetId);

            // fermer les autres sous-menus
            document.querySelectorAll(".submenu").forEach(menu => {
                if (menu !== target) {
                    menu.classList.remove("show");
                }
            });

            target.classList.toggle("show");
        });
    });
});