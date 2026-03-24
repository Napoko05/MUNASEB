
document.addEventListener('DOMContentLoaded', function () {

    const toggles = document.querySelectorAll('.sidebar-toggle');

    toggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();

            const parent = this.closest('.sidebar-item');

            // Fermer les autres menus (optionnel)
            document.querySelectorAll('.sidebar-item').forEach(item => {
                if (item !== parent) {
                    item.classList.remove('active');
                }
            });

            // Toggle menu actuel
            parent.classList.toggle('active');
        });
    });

});