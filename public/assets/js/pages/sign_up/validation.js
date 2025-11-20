// =============================
// Validation Email + Password
// =============================
document.addEventListener("DOMContentLoaded", () => {

    // --------- EMAIL ---------
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('email-error');

    if (emailInput) {
        emailInput.addEventListener('input', function () {
            const email = emailInput.value;
            const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!regexEmail.test(email)) {
                emailError.style.display = 'block';
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
            } else {
                emailError.style.display = 'none';
                emailInput.classList.remove('is-invalid');
                emailInput.classList.add('is-valid');
            }
        });
    }

    // --------- PASSWORD ---------
    const passwordInput = document.getElementById('password');
    const passwordError = document.getElementById('password-error');

    if (passwordInput) {
        passwordInput.addEventListener('input', function () {
            const password = passwordInput.value;
            const regexPassword =
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

            if (!regexPassword.test(password)) {
                passwordError.style.display = 'block';
                passwordInput.classList.add('is-invalid');
                passwordInput.classList.remove('is-valid');
            } else {
                passwordError.style.display = 'none';
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
            }
        });
    }
});
// --------- PASSWORD CONFIRM ---------
const passwordConfirmInput = document.getElementById('password_confirmation');
const passwordConfirmError = document.getElementById('password-confirm-error');

if (passwordConfirmInput) {
    passwordConfirmInput.addEventListener('input', function () {
        if (passwordConfirmInput.value !== passwordInput.value) {
            passwordConfirmError.style.display = 'block';
            passwordConfirmInput.classList.add('is-invalid');
            passwordConfirmInput.classList.remove('is-valid');
        } else {
            passwordConfirmError.style.display = 'none';
            passwordConfirmInput.classList.remove('is-invalid');
            passwordConfirmInput.classList.add('is-valid');
        }
    });
}
