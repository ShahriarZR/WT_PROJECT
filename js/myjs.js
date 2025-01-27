var link = document.createElement('link');
link.rel = 'stylesheet';
link.type = 'text/css';
link.href = '../style/style.css';
document.head.appendChild(link);



//reg validation
function validateName() {
    var name = document.getElementById("name").value;
    const regexname = /^[A-Za-z\s]+$/;
    if (!regexname.test(name)) {
        document.getElementById("invalidName").innerHTML = "Enter a valid Name";
        return false;
    }
}
function validateEmail() {
    const checkEmail = document.getElementById("email").value;
    const regexemail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

    if (!regexemail.test(checkEmail)) {
        document.getElementById("invalidEmail").innerHTML = "Enter a valid Email";
        return false; // Invalid email format
    }
}
/* function availableEmail(){
    const checkEmail = document.getElementById("email").value;
    // Check if the email already exists in the database
    fetch("../control/admin_reg_email_exist_check.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({ checkEmail: checkEmail })
    })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                // Email already exists
                showPopup("This email is already registered. Please use a different email.");
                return false;
            } else {
                // Email is valid and does not exist
                showPopup("Email is valid and available.");
                return true;
            }
        })
        .catch(error => {
            console.error("Error checking email existence:", error);
            showPopup("An error occurred while checking the email. Please try again later.");
        });
} */
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
        /* if(availableEmail()==false)
        {
            return false;
        } */
       return false;
    }
}

