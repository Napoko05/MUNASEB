document.addEventListener("DOMContentLoaded", function () {

    const toggles = document.querySelectorAll(".rh-toggle");

    toggles.forEach(toggle => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();

            const parent = this.closest(".rh-item");
            const dropdown = parent.querySelector(".rh-dropdown");

            // fermer les autres
            document.querySelectorAll(".rh-item").forEach(item => {
                if (item !== parent) {
                    item.classList.remove("active");
                }
            });

            // toggle actuel
            parent.classList.toggle("active");

            // ===== SCROLL pour voir le sous-menu si nécessaire =====
            if (parent.classList.contains("active") && dropdown) {
                const sidebar = document.querySelector(".rh-sidebar");

                // calcule la position du dropdown dans la sidebar
                const dropdownBottom = dropdown.getBoundingClientRect().bottom;
                const sidebarBottom = sidebar.getBoundingClientRect().bottom;

                // si le dropdown dépasse le bas de la sidebar, scroll
                if (dropdownBottom > sidebarBottom) {
                    const scrollAmount = dropdownBottom - sidebarBottom + 20; // 20px marge
                    sidebar.scrollBy({
                        top: scrollAmount,
                        left: 0,
                        behavior: "smooth"
                    });
                }
            }
        });
    });

});