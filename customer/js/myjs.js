var link = document.createElement('link');
link.rel = 'stylesheet';
link.type = 'text/css';
link.href = '../style/style.css';
document.head.appendChild(link);

//Customer JS
function validation() {
    const fname = document.getElementById("fname").value;
    const lname = document.getElementById("lname").value;
    const mail = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const dob = document.getElementById("dob").value;
    const password = document.getElementById("pass").value;
    const repassword = document.getElementById("repass").value;
    const currentDate = new Date();
    const dobDate = new Date(dob);
    const age = currentDate.getFullYear() - dobDate.getFullYear();
    const regexname = /^[A-Za-z]+$/;
    const regexemail = /@.+\.com$/;
    let flag = true;

    // Clear error messages
    document.getElementById("fnameerror").innerHTML = "";
    document.getElementById("lnameerror").innerHTML = "";
    document.getElementById("emailerror").innerHTML = "";
    document.getElementById("phoneerror").innerHTML = "";
    document.getElementById("doberror").innerHTML = "";
    document.getElementById("passerror").innerHTML = "";

    // Validate first name
    if (!regexname.test(fname)) {
        document.getElementById("fnameerror").innerHTML = "Only Alphabet Acceptable.";
        flag = false;
    }

    // Validate last name
    if (!regexname.test(lname)) {
        document.getElementById("lnameerror").innerHTML = "Only Alphabet Acceptable.";
        flag = false;
    }

    // Validate email
    if (!regexemail.test(mail)) {
        document.getElementById("emailerror").innerHTML = "Enter valid email.";
        flag = false;
    }

    // Validate phone number (should have 11 digits)
    if (phone.length !== 11) {
        document.getElementById("phoneerror").innerHTML = "Phone Number is not valid.";
        flag = false;
    }

    // Validate age (should be at least 15)
    if (age < 15) {
        document.getElementById("doberror").innerHTML = "You can register after 15 years.";
        flag = false;
    }

    // Validate password match
    if (password !== repassword) {
        document.getElementById("passerror").innerHTML = "Password did not match.";
        flag = false;
    }

    // If any validation failed, prevent form submission
    if (flag == false) {
        return false;
    }
    return true;
}
function profilevalidation() {
    const name = document.getElementById("name").value;
    const phone = document.getElementById("phone").value;
    const dob = document.getElementById("dob").value;
    const currentDate = new Date();
    const dobDate = new Date(dob);
    const age = currentDate.getFullYear() - dobDate.getFullYear();
    const regexname = /^[A-Za-z\s]+$/;
    const regexphone = /^[0-9]{11}$/;

    let flag = true;

    // Clear previous error messages
    document.getElementById("nameerror").innerHTML = "";
    document.getElementById("phoneerror").innerHTML = "";
    document.getElementById("doberror").innerHTML = "";

    // Validate Name (Only Alphabet Allowed)
    if (name && !regexname.test(name)) {
        document.getElementById("nameerror").innerHTML = "Only alphabets and spaces are acceptable.";
        flag = false;
    }

    // Validate Phone (Must be exactly 11 digits)
    if (phone && !regexphone.test(phone)) {
        document.getElementById("phoneerror").innerHTML = "Phone number must be exactly 11 digits.";
        flag = false;
    }

    // Validate Age (Minimum 15 years old)
    if (dob && age < 15) {
        document.getElementById("doberror").innerHTML = "You must be at least 15 years old.";
        flag = false;
    }

    // Validate Password (if changing password)
    const currentPassword = document.getElementById("current_password").value;
    const newPassword = document.getElementById("new_password").value;
    const confirmPassword = document.getElementById("confirm_password").value;

    if (currentPassword || newPassword || confirmPassword) {
        // Ensure the new password matches the confirmation
        if (newPassword && newPassword !== confirmPassword) {
            alert("New password and confirmation do not match.");
            flag = false;
        }
    }

    return flag;
}



function passwordChange() {
    document.getElementById("changePassword").style.display = "block";
    document.getElementById("personalInformation").style.display = "none";
    document.getElementById("passChange").style.display = "none";
    document.getElementById("profileChange").style.display = "block";
    
}
function profileChange() {
    document.getElementById("changePassword").style.display = "none";
    document.getElementById("personalInformation").style.display = "block";
    document.getElementById("passChange").style.display = "block";
    document.getElementById("profileChange").style.display = "none";
}


//pop up message
function showPopup(message) {
    document.getElementById("popupMessage").textContent = message;
    document.getElementById("popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}

