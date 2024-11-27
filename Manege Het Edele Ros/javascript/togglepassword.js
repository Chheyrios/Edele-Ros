document.addEventListener("DOMContentLoaded", function() {
    const togglePassword = document.querySelector("#togglePassword");
    const passwordField = document.querySelector("#password");

    togglePassword.addEventListener("click", function () {
        // Toggle the type attribute
        const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
        passwordField.setAttribute("type", type);

        // Toggle the eye / eye-slash icon
        this.classList.toggle("bi-eye");
    });

    const toggleRegisterPassword = document.querySelector("#toggleRegisterPassword");
    const registerPasswordField = document.querySelector("#registerPassword");

    toggleRegisterPassword.addEventListener("click", function () {
        const type = registerPasswordField.getAttribute("type") === "password" ? "text" : "password";
        registerPasswordField.setAttribute("type", type);
        this.classList.toggle("bi-eye");
    });

    const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
    const confirmPasswordField = document.querySelector("#confirmPassword");

    toggleConfirmPassword.addEventListener("click", function () {
        const type = confirmPasswordField.getAttribute("type") === "password" ? "text" : "password";
        confirmPasswordField.setAttribute("type", type);
        this.classList.toggle("bi-eye");
    });
});
