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
                document.getElementById("output").innerHTML = "No results found.";
            }
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
        if (validateAdminRowData(row)) {
            updateAdminRowData(row);
        } else {
            document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
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
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            manageAdmin();
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
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            row.remove();
            manageAdmin();
        });
}
function addAdminRow() {
    var table = document.getElementById("adminTable");
    var row = table.insertRow(-1);

    for (var i = 0; i < 8; i++) {
        var cell = row.insertCell(i);
        if (i < 7) {
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
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            });
    }
    else {
        document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
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
                document.getElementById("output").innerHTML = "No results found.";
            }
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
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
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
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            row.remove();
            manageCustomer();
        });
}
function addCustomerRow() {
    var table = document.getElementById("customerTable");
    var row = table.insertRow(-1);

    for (var i = 0; i < 8; i++) {
        var cell = row.insertCell(i);
        if (i < 7) {
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
                document.getElementById("output").innerHTML += "<p>" + data + "</p>";
                manageCustomer();
            });
    }
    else {
        document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
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
                document.getElementById("output").innerHTML = "No results found.";
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
            document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
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
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            manageEmployee();
        });
}
function addEmployeeRow() {
    var table = document.getElementById("employeeTable");
    var row = table.insertRow(-1);

    for (var i = 0; i < 9; i++) {
        var cell = row.insertCell(i);
        if (i < 8) {
            cell.contentEditable = "true";
        } else {
            cell.innerHTML = "<button onclick='saveEmployeeRow(this)'>Save</button>";
        }
    }
    row.cells[0].textContent = "New";
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
                document.getElementById("output").innerHTML += "<p>" + data + "</p>";
                manageEmployee();
            });
    }
    else {
        document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
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
                document.getElementById("output").innerHTML = "No results found.";
            }
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

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        cells[i].contentEditable = !isEditable;
    }

    if (isEditable) {
        button.textContent = "Edit";
        if (validateSellerRowData(row)) {
            updateSellerRowData(row);
        } else {
            document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
            manageSeller();
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
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            manageSeller();
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
            document.getElementById("output").innerHTML += "<p>" + data + "</p>";
            row.remove();
            manageSeller();
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
    if (validateSellerRowData(row)){
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
            .then(function (response) {
                return response.text();
            })
            .then(function (data) {
                document.getElementById("output").innerHTML += "<p>" + data + "</p>";
                manageSeller();
            });
    }
    else{
        document.getElementById("errorMessage").innerHTML = "Enter Valid Data";
        manageSeller();
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
                document.getElementById(outputElement).innerHTML = "No data found.";
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
                var table = "<table border='1'><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Seller ID</th></tr>";
                data.forEach(package => {
                    table += "<tr>" +
                        "<td>" + package.tour_package_id + "</td>" +
                        "<td>" + package.name + "</td>" +
                        "<td>" + package.description + "</td>" +
                        "<td>" + package.status + "</td>" +
                        "<td>" + package.price + "</td>" +
                        "<td>" + package.employee_id + "</td>" +
                        "</tr>";
                });
                table += "</table>";
                document.getElementById(outputElement).innerHTML = table;
            } else {
                document.getElementById(outputElement).innerHTML = "No data found.";
            }
        });
}
function viewAllPackages() {
    printPackages("../control/view_all_package.php", "output");
}
function approveNewPackages() {
    printPackages("../control/approve_new_package.php", "output");
}