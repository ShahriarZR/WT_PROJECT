function validateName() {
    var name = document.getElementById("name").value;
    const regexname = /^[A-Za-z]+$/;
    if (!regexname.test(name)) {
        document.getElementById("invalidName").innerHTML = "Enter a valid Name";
        flag = false;
    }
}
function validateEmail() {
    var email = document.getElementById("email").value;
    const regexemail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!regexemail.test(email)) {
        document.getElementById("invalidEmail").innerHTML = "Enter a valid Email";
        flag = false;
    }
}
function validatePhone() {
    var phone = document.getElementById("phone").value;
    const phoneRegex = /^01[0-9]{9}$/;
    //document.getElementById("invalidPhone").innerHTML="";
    if (!phoneRegex.test(phone)) {
        document.getElementById("invalidPhone").innerHTML = "Enter a valid  phone number";
        return false;
    }
}
function validatePassword() {
    var password = document.getElementById("password").value;
    const passwordRegex = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/;
    //document.getElementById("invalidPassword").innerHTML="";
    if (!passwordRegex.test(password)) {
        document.getElementById("invalidPassword").innerHTML = "Enter a valid  password";
        return false;
    }
}
function validateConfPassword() {
    var password = document.getElementById("password").value;
    var confPassword = document.getElementById("conf_password").value;
    //document.getElementById("invalidConfPass").innerHTML="";
    if (password != confPassword) {
        document.getElementById("invalidConfPass").innerHTML = "Password and Confirm Password Must Be Same";
        return false;
    }
}
function validateForm() {
    if (validateName() == false || validateEmail() == false || validatePhone() == false || validatePassword() == false || validateConfPassword() == false) {
        return false;
    }
}

function dashboard() {
    const adminDashboard = document.getElementById("adminDashboard");
    if (adminDashboard.style.display === "none" || adminDashboard.style.display === "") {
        adminDashboard.style.display = "block";
    }
    else {
        adminDashboard.style.display = "none";
    }
}

function manageAdmin() {
    fetch("../control/manage_admin_control.php")
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1' id='adminTable'><tr><th>Serial</th><th>Name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Address</th><th>Actions</th></tr>";
                data.forEach(function (row) {
                    table += "<tr>" +
                        "<td>" + row.admin_id + "</td>" +
                        "<td contenteditable='false'>" + row.name + "</td>" +
                        "<td contenteditable='false'>" + row.email + "</td>" +
                        "<td contenteditable='false'>" + row.phone + "</td>" +
                        "<td contenteditable='false'>" + row.gender + "</td>" +
                        "<td contenteditable='false'>" + row.address + "</td>" +
                        "<td><button onclick='toggleEditRow(this)'>Edit</button><button onclick='deleteRow(this)'>Delete</button></td>" +
                        "</tr>";
                });
                table += "</table>";
                document.getElementById("output").innerHTML = table;
            } else {
                document.getElementById("output").innerHTML = "No results found.";
            }
        });
}

function toggleEditRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        cells[i].contentEditable = !isEditable;
    }

    if (isEditable) {
        button.textContent = "Edit";
        updateRowData(row);
    } else {
        button.textContent = "Update";
    }
}

function updateRowData(row) {
    var cells = row.getElementsByTagName("td");
    var rowData = {
        admin_id: cells[0].textContent,
        name: cells[1].textContent,
        email: cells[2].textContent,
        phone: cells[3].textContent,
        gender: cells[4].textContent,
        address: cells[5].textContent
    };

    fetch("../control/update_admin.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            manageAdmin();
        });
}
function deleteRow(button) {
    var row = button.parentElement.parentElement;
    var adminId = row.getElementsByTagName("td")[0].textContent;

    fetch("../control/delete_admin.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ admin_id: adminId })
    })
        .then(response => response.text())
        .then(data => {
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            row.remove();
            manageAdmin();
        });
}