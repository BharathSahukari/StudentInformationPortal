function validateLogin(){

    let email=document.getElementById("email").value.trim();
    let password=document.getElementById("password").value;

    if(email==""){
        alert("Enter Email");
        return false;
    }

    if(password==""){
        alert("Enter Password");
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