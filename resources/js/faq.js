document.querySelectorAll(".faq-toggle").forEach(button => {

    button.addEventListener("click", function () {

        let content = this.parentElement.nextElementSibling;

        if (content.style.display === "block") {
            content.style.display = "none";
            this.classList.remove("active");
        } else {
            content.style.display = "block";
            this.classList.add("active");
        }

    });

});