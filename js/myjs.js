function validatePhone(){
    var phone = document.getElementById("phone").value;
    const phoneRegex = /^01[0-9]{9}$/;
    //document.getElementById("invalidPhone").innerHTML="";
    if (!phoneRegex.test(phone)) {
        document.getElementById("invalidPhone").innerHTML="Enter a valid  phone number";
        return false;
    }
}
function validatePassword(){
    var password = document.getElementById("password").value;
    const passwordRegex = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/;
    //document.getElementById("invalidPassword").innerHTML="";
    if (!passwordRegex.test(password)) {
        document.getElementById("invalidPassword").innerHTML="Enter a valid  password";
        return false;
    }
}

function validateConfPassword(){
    var password = document.getElementById("password").value;
    var confPassword = document.getElementById("conf_password").value;
    //document.getElementById("invalidConfPass").innerHTML="";
    if (password != confPassword) {
        document.getElementById("invalidConfPass").innerHTML="Password and Confirm Password Must Be Same";
        return false;
    }
}

function validateForm() {
    if (validatePhone() == false || validatePassword() == false || validateConfPassword() == false) {
        return false;
    }
}