document.addEventListener("DOMContentLoaded", function () {

    const toggles = document.querySelectorAll(".regie-toggle");

    toggles.forEach(toggle => {
        toggle.addEventListener("click", function (e) {
            e.preventDefault();

            const parent = this.closest(".regie-item");
            const dropdown = parent.querySelector(".regie-dropdown");

            // fermer les autres
            document.querySelectorAll(".regie-item").forEach(item => {
                if (item !== parent) {
                    item.classList.remove("active");
                }
            });

            // toggle actuel
            parent.classList.toggle("active");

            // scroll si dropdown dépasse la sidebar
            if (parent.classList.contains("active") && dropdown) {
                const sidebar = document.querySelector(".regie-sidebar");
                const dropdownBottom = dropdown.getBoundingClientRect().bottom;
                const sidebarBottom = sidebar.getBoundingClientRect().bottom;

                if (dropdownBottom > sidebarBottom) {
                    const scrollAmount = dropdownBottom - sidebarBottom + 20;
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