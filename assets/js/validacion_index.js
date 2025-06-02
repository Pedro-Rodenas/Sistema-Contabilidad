document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form-login");
    const userInput = document.getElementById("user");
    const passInput = document.getElementById("pass");
    const userError = document.getElementById("user-error");
    const passError = document.getElementById("pass-error");
    const loginError = document.getElementById("login-error");

    if (typeof loginErrorFlag !== 'undefined' && loginErrorFlag) {
        loginError.textContent = "Usuario o contraseña incorrectos.";
    }

    form.addEventListener("submit", function (e) {
        let hasError = false;
        userError.textContent = "";
        passError.textContent = "";
        loginError.textContent = "";

        if (/[A-Z]/.test(userInput.value)) {
            userError.textContent = "No se permiten letras mayúsculas en el usuario.";
            hasError = true;
        }

        if (/[A-Z]/.test(passInput.value)) {
            passError.textContent = "No se permiten letras mayúsculas en la contraseña.";
            hasError = true;
        }

        if (hasError) {
            e.preventDefault();
        }
    });
});
