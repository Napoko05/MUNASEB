document.querySelectorAll('.rejeter-btn').forEach(btn => {
    btn.addEventListener('click', function(){
        const id = this.dataset.id;
        const body = document.querySelector(`#rejeterModal${id} .rejeter-modal-body`);
        const footer = document.querySelector(`#rejeterModal${id} .rejeter-modal-footer`);
        body.style.display = 'block';
        footer.style.display = 'flex'; // align horizontalement
    });
});