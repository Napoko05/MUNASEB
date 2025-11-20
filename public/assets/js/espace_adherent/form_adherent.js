document.addEventListener('DOMContentLoaded', function () {
    const avatarInput = document.getElementById('avatar');
    const preview = document.getElementById('photo_preview');

    // Aperçu de l'image avant envoi
    avatarInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (evt) {
                preview.src = evt.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Validation simple
    document.getElementById('frm_adherant_new').addEventListener('submit', function (e) {
        const required = ['nom', 'prenom', 'ine', 'tel1'];
        for (let field of required) {
            if (!this[field].value.trim()) {
                alert('Veuillez remplir le champ : ' + field.toUpperCase());
                e.preventDefault();
                return false;
            }
        }
    });
});