//admin panel
//admin management
function dashboard() {
    const adminDashboard = document.getElementById("adminDashboard");
    if (adminDashboard.style.display === "none" || adminDashboard.style.display === "") {
        adminDashboard.style.display = "block";
    }
    else {
        adminDashboard.style.display = "none";
    }
}
function manageAdmin(searchEmail = "") {
    document.getElementById("adminSearch").style.display = "block";
    document.getElementById("customerSearch").style.display = "none";
    document.getElementById("employeeSearch").style.display = "none";
    document.getElementById("sellerSearch").style.display = "none";
    
    fetch("../control/manage_admin_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email: searchEmail })
    })
    .then(response => response.json())
    .then(data => {
        if (Array.isArray(data) && data.length > 0) {
            var table = "<table border='1' id='adminTable'><tr><th>Serial</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>Gender</th><th>Address</th><th>Actions</th></tr>";
            data.forEach(function (row) {
                table += "<tr>" +
                    "<td>" + row.admin_id + "</td>" +
                    "<td contenteditable='false'>" + row.name + "</td>" +
                    "<td contenteditable='false'>" + row.email + "</td>" +
                    "<td contenteditable='false'>" + row.password + "</td>" +
                    "<td contenteditable='false'>" + row.phone + "</td>" +
                    "<td contenteditable='false'>" +
                    "<select disabled>" +
                    "<option value='Male'" + (row.gender === "Male" ? " selected" : "") + ">Male</option>" +
                    "<option value='Female'" + (row.gender === "Female" ? " selected" : "") + ">Female</option>" +
                    "<option value='Other'" + (row.gender === "Other" ? " selected" : "") + ">Other</option>" +
                    "</select>" +
                    "</td>" +
                    "<td contenteditable='false'>" + row.address + "</td>" +
                    "<td><button onclick='AdminEditRow(this)'>Edit</button><button onclick='deleteAdminRow(this)'>Delete</button></td>" +
                    "</tr>";
            });
            table += "</table><button id='addButton' onclick='addAdminRow()'>Add</button>";
            document.getElementById("output").innerHTML = table;
        } else {
            showPopup("No results found.");
        }
    })
    .catch(error => {
        showPopup("Error loading admin data: " + error.message);
    });
}
function searchAdminEmail() {
    var searchEmail = document.getElementById("searchEmail").value.trim();
    manageAdmin(searchEmail);
}
function AdminEditRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        if (i === 5) {
            var select = cells[i].querySelector("select");
            if (select) {
                select.disabled = isEditable;
            }
        } else {
            cells[i].contentEditable = !isEditable;
        }
    }

    if (isEditable) {
        button.textContent = "Edit";
        if (validateAdminRowData(row)) {
            updateAdminRowData(row);
        } else {
            showPopup("Enter Valid Data");
            manageAdmin();
        }
    } else {
        button.textContent = "Update";
    }
}
function updateAdminRowData(row) {
    var cells = row.getElementsByTagName("td");
    var rowData = {
        admin_id: cells[0].textContent,
        name: cells[1].textContent,
        email: cells[2].textContent,
        password: cells[3].textContent,
        phone: cells[4].textContent,
        gender: cells[5].querySelector("select").value,
        address: cells[6].textContent
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
        showPopup(data);
        manageAdmin();
    })
    .catch(error => {
        showPopup("Error updating admin data: " + error.message);
    });
}
function deleteAdminRow(button) {
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
        showPopup(data);
        row.remove();
        manageAdmin();
    })
    .catch(error => {
        showPopup("Error deleting admin data: " + error.message);
    });
}
function addAdminRow() {
    var table = document.getElementById("adminTable");
    var row = table.insertRow(-1);

    for (var i = 0; i < 8; i++) {
        var cell = row.insertCell(i);
        if (i === 5) {
            var select = document.createElement("select");
            var option1 = document.createElement("option");
            option1.value = "Male";
            option1.textContent = "Male";
            select.appendChild(option1);

            var option2 = document.createElement("option");
            option2.value = "Female";
            option2.textContent = "Female";
            select.appendChild(option2);

            var option3 = document.createElement("option");
            option3.value = "Other";
            option3.textContent = "Other";
            select.appendChild(option3);

            cell.appendChild(select);  // Add the dropdown to cell 5
        }
        else if (i < 7) {
            cell.contentEditable = "true";
        } else {
            cell.innerHTML = "<button onclick='saveAdminRow(this)'>Save</button>";
        }
    }
    row.cells[0].textContent = "New";
}
function saveAdminRow(button) {
    var row = button.parentElement.parentElement;
    if (validateAdminRowData(row)) {
        var cells = row.getElementsByTagName("td");

        var rowData = {
            name: cells[1].textContent,
            email: cells[2].textContent,
            password: cells[3].textContent,
            phone: cells[4].textContent,
            gender: cells[5].querySelector("select").value,
            address: cells[6].textContent
        };

        fetch("../control/add_admin.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(rowData)
        })
        .then(response => response.text())
        .then(data => {
            showPopup(data);
            manageAdmin();
        })
        .catch(error => {
            showPopup("Error saving admin data: " + error.message);
        });
    }
    else {
        showPopup("Enter Valid Data");
        manageAdmin();
    }
}
function validateAdminRowData(row) {
    var cells = row.getElementsByTagName("td");
    var name = cells[1].textContent.trim();
    var email = cells[2].textContent.trim();
    var password = cells[3].textContent.trim();
    var phone = cells[4].textContent.trim();
    var gender = cells[5].querySelector("select").value;
    var address = cells[6].textContent.trim();
    const regexname = /^[A-Za-z\s]+$/;
    const regexemail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^01[0-9]{9}$/;
    const passwordRegex = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/;

    // Validation rules
    if (name === "" ||
        email === "" ||
        password === "" ||
        phone === "" ||
        gender === "" ||
        address === "" ||
        !regexname.test(name) ||
        !regexemail.test(email) ||
        !passwordRegex.test(password) ||
        !phoneRegex.test(phone)
        || (gender !== "Male" && gender !== "Female" && gender !== "Other")

    ) {
        showPopup("Enter Valid Data");
        return false; // Invalid data
    }
    return true; // Valid data
}


//customer management
function manageCustomer(searchEmail = "") {
    document.getElementById("customerSearch").style.display = "block";
    document.getElementById("adminSearch").style.display = "none";
    document.getElementById("employeeSearch").style.display = "none";
    document.getElementById("sellerSearch").style.display = "none";

    fetch("../control/manage_customer_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email: searchEmail })
    })
    .then(response => response.json())
    .then(data => {
        if (Array.isArray(data) && data.length > 0) {
            var table = "<table border='1' id='customerTable'><tr><th>Serial</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>Gender</th><th>Address</th><th>Actions</th></tr>";
            data.forEach(function (row) {
                table += "<tr>" +
                    "<td>" + row.customer_id + "</td>" +
                    "<td contenteditable='false'>" + row.name + "</td>" +
                    "<td contenteditable='false'>" + row.email + "</td>" +
                    "<td contenteditable='false'>" + row.password + "</td>" +
                    "<td contenteditable='false'>" + row.phone + "</td>" +
                    "<td contenteditable='false'>" +
                    "<select disabled>" +
                    "<option value='Male'" + (row.gender === "Male" ? " selected" : "") + ">Male</option>" +
                    "<option value='Female'" + (row.gender === "Female" ? " selected" : "") + ">Female</option>" +
                    "<option value='Other'" + (row.gender === "Other" ? " selected" : "") + ">Other</option>" +
                    "</select>" +
                    "</td>" +
                    "<td contenteditable='false'>" + row.address + "</td>" +
                    "<td><button onclick='editCustomerRow(this)'>Edit</button><button onclick='deleteCustomerRow(this)'>Delete</button></td>" +
                    "</tr>";
            });
            table += "</table><button id='addCustomerButton' onclick='addCustomerRow()'>Add</button>";
            document.getElementById("output").innerHTML = table;
        } else {
            showPopup("No results found."); // Show message in popup if no customers are found
        }
    })
    .catch(error => {
        showPopup("Error loading customer data: " + error.message); // Show error in popup if there's an issue fetching data
    });
}
function searchCustomerByEmail() {
    var searchEmail = document.getElementById("searchCustomerEmail").value.trim();
    manageCustomer(searchEmail);
}
function editCustomerRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        if (i === 5) {
            // Toggle dropdown enable/disable for gender column
            var select = cells[i].querySelector("select");
            if (select) {
                select.disabled = isEditable;
            }
        } else {
            cells[i].contentEditable = !isEditable;
        }
    }

    if (isEditable) {
        button.textContent = "Edit";
        if (validateCustomerRowData(row)) {
            updateCustomerRow(row);
        } else {
            document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
            manageCustomer();
        }
    } else {
        button.textContent = "Update";
    }
}
function updateCustomerRow(row) {
    var cells = row.getElementsByTagName("td");
    var rowData = {
        customer_id: cells[0].textContent,
        name: cells[1].textContent,
        email: cells[2].textContent,
        password: cells[3].textContent,
        phone: cells[4].textContent,
        gender: cells[5].querySelector("select").value,
        address: cells[6].textContent
    };

    fetch("../control/update_customer.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
    .then(response => response.text())
    .then(data => {
        showPopup(data); // Display the server response in a popup
        manageCustomer();
    });
}
function deleteCustomerRow(button) {
    var row = button.parentElement.parentElement;
    var customerId = row.getElementsByTagName("td")[0].textContent;

    fetch("../control/delete_customer.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ customer_id: customerId })
    })
    .then(response => response.text())
    .then(data => {
        showPopup(data); // Display the server response in a popup
        row.remove();
        manageCustomer();
    });
}
function addCustomerRow() {
    var table = document.getElementById("customerTable");
    var row = table.insertRow(-1);

    for (var i = 0; i < 8; i++) {
        var cell = row.insertCell(i);
        if (i === 5) {
            var select = document.createElement("select");
            var option1 = document.createElement("option");
            option1.value = "Male";
            option1.textContent = "Male";
            select.appendChild(option1);

            var option2 = document.createElement("option");
            option2.value = "Female";
            option2.textContent = "Female";
            select.appendChild(option2);

            var option3 = document.createElement("option");
            option3.value = "Other";
            option3.textContent = "Other";
            select.appendChild(option3);

            cell.appendChild(select);  // Add the dropdown to cell 5
        }
        else if (i < 7) {
            cell.contentEditable = "true";
        } else {
            cell.innerHTML = "<button onclick='saveCustomerRow(this)'>Save</button>";
        }
    }
    row.cells[0].textContent = "New";
}
function saveCustomerRow(button) {
    var row = button.parentElement.parentElement;
    if (validateCustomerRowData(row)) {
        var cells = row.getElementsByTagName("td");

        var rowData = {
            name: cells[1].textContent,
            email: cells[2].textContent,
            password: cells[3].textContent,
            phone: cells[4].textContent,
            gender: cells[5].querySelector("select").value,
            address: cells[6].textContent
        };

        fetch("../control/add_customer.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(rowData)
        })
        .then(function (response) {
            return response.text();
        })
        .then(function (data) {
            showPopup(data); // Display the server response in a popup
            manageCustomer();
        });
    }
    else {
        showPopup("Enter Valid Data"); // Show validation error in a popup
        manageCustomer();
    }
}
function validateCustomerRowData(row) {
    var cells = row.getElementsByTagName("td");
    var name = cells[1].textContent.trim();
    var email = cells[2].textContent.trim();
    var password = cells[3].textContent.trim();
    var phone = cells[4].textContent.trim();
    var gender = cells[5].querySelector("select").value;
    var address = cells[6].textContent.trim();
    const regexname = /^[A-Za-z\s]+$/;
    const regexemail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^01[0-9]{9}$/;
    const passwordRegex = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/;

    // Validation rules
    if (name === "" ||
        email === "" ||
        password === "" ||
        phone === "" ||
        gender === "" ||
        address === "" ||
        !regexname.test(name) ||
        !regexemail.test(email) ||
        !passwordRegex.test(password) ||
        !phoneRegex.test(phone)
        || (gender !== "Male" && gender !== "Female" && gender !== "Other")
    ) {
        showPopup("Enter Valid Data"); // Show validation error in a popup
        return false; // Invalid data
    }
    return true; // Valid data
}



//employee management
function manageEmployee(searchEmail = "") {
    document.getElementById("employeeSearch").style.display = "block";
    document.getElementById("adminSearch").style.display = "none";
    document.getElementById("customerSearch").style.display = "none";
    document.getElementById("sellerSearch").style.display = "none";
    fetch("../control/manage_employee_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email: searchEmail })
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1' id='employeeTable'><tr><th>Serial</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>Gender</th><th>Address</th><th>Position</th><th>Actions</th></tr>";
                data.forEach(function (row) {
                    table += "<tr>" +
                        "<td>" + row.employee_id + "</td>" +
                        "<td contenteditable='false'>" + row.name + "</td>" +
                        "<td contenteditable='false'>" + row.email + "</td>" +
                        "<td contenteditable='false'>" + row.password + "</td>" +
                        "<td contenteditable='false'>" + row.phone + "</td>" +
                        "<td contenteditable='false'>" +
                        "<select disabled>" +
                        "<option value='Male'" + (row.gender === "Male" ? " selected" : "") + ">Male</option>" +
                        "<option value='Female'" + (row.gender === "Female" ? " selected" : "") + ">Female</option>" +
                        "<option value='Other'" + (row.gender === "Other" ? " selected" : "") + ">Other</option>" +
                        "</select>" +
                        "</td>" +
                        "<td contenteditable='false'>" + row.address + "</td>" +
                        "<td contenteditable='false'>" + row.position + "</td>" +
                        "<td><button onclick='editEmployeeRow(this)'>Edit</button><button onclick='deleteEmployeeRow(this)'>Delete</button></td>" +
                        "</tr>";
                });
                table += "</table><button id='addEmployeeButton' onclick='addEmployeeRow()'>Add</button>";
                document.getElementById("output").innerHTML = table;
            } else {
                showPopup("No results found.");
            }
        });
}
function searchEmployeeByEmail() {
    var searchEmail = document.getElementById("searchEmployeeEmail").value.trim();
    manageCustomer(searchEmail);
}
function editEmployeeRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        if (i === 5) {
            // Toggle dropdown enable/disable for gender column
            var select = cells[i].querySelector("select");
            if (select) {
                select.disabled = isEditable;
            }
        } else {
            cells[i].contentEditable = !isEditable;
        }
    }

    if (isEditable) {
        button.textContent = "Edit";
        if (validateEmployeeRowData(row)) {
            updateEmployeeRowData(row);
        } else {
            showPopup("Enter Valid Data");
            manageEmployee();
        }
    } else {
        button.textContent = "Update";
    }
}
function updateEmployeeRowData(row) {
    var cells = row.getElementsByTagName("td");
    var rowData = {
        employee_id: cells[0].textContent,
        name: cells[1].textContent,
        email: cells[2].textContent,
        password: cells[3].textContent,
        phone: cells[4].textContent,
        gender: cells[5].querySelector("select").value,
        address: cells[6].textContent,
        position: cells[7].textContent
    };

    fetch("../control/update_employee.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
        .then(response => response.text())
        .then(data => {
            // Show the response from the server in the popup instead of innerHTML
            showPopup(data);
            manageEmployee();  // Refresh the employee list after update
        });
}
function deleteEmployeeRow(button) {
    var row = button.parentElement.parentElement;
    var employeeId = row.getElementsByTagName("td")[0].textContent;

    fetch("../control/delete_employee.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ employee_id: employeeId })
    })
    .then(response => response.text())
    .then(data => {
        showPopup(data); // Display the server response in a popup
        row.remove();
        manageEmployee();
    });
}
/* function addEmployeeRow() {
    var table = document.getElementById("employeeTable");
    var row = table.insertRow(-1);
    for (var i = 0; i < 9; i++) {
        var cell = row.insertCell(i);
        if (i === 5) {
            var select = document.createElement("select");
            var option1 = document.createElement("option");
            option1.value = "Male";
            option1.textContent = "Male";
            select.appendChild(option1);

            var option2 = document.createElement("option");
            option2.value = "Female";
            option2.textContent = "Female";
            select.appendChild(option2);

            var option3 = document.createElement("option");
            option3.value = "Other";
            option3.textContent = "Other";
            select.appendChild(option3);

            cell.appendChild(select);  // Add the dropdown to cell 5
        }
        else if (i < 8) {
            cell.contentEditable = "true";
        } else {
            cell.innerHTML = "<button onclick='saveEmployeeRow(this)'>Save</button>";
        }
    }
    row.cells[0].textContent = "New";
} */
function addEmployeeRow() {
    var output = document.getElementById("employeeAdd");
    var form = document.createElement("div");
    form.id = "newPackageForm";

    // Email input
    var emailLabel = document.createElement("label");
    emailLabel.textContent = "Email:";
    form.appendChild(emailLabel);

    var emailInput = document.createElement("input");
    emailInput.type = "email";
    emailInput.id = "addEmployeeEmail";
    form.appendChild(emailInput);


    // Submit button
    var submitButton = document.createElement("button");
    submitButton.textContent = "Submit";
    submitButton.onclick = function () {
        saveNewEmployee();
    };
    form.appendChild(submitButton);

    // Clear output and append the form
    output.innerHTML = "";
    output.appendChild(form);
}
function saveNewEmployee() {
    var email = document.getElementById("addEmployeeEmail").value;

    // Validate input
    if (!email) {
        showPopup("Enter Email");
        return;
    }

    // Send data to server
    fetch("../control/add_new_employee_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email: email
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPopup("Email Added");
                addEmployeeRow();
            } else {
                showPopup("Error adding email: " + data.message);
            }
        })
        .catch(error => {
            showPopup("Error: " + error.message);
        });
}
function saveEmployeeRow(button) {
    var row = button.parentElement.parentElement;
    if (validateEmployeeRowData(row)) {
        var cells = row.getElementsByTagName("td");

        var rowData = {
            name: cells[1].textContent,
            email: cells[2].textContent,
            password: cells[3].textContent,
            phone: cells[4].textContent,
            gender: cells[5].querySelector("select").value,
            address: cells[6].textContent,
            position: cells[7].textContent
        };

        fetch("../control/add_employee.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(rowData)
        })
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                showPopup(data);
                manageEmployee();
            });
    } else {
        showPopup("Enter Valid Data");
        manageEmployee();
    }
}
function validateEmployeeRowData(row) {
    var cells = row.getElementsByTagName("td");
    var name = cells[1].textContent.trim();
    var email = cells[2].textContent.trim();
    var password = cells[3].textContent.trim();
    var phone = cells[4].textContent.trim();
    var gender = cells[5].querySelector("select").value;
    var address = cells[6].textContent.trim();
    const regexname = /^[A-Za-z\s]+$/;
    const regexemail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^01[0-9]{9}$/;
    const passwordRegex = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/;

    // Validation rules
    if (name === "" ||
        email === "" ||
        password === "" ||
        phone === "" ||
        gender === "" ||
        address === "" ||
        !regexname.test(name) ||
        !regexemail.test(email) ||
        !passwordRegex.test(password) ||
        !phoneRegex.test(phone)
        || (gender !== "Male" && gender !== "Female" && gender !== "Other")

    ) {
        return false; // Invalid data
    }
    return true; // Valid data
}


//seller management
function manageSeller(searchEmail = "") {
    document.getElementById("sellerSearch").style.display = "block";
    document.getElementById("adminSearch").style.display = "none";
    document.getElementById("customerSearch").style.display = "none";
    document.getElementById("employeeSearch").style.display = "none";

    fetch("../control/manage_seller_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email: searchEmail })
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1' id='sellerTable'><tr><th>Serial</th><th>Name</th><th>Email</th><th>Shop Name</th><th>Address</th><th>Password</th><th>Phone</th><th>Actions</th></tr>";
                data.forEach(function (row) {
                    table += "<tr>" +
                        "<td>" + row.seller_id + "</td>" +
                        "<td contenteditable='false'>" + row.name + "</td>" +
                        "<td contenteditable='false'>" + row.email + "</td>" +
                        "<td contenteditable='false'>" + row.shop_name + "</td>" +
                        "<td contenteditable='false'>" + row.address + "</td>" +
                        "<td contenteditable='false'>" + row.password + "</td>" +
                        "<td contenteditable='false'>" + row.phone + "</td>" +
                        "<td><button onclick='editSellerRow(this)'>Edit</button><button onclick='deleteSellerRow(this)'>Delete</button></td>" +
                        "</tr>";
                });
                table += "</table><button id='addSellerButton' onclick='addSellerRow()'>Add</button>";
                document.getElementById("output").innerHTML = table;
            } else {
                showPopup("No results found.");
                document.getElementById("output").innerHTML = "";
            }
        })
        .catch(error => {
            showPopup("An error occurred: " + error.message);
        });
}
function searchSellerByEmail() {
    var searchEmail = document.getElementById("searchSellerEmail").value.trim();
    manageSeller(searchEmail);
}
function editSellerRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) {
        cells[i].contentEditable = !isEditable;
    }

    if (isEditable) {
        button.textContent = "Edit";
        if (validateSellerRowData(row)) {
            updateSellerRowData(row);
        } else {
            showPopup("Enter valid data!");
        }
    } else {
        button.textContent = "Update";
    }
}
function updateSellerRowData(row) {
    var cells = row.getElementsByTagName("td");
    var rowData = {
        seller_id: cells[0].textContent,
        name: cells[1].textContent,
        email: cells[2].textContent,
        shop_name: cells[3].textContent,
        address: cells[4].textContent,
        password: cells[5].textContent,
        phone: cells[6].textContent
    };

    fetch("../control/update_seller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
        .then(response => response.text())
        .then(data => {
            showPopup(data);
            manageSeller();
        })
        .catch(error => {
            showPopup("Error updating seller: " + error.message);
        });
}
function deleteSellerRow(button) {
    var row = button.parentElement.parentElement;
    var sellerId = row.getElementsByTagName("td")[0].textContent;

    fetch("../control/delete_seller.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ seller_id: sellerId })
    })
        .then(response => response.text())
        .then(data => {
            showPopup(data);
            row.remove();
            manageSeller();
        })
        .catch(error => {
            showPopup("Error deleting seller: " + error.message);
        });
}
function addSellerRow() {
    var table = document.getElementById("sellerTable");
    var row = table.insertRow(-1);

    for (var i = 0; i < 8; i++) {
        var cell = row.insertCell(i);
        if (i < 7) {
            cell.contentEditable = "true";
        } else {
            cell.innerHTML = "<button onclick='saveSellerRow(this)'>Save</button>";
        }
    }
    row.cells[0].textContent = "New";
}
function saveSellerRow(button) {
    var row = button.parentElement.parentElement;
    if (validateSellerRowData(row)) {
        var cells = row.getElementsByTagName("td");

        var rowData = {
            name: cells[1].textContent,
            email: cells[2].textContent,
            shop_name: cells[3].textContent,
            address: cells[4].textContent,
            password: cells[5].textContent,
            phone: cells[6].textContent
        };

        fetch("../control/add_seller.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(rowData)
        })
            .then(response => response.text())
            .then(data => {
                showPopup(data);
                manageSeller();
            })
            .catch(error => {
                showPopup("Error adding seller: " + error.message);
            });
    } else {
        showPopup("Enter valid data!");
    }
}
function validateSellerRowData(row) {
    var cells = row.getElementsByTagName("td");
    var name = cells[1].textContent.trim();
    var email = cells[2].textContent.trim();
    var shopname = cells[3].textContent.trim();
    var address = cells[4].textContent.trim();
    var password = cells[5].textContent.trim();
    var phone = cells[6].textContent.trim();

    const regexname = /^[A-Za-z\s]+$/;
    const regexemail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phoneRegex = /^01[0-9]{9}$/;
    const passwordRegex = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/;

    // Validation rules
    if (name === "" ||
        email === "" ||
        password === "" ||
        phone === "" ||
        shopname === "" ||
        address === "" ||
        !regexname.test(name) ||
        !regexemail.test(email) ||
        !passwordRegex.test(password) ||
        !phoneRegex.test(phone)
    ) {
        return false; // Invalid data
    }
    return true; // Valid data
}

//travel accessories management
function travelAccessories() {
    const travelAccessories = document.getElementById("travelAccessories");
    if (travelAccessories.style.display === "none" || travelAccessories.style.display === "") {
        travelAccessories.style.display = "block";
    }
    else {
        travelAccessories.style.display = "none";
    }
}
function printAccessories(url, outputElement) {
    fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1'><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Seller ID</th></tr>";
                data.forEach(accessory => {
                    table += "<tr>" +
                        "<td>" + accessory.travel_accessory_id + "</td>" +
                        "<td>" + accessory.name + "</td>" +
                        "<td>" + accessory.description + "</td>" +
                        "<td>" + accessory.price + "</td>" +
                        "<td>" + accessory.stock + "</td>" +
                        "<td>" + accessory.seller_id + "</td>" +
                        "</tr>";
                });
                table += "</table>";
                document.getElementById(outputElement).innerHTML = table;
            } else {
                showPopup("No data found.");
                document.getElementById(outputElement).innerHTML = "";
            }
        });
}
function viewAllAccessories() {
    printAccessories("../control/view_all_accessories.php", "output");
}
function approveNewAccessories() {
    printAccessories("../control/approve_new_accessories.php", "output");
}

//travel packages management
function tourPackages() {
    const tourPackages = document.getElementById("tourPackages");
    if (tourPackages.style.display === "none" || tourPackages.style.display === "") {
        tourPackages.style.display = "block";
    }
    else {
        tourPackages.style.display = "none";
    }
}
function printApprovePackages(url, outputElement) {
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({})
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1'><tr><th>ID</th><th>Name</th><th>Description</th><th>Status</th><th>Price</th><th>Employee ID</th><th>Actions</th></tr>";
                data.forEach(package => {
                    table += "<tr>" +
                        "<td>" + package.approve_tour_package_id + "</td>" +
                        "<td>" + package.name + "</td>" +
                        "<td>" + package.description + "</td>" +
                        "<td>" + package.status + "</td>" +
                        "<td>" + package.price + "</td>" +
                        "<td>" + package.employee_id + "</td>" +
                        "<td>" +
                        "<button onclick='approvePackage(this)'>Approve</button>" +
                        "<button onclick='rejectPackage(this)'>Reject</button>" +
                        "</td>" +
                        "</tr>";
                });
                table += "</table>";
                document.getElementById(outputElement).innerHTML = table;
            } else {
                showPopup("No data found.");
                document.getElementById(outputElement).innerHTML = "";
            }
        });
}
function approvePackage(button) {
    //showPopup("i am here");
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");    
    var rowData = {
        approve_tour_package_id: cells[0].textContent,
        name: cells[1].textContent,
        description: cells[2].textContent,
        status: cells[3].textContent,
        price: cells[4].textContent,
        employee_id: cells[5].textContent
    };   
    fetch("../control/insert_tour_package.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
        .then(response => response.text())
        .then(result => {
            showPopup(result);
            approveNewPackages();
        })
        .catch(error => {
            showPopup("Error loading admin data: " + error.message);
        });
}
function rejectPackage(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var rowData = {
        approve_tour_package_id: cells[0].textContent
    };

    fetch("../control/delete_approve_tour_package.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
        .then(response => response.text())
        .then(result => {
            showPopup(result);
            approveNewPackages();
        });
}
function printPackages(url, outputElement) {
    fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1'><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Employee ID</th></tr>";
                data.forEach(package => {
                    table += "<tr>" +
                        "<td>" + package.tour_package_id + "</td>" +
                        "<td>" + package.tour_package_name + "</td>" +
                        "<td>" + package.tour_package_description + "</td>" +
                        "<td>" + package.tour_package_status + "</td>" +
                        "<td>" + package.tour_package_price + "</td>" +
                        "<td>" + package.employee_id + "</td>" +
                        "</tr>";
                });
                table += "</table>";
                document.getElementById(outputElement).innerHTML = table;
            } else {
                showPopup("No data found.");
                document.getElementById(outputElement).innerHTML = "";
            }
        });
}
function viewAllPackages() {
    printPackages("../control/view_all_package.php", "output");
}
function approveNewPackages() {
    printApprovePackages("../control/approve_new_package.php", "output");
}


//profile
function viewProfile() {
    fetch("../control/admin_profile_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var profileHtml =
                    "<h2>Admin Profile</h2>" +
                    "<div id='adminProfile'>" +
                    "<p><strong>Name:</strong> <span id='nameDisplay'>" + data.name + "</span></p>" +
                    "<p><strong>Email:</strong> <span id='emailDisplay'>" + data.email + "</span></p>" +
                    "<p><strong>Phone:</strong> <span id='phoneDisplay'>" + data.phone + "</span></p>" +
                    "<p><strong>Gender:</strong> <span id='genderDisplay'>" + data.gender + "</span></p>" +
                    "<p><strong>Address:</strong> <span id='addressDisplay'>" + data.address + "</span></p>" +
                    "<button onclick='enableEditProfile()'>Edit Profile</button> " +
                    "<button onclick='enableChangePassword()'>Change Password</button>" +
                    "</div>" +
                    "<div id='editAdminProfile' style='display: none;'>" +
                    "<p><strong>Name:</strong> <input type='text' id='editName' value='" + data.name + "'></p>" +
                    "<p><strong>Email:</strong> <input type='email' id='editEmail' value='" + data.email + "'></p>" +
                    "<p><strong>Phone:</strong> <input type='text' id='editPhone' value='" + data.phone + "'></p>" +
                    "<p><strong>Gender:</strong> <select id='editGender'>" +
                    "<option value='Male'" + (data.gender === 'Male' ? " selected" : "") + ">Male</option>" +
                    "<option value='Female'" + (data.gender === 'Female' ? " selected" : "") + ">Female</option>" +
                    "</select></p>" +
                    "<p><strong>Address:</strong> <input type='text' id='editAddress' value='" + data.address + "'></p>" +
                    "<button onclick='saveProfile()'>Save</button>" +
                    "<button onclick='cancelEdit()'>Cancel</button>" +
                    "</div>" +
                    "<div id='changePasswordSection' style='display: none;'>" +
                    "<h3>Change Password</h3>" +
                    "<p><strong>Current Password:</strong> <input type='password' id='currentPassword'></p>" +
                    "<p><strong>New Password:</strong> <input type='password' id='newPassword'></p>" +
                    "<p><strong>Confirm New Password:</strong> <input type='password' id='confirmNewPassword'></p>" +
                    "<button onclick='saveNewPassword()'>Save Password</button>" +
                    "<button onclick='cancelChangePassword()'>Cancel</button>" +
                    "</div>";

                document.getElementById("output").innerHTML = profileHtml;
            } else {
                showPopup("Error fetching profile data.");
            }
        })
        .catch(error => {
            showPopup("An error occurred while fetching the profile data.");
        });
}
function enableEditProfile() {
    document.getElementById("editAdminProfile").style.display = "block";
    document.getElementById("adminProfile").style.display = "none";
    document.getElementById("changePasswordSection").style.display = "none";
}
function enableChangePassword() {
    document.getElementById("changePasswordSection").style.display = "block";
    document.getElementById("adminProfile").style.display = "none";
    document.getElementById("editAdminProfile").style.display = "none";
}
function cancelChangePassword() {
    document.getElementById("changePasswordSection").style.display = "none";
    document.getElementById("adminProfile").style.display = "block";
}
function saveNewPassword() {
    const currentPassword = document.getElementById("currentPassword").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmNewPassword = document.getElementById("confirmNewPassword").value;
    const passwordRegex = /[!@#$%^&*()_\-+=\[\]{};':"\\|,.<>\/?]/;

    if (!passwordRegex.test(newPassword)) {
        showPopup("Password must contain at least one special character.");
        return;
    }
    if (newPassword !== confirmNewPassword) {
        showPopup("New password and confirm password must be the same.");
        return;
    }

    fetch("../control/admin_change_password_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            currentPassword: currentPassword,
            newPassword: newPassword
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPopup("Password changed successfully!");
                cancelChangePassword();
            } else {
                showPopup(data.message || "Error changing password.");
            }
        })
        .catch(error => {
            showPopup("An error occurred while changing the password.");
        });
}
function saveProfile() {
    var updatedData = {
        name: document.getElementById("editName").value.trim(),
        email: document.getElementById("editEmail").value.trim(),
        phone: document.getElementById("editPhone").value.trim(),
        gender: document.getElementById("editGender").value,
        address: document.getElementById("editAddress").value.trim()
    };

    fetch("../control/update_admin_profile.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(updatedData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPopup("Profile updated successfully!");
                viewProfile();
            } else {
                showPopup("Failed to update profile.");
            }
        })
        .catch(error => {
            showPopup("An error occurred while updating the profile.");
        });
}
function cancelEdit() {
    viewProfile();
}

//pop up message
function showPopup(message) {
    document.getElementById("popupMessage").textContent = message;
    document.getElementById("popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}

