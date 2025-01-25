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
function manageAdmin(searchEmail = "") {
    document.getElementById("adminSearch").style.display = "block";
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
                        "<td contenteditable='false'>" + row.gender + "</td>" +
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
        cells[i].contentEditable = !isEditable;
    }

    if (isEditable) {
        button.textContent = "Edit";
        updateAdminRowData(row);
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
        gender: cells[5].textContent,
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
    var cells = row.getElementsByTagName("td");

    var rowData = {
        name: cells[1].textContent,
        email: cells[2].textContent,
        password: cells[3].textContent,
        phone: cells[4].textContent,
        gender: cells[5].textContent,
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
            manageAdmin();
        });
}


//user management
function manageCustomer(searchEmail = "") {
    document.getElementById("customerSearch").style.display = "block";
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
                        "<td contenteditable='false'>" + row.gender + "</td>" +
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
        cells[i].contentEditable = !isEditable;
    }

    if (isEditable) {
        button.textContent = "Edit";
        updateCustomerRow(row);
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
        gender: cells[5].textContent,
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
    var cells = row.getElementsByTagName("td");

    var rowData = {
        name: cells[1].textContent,
        email: cells[2].textContent,
        password: cells[3].textContent,
        phone: cells[4].textContent,
        gender: cells[5].textContent,
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


//employee management
function manageEmployee(searchEmail = "") {
    document.getElementById("employeeSearch").style.display = "block";
    fetch("../control/manage_employee_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email: searchEmail })
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data)/*  && data.length > 0 */) {
                var table = "<table border='1' id='employeeTable'><tr><th>Serial</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>Gender</th><th>Address</th><th>Position</th><th>Actions</th></tr>";
                data.forEach(function (row) {
                    table += "<tr>" +
                        "<td>" + row.employee_id + "</td>" +
                        "<td contenteditable='false'>" + row.name + "</td>" +
                        "<td contenteditable='false'>" + row.email + "</td>" +
                        "<td contenteditable='false'>" + row.password + "</td>" +
                        "<td contenteditable='false'>" + row.phone + "</td>" +
                        "<td contenteditable='false'>" + row.gender + "</td>" +
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
function editEmployeeRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        cells[i].contentEditable = !isEditable;
    }

    if (isEditable) {
        button.textContent = "Edit";
        updateEmployeeRowData(row);
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
        gender: cells[5].textContent,
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
    var cells = row.getElementsByTagName("td");

    var rowData = {
        name: cells[1].textContent,
        email: cells[2].textContent,
        password: cells[3].textContent,
        phone: cells[4].textContent,
        gender: cells[5].textContent,
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


//seller management
function manageSeller(searchEmail = "") {
    document.getElementById("sellerSearch").style.display = "block";
    fetch("../control/manage_seller_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ email: searchEmail })
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) /* && data.length > 0 */) {
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
        updateSellerRowData(row);
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
