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
        /* if(availableEmail()==false)
        {
            return false;
        } */
        return false;
    }
}

//Seller Js
function validateSellerForm() {
    if (validateName() == false || validateEmail() == false || validatePhone() == false || validatePassword() == false || validateConfPassword() == false) {
        /* if(availableEmail()==false)
        {
            return false;
        } */
        return false;
    }
}
//Manage Accessories
function viewAccessories(searchName = "") {
    fetch("../control/view_accessories_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ name: searchName })
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                var table = "<table border='1' id='accessoriesTable'><tr><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Stock</th><th>Actions</th></tr>";
                data.forEach(function (row) {
                    table += "<tr>" +
                        "<td>" + row.travel_accessory_id + "</td>" +
                        "<td contenteditable='false'>" + row.name + "</td>" +
                        "<td contenteditable='false'>" + row.description + "</td>" +
                        "<td contenteditable='false'>" + row.price + "</td>" +
                        "<td contenteditable='false'>" + row.stock + "</td>" +
                        "<td><button onclick='editAccessoriesRow(this)'>Edit</button><button onclick='deleteAccessoriesRow(this)'>Delete</button></td>" +
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
function addNewAccessories() {
    var output = document.getElementById("output");
    var form = document.createElement("div");
    form.id = "newAccessoriesForm";

    var heading = document.createElement("h3");
    heading.textContent = "Add New Accessory";
    form.appendChild(heading);

    // Name input
    var nameLabel = document.createElement("label");
    nameLabel.textContent = "Name:";
    form.appendChild(nameLabel);

    var nameInput = document.createElement("input");
    nameInput.type = "text";
    nameInput.id = "accessoriesName";
    form.appendChild(nameInput);

    form.appendChild(document.createElement("br"));

    // Description input
    var descriptionLabel = document.createElement("label");
    descriptionLabel.textContent = "Description:";
    form.appendChild(descriptionLabel);

    var descriptionInput = document.createElement("textarea");
    descriptionInput.id = "accessoriesDescription";
    form.appendChild(descriptionInput);

    form.appendChild(document.createElement("br"));


    // Price input
    var priceLabel = document.createElement("label");
    priceLabel.textContent = "Price:";
    form.appendChild(priceLabel);

    var priceInput = document.createElement("input");
    priceInput.type = "number";
    priceInput.id = "accessoriesPrice";
    form.appendChild(priceInput);

    form.appendChild(document.createElement("br"));

    // Stock input
    var priceLabel = document.createElement("label");
    priceLabel.textContent = "Stock:";
    form.appendChild(priceLabel);

    var priceInput = document.createElement("input");
    priceInput.type = "number";
    priceInput.id = "accessoriesStock";
    form.appendChild(priceInput);

    form.appendChild(document.createElement("br"));


    // Submit button
    var submitButton = document.createElement("button");
    submitButton.textContent = "Submit";
    submitButton.onclick = function () {
        saveNewAccessories();
    };
    form.appendChild(submitButton);

    // Clear output and append the form
    output.innerHTML = "";
    output.appendChild(form);
}
function editAccessoriesRow(button) {
    var row = button.parentElement.parentElement;
    var cells = row.getElementsByTagName("td");
    var isEditable = cells[1].contentEditable === "true";

    for (var i = 1; i < cells.length - 1; i++) { // Skip Serial and Actions column
        cells[i].contentEditable = !isEditable;
    }

    if (isEditable) {
        button.textContent = "Edit";
        updateAccessoriesRow(row);
    } else {
        button.textContent = "Update";
    }
}
function updateAccessoriesRow(row) {
    var cells = row.getElementsByTagName("td");
    var rowData = {
        travel_accessory_id: cells[0].textContent,
        name: cells[1].textContent,
        description: cells[2].textContent,
        price: cells[3].textContent,
        stock: cells[4].textContent
    };

    fetch("../control/update_accessories_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify([rowData])
    })
        .then(response => response.text())
        .then(data => {
            showPopup(data); // Display the server response in a popup
            viewAccessories();
        });
}
function deleteAccessoriesRow(button) {
    var row = button.parentElement.parentElement;
    var accessoryId = row.getElementsByTagName("td")[0].textContent;

    fetch("../control/delete_accessories.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ travel_accessory_id: accessoryId })
    })
        .then(response => response.text())
        .then(data => {
            showPopup(data); // Display the server response in a popup
            row.remove();
            viewPackages();
        });
}
function saveNewAccessories() {
    var name = document.getElementById("accessoriesName").value;
    var description = document.getElementById("accessoriesDescription").value;
    var price = document.getElementById("accessoriesPrice").value;
    var stock = document.getElementById("accessoriesStock").value;

    // Validate input
    if (!name || !description || !price || !stock) {
        showPopup("All fields are required.");
        return;
    }

    // Send data to server
    fetch("../control/add_new_accessories_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            name: name,
            description: description,
            price: price,
            stock: stock
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showPopup("Accessory added successfully. Waiting for Admin to approve.");
                addNewAccessories();
            } else {
                showPopup("Error adding new accessory: " + data.message);
            }
        })
        .catch(error => {
            showPopup("Error: " + error.message);
        });
}

//Seller profile
function viewSellerProfile() {
    fetch("../control/seller_profile_control.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                var profileHtml =
                    "<h2>Seller Profile</h2>" +
                    "<div id='sellerProfile'>" +
                    "<p><strong>Name:</strong> <span id='nameDisplay'>" + data.name + "</span></p>" +
                    "<p><strong>Shop Email:</strong> <span id='emailDisplay'>" + data.shop_email + "</span></p>" +
                    "<p><strong>Shop Name:</strong> <span id='phoneDisplay'>" + data.shop_name + "</span></p>" +
                    "<p><strong>Trade License Number:</strong> <span id='genderDisplay'>" + data.trade_license_number + "</span></p>" +
                    "<p><strong>Shop Address:</strong> <span id='addressDisplay'>" + data.shop_address + "</span></p>" +
                    "<p><strong>Shop Contact Number:</strong> <span id='positionDisplay'>" + data.shop_phone + "</span></p>" +
                    "<button onclick='enableSellerEditProfile()'>Edit Profile</button> " +
                    "<button onclick='enableSellerChangePassword()'>Change Password</button>" +
                    "</div>" +
                    "<div id='editSellerProfile' style='display: none;'>" +
                    "<p><strong>Name:</strong> <input type='text' id='editSellerName' value='" + data.name + "'></p>" +
                    "<p><strong>Shop Email:</strong> <input type='email' disabled id='editSellerEmail' value='" + data.shop_email + "'></p>" +

                    "<p><strong>Shop Name:</strong> <input type='text' id='editSellerShopName' value='" + data.shop_name + "'></p>" +

                    "<p><strong>Tarde License Number:</strong> <input type='text' id='editTradeLicenseNumber' value='" + data.trade_license_number + "'></p>" +

                    "<p><strong>Shop Address:</strong> <input type='text' id='editShopAddress' value='" + data.shop_address + "'></p>" +

                    "<p><strong>Shop Contact Number:</strong> <input type='text' id='editShopPhone' value='" + data.shop_phone + "'></p>" +

                    "<button onclick='saveSellerProfile()'>Save</button>" +
                    "<button onclick='cancelSellerEdit()'>Cancel</button>" +
                    "</div>" +
                    "<div id='changeSellerPasswordSection' style='display: none;'>" +
                    "<h3>Change Password</h3>" +
                    "<p><strong>Current Password:</strong> <input type='password' id='currentPassword'></p>" +
                    "<p><strong>New Password:</strong> <input type='password' id='newPassword'></p>" +
                    "<p><strong>Confirm New Password:</strong> <input type='password' id='confirmNewPassword'></p>" +
                    "<button onclick='saveSellerNewPassword()'>Save Password</button>" +
                    "<button onclick='cancelSellerChangePassword()'>Cancel</button>" +
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
function enableSellerEditProfile() {
    document.getElementById("editSellerProfile").style.display = "block";
    document.getElementById("sellerProfile").style.display = "none";
    document.getElementById("changeSellerPasswordSection").style.display = "none";
}
function enableSellerChangePassword() {
    document.getElementById("changeSellerPasswordSection").style.display = "block";
    document.getElementById("sellerProfile").style.display = "none";
    document.getElementById("editSellerProfile").style.display = "none";
}
function cancelSellerChangePassword() {
    document.getElementById("changeSellerPasswordSection").style.display = "none";
    document.getElementById("sellerProfile").style.display = "block";
}
function saveSellerNewPassword() {
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

    fetch("../control/seller_change_password_control.php", {
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
                cancelSellerChangePassword();
            } else {
                showPopup(data.message || "Error changing password.");
            }
        })
        .catch(error => {
            showPopup("An error occurred while changing the password.");
        });
}
function saveSellerProfile() {
    //showPopup("I am here");
    var updatedData = {
        name: document.getElementById("editSellerName").value.trim(),
        shopname: document.getElementById("editSellerShopName").value.trim(),
        tradelicensenumber: document.getElementById("editTradeLicenseNumber").value.trim(),
        shopaddress: document.getElementById("editShopAddress").value.trim(),
        shopphone: document.getElementById("editShopPhone").value.trim()
    };

    fetch("../control/update_seller_profile.php", {
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
                viewSellerProfile();
            } else {
                showPopup("Failed to update profile.");
            }
        })
        .catch(error => {
            showPopup("An error occurred while updating the profile.");
        });
}
function cancelSellerEdit() {
    viewSellerProfile();
}


//pop up message
function showPopup(message) {
    document.getElementById("popupMessage").textContent = message;
    document.getElementById("popup").style.display = "flex";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
}

