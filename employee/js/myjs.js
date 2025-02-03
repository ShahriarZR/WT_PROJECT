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
function validateAdminForm() {
    if (validateName() == false || validatePhone() == false || validatePassword() == false || validateConfPassword() == false) {
        return false;
    }
}

//Employee js
function validateEmployeeForm() {
    if (validateName() == false || validatePhone() == false || validatePassword() == false || validateConfPassword() == false) {
        /* if(availableEmail()==false)
        {
            return false;
        } */
        return false;
    }
}
//Manage Packages
function viewPackages(searchName = "") {
    fetch("../control/view_packages_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ name: searchName })
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1' id='packagesTable'><tr><th>ID</th><th>Name</th><th>Description</th><th>Status</th><th>Price</th><th>Actions</th></tr>";
                data.forEach(function (row) {
                    table += "<tr>" +
                        "<td>" + row.tour_package_id + "</td>" +
                        "<td contenteditable='false'>" + row.tour_package_name + "</td>" +
                        "<td contenteditable='false'>" + row.tour_package_description + "</td>" +
                        "<td contenteditable='false'>" +
                        "<select disabled>" +
                        "<option value='Available'" + (row.tour_package_status === "Available" ? " selected" : "") + ">Available</option>" +
                        "<option value='Unavailable'" + (row.tour_package_status === "Unavailable" ? " selected" : "") + ">Unavailable</option>" +
                        "</select>" +
                        "</td>" +
                        "<td contenteditable='false'>" + row.tour_package_price + "</td>" +
                        "<td><button onclick='editPackageRow(this)'>Edit</button><button onclick='deletePackageRow(this)'>Delete</button></td>" +
                        "</tr>";
                });
                table += "</table>";
                document.getElementById("output").innerHTML = table;
            } else {
                showPopup("No packages found."); // Show message in popup if no packages are found
            }
        })
        .catch(error => {
            showPopup("Error loading customer data: " + error.message); // Show error in popup if there's an issue fetching data
        });
}
function addNewPackage() {
    var output = document.getElementById("output");
    var form = document.createElement("div");
    form.id = "newPackageForm";

    var heading = document.createElement("h3");
    heading.textContent = "Add New Package";
    form.appendChild(heading);

    // Name input
    var nameLabel = document.createElement("label");
    nameLabel.textContent = "Name:";
    form.appendChild(nameLabel);

    var nameInput = document.createElement("input");
    nameInput.type = "text";
    nameInput.id = "packageName";
    form.appendChild(nameInput);

    form.appendChild(document.createElement("br"));

    // Description input
    var descriptionLabel = document.createElement("label");
    descriptionLabel.textContent = "Description:";
    form.appendChild(descriptionLabel);

    var descriptionInput = document.createElement("textarea");
    descriptionInput.id = "packageDescription";
    form.appendChild(descriptionInput);

    form.appendChild(document.createElement("br"));

    // Status dropdown
    var statusLabel = document.createElement("label");
    statusLabel.textContent = "Status:";
    form.appendChild(statusLabel);

    var statusSelect = document.createElement("select");
    statusSelect.id = "packageStatus";

    var availableOption = document.createElement("option");
    availableOption.value = "Available";
    availableOption.textContent = "Available";
    statusSelect.appendChild(availableOption);

    var unavailableOption = document.createElement("option");
    unavailableOption.value = "Unavailable";
    unavailableOption.textContent = "Unavailable";
    statusSelect.appendChild(unavailableOption);

    form.appendChild(statusSelect);

    form.appendChild(document.createElement("br"));

    // Price input
    var priceLabel = document.createElement("label");
    priceLabel.textContent = "Price:";
    form.appendChild(priceLabel);

    var priceInput = document.createElement("input");
    priceInput.type = "number";
    priceInput.id = "packagePrice";
    form.appendChild(priceInput);

    form.appendChild(document.createElement("br"));

    // Employee ID input
    /* var employeeIdLabel = document.createElement("label");
    employeeIdLabel.textContent = "Employee ID:";
    form.appendChild(employeeIdLabel);

    var employeeIdInput = document.createElement("input");
    employeeIdInput.type = "number";
    employeeIdInput.id = "employeeId";
    form.appendChild(employeeIdInput);

    form.appendChild(document.createElement("br")); */

    // Submit button
    var submitButton = document.createElement("button");
    submitButton.textContent = "Submit";
    submitButton.onclick = function () {
        saveNewPackage();
    };
    form.appendChild(submitButton);

    // Clear output and append the form
    output.innerHTML = "";
    output.appendChild(form);
}
function editPackageRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        if (i === 3) {
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
        updatePackageRow(row);
    } else {
        button.textContent = "Update";
    }
}
function updatePackageRow(row) {
    var cells = row.getElementsByTagName("td");
    var rowData = {
        tour_package_id: cells[0].textContent,
        tour_package_name: cells[1].textContent,
        tour_package_description: cells[2].textContent,
        tour_package_status: cells[3].querySelector("select").value,
        tour_package_price: cells[4].textContent
    };

    fetch("../control/update_package_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
        .then(response => response.text())
        .then(data => {
            showPopup(data); // Display the server response in a popup
            viewPackages();
        });
}
function deletePackageRow(button) {
    var row = button.parentElement.parentElement;
    var packageId = row.getElementsByTagName("td")[0].textContent;

    fetch("../control/delete_package.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ tour_package_id: packageId })
    })
        .then(response => response.text())
        .then(data => {
            showPopup(data); // Display the server response in a popup
            row.remove();
            viewPackages();
        });
}
function saveNewPackage() {
    var name = document.getElementById("packageName").value;
    var description = document.getElementById("packageDescription").value;
    var status = document.getElementById("packageStatus").value;
    var price = document.getElementById("packagePrice").value;
    /* var employeeId = document.getElementById("employeeId").value; */

    // Validate input
    if (!name || !description || !status || !price) {
        showPopup("All fields are required.");
        return;
    }

    // Send data to server
    fetch("../control/add_new_package_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: name,
            description: description,
            status: status,
            price: price
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPopup("Package added successfully. Waiting for Admin to approve.");
                addNewPackage();
            } else {
                showPopup("Error adding package: " + data.message);
            }
        })
        .catch(error => {
            showPopup("Error: " + error.message);
        });
}


//Employee profile
function viewEmployeeProfile() {
    fetch("../control/employee_profile_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var profileHtml =
                    "<h2>Employee Profile</h2>" +
                    "<div id='employeeProfile'>" +
                    "<p><strong>Name:</strong> <span id='nameDisplay'>" + data.name + "</span></p>" +
                    "<p><strong>Email:</strong> <span id='emailDisplay'>" + data.email + "</span></p>" +
                    "<p><strong>Phone:</strong> <span id='phoneDisplay'>" + data.phone + "</span></p>" +
                    "<p><strong>Gender:</strong> <span id='genderDisplay'>" + data.gender + "</span></p>" +
                    "<p><strong>Address:</strong> <span id='addressDisplay'>" + data.address + "</span></p>" +
                    "<p><strong>Position:</strong> <span id='positionDisplay'>" + data.position + "</span></p>" +
                    "<button onclick='enableEmployeeEditProfile()'>Edit Profile</button> " +
                    "<button onclick='enableEmployeeChangePassword()'>Change Password</button>" +
                    "</div>" +
                    "<div id='editEmployeeProfile' style='display: none;'>" +
                    "<p><strong>Name:</strong> <input type='text' id='editName' value='" + data.name + "'></p>" +
                    "<p><strong>Email:</strong> <input type='email' disabled id='editEmail' value='" + data.email + "'></p>" +
                    "<p><strong>Phone:</strong> <input type='text' id='editPhone' value='" + data.phone + "'></p>" +
                    "<p><strong>Gender:</strong> <select id='editGender'>" +
                    "<option value='Male'" + (data.gender === 'Male' ? " selected" : "") + ">Male</option>" +
                    "<option value='Female'" + (data.gender === 'Female' ? " selected" : "") + ">Female</option>" +
                    "</select></p>" +
                    "<p><strong>Address:</strong> <input type='text' id='editAddress' value='" + data.address + "'></p>" +

                    "<p><strong>Position:</strong> <input type='text' id='editPosition' disabled value='" + data.position + "'></p>" +

                    "<button onclick='saveEmployeeProfile()'>Save</button>" +
                    "<button onclick='cancelEmployeeEdit()'>Cancel</button>" +
                    "</div>" +
                    "<div id='changeEmployeePasswordSection' style='display: none;'>" +
                    "<h3>Change Password</h3>" +
                    "<p><strong>Current Password:</strong> <input type='password' id='currentPassword'></p>" +
                    "<p><strong>New Password:</strong> <input type='password' id='newPassword'></p>" +
                    "<p><strong>Confirm New Password:</strong> <input type='password' id='confirmNewPassword'></p>" +
                    "<button onclick='saveEmployeeNewPassword()'>Save Password</button>" +
                    "<button onclick='cancelEmployeeChangePassword()'>Cancel</button>" +
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
function enableEmployeeEditProfile() {
    document.getElementById("editEmployeeProfile").style.display = "block";
    document.getElementById("employeeProfile").style.display = "none";
    document.getElementById("changeEmployeePasswordSection").style.display = "none";
}
function enableEmployeeChangePassword() {
    document.getElementById("changeEmployeePasswordSection").style.display = "block";
    document.getElementById("employeeProfile").style.display = "none";
    document.getElementById("editEmployeeProfile").style.display = "none";
}
function cancelEmployeeChangePassword() {
    document.getElementById("changeEmployeePasswordSection").style.display = "none";
    document.getElementById("employeeProfile").style.display = "block";
}
function saveEmployeeNewPassword() {
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

    fetch("../control/employee_change_password_control.php", {
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
                cancelEmployeeChangePassword();
            } else {
                showPopup(data.message || "Error changing password.");
            }
        })
        .catch(error => {
            showPopup("An error occurred while changing the password.");
        });
}
function saveEmployeeProfile() {
    var updatedData = {
        name: document.getElementById("editName").value.trim(),
        phone: document.getElementById("editPhone").value.trim(),
        gender: document.getElementById("editGender").value,
        address: document.getElementById("editAddress").value.trim()
    };

    fetch("../control/update_employee_profile.php", {
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
                viewEmployeeProfile();
            } else {
                showPopup("Failed to update profile.");
            }
        })
        .catch(error => {
            showPopup("An error occurred while updating the profile.");
        });
}
function cancelEmployeeEdit() {
    viewEmployeeProfile();
}

//pop up message
function showPopup(message) {
    document.getElementById("popupMessage").textContent = message;
    document.getElementById("popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}

