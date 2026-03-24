document.addEventListener('DOMContentLoaded', function () {
    const dropdowns = document.querySelectorAll('.nav-menu li.dropdown > a');

    dropdowns.forEach(drop => {
        drop.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                e.preventDefault();
                const parentLi = drop.parentElement;
                parentLi.classList.toggle('show');
            }
        });
    });
});