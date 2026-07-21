function validateRegister() {

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let password = document.getElementById("password").value;
    let confirm = document.getElementById("confirm_password").value;

    if(name === ""){
        alert("Please enter your name");
        return false;
    }

    let emailPattern=/^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(!emailPattern.test(email)){
        alert("Enter a valid email.");
        return false;
    }

    let phonePattern=/^[0-9]{10}$/;

    if(!phonePattern.test(phone)){
        alert("Phone number must be 10 digits.");
        return false;
    }

    if(password.length<6){
        alert("Password must be at least 6 characters.");
        return false;
    }

    if(password!==confirm){
        alert("Passwords do not match.");
        return false;
    }

    return true;
}

function togglePassword(inputId, element) {

    const passwordInput = document.getElementById(inputId);

    const icon = element.querySelector("i");

    if (passwordInput.type === "password") {

        passwordInput.type = "text";

        icon.classList.remove("fa-eye-slash");

        icon.classList.add("fa-eye");

    } else {

        passwordInput.type = "password";

        icon.classList.remove("fa-eye");

        icon.classList.add("fa-eye-slash");
    }

}