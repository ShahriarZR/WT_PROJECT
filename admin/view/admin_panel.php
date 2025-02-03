<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <script src="../js/myjs.js"></script>
    <link rel="stylesheet" href="../../admin/style/style.css">
</head>

<body>
    <header>

        <div id="panel">
            <div><button onclick="viewProfile()">Profile</button></div>
            <div onmouseover="dashboard()" onmouseout="dashboard()">
                <button>Dashboard</button>
                <div id="adminDashboard">
                    <div><button onclick="manageAdmin()">Manage Admin</button></div>
                    <div><button onclick="manageCustomer()">Manage Customer</button></div>
                    <div><button onclick="manageEmployee()">Manage Employee</button></div>
                    <div><button onclick="manageSeller()">Manage Seller</button></div>
                </div>
            </div>
            <div onmouseover="travelAccessories()" onmouseout="travelAccessories()">
                <button>Travel Accessories</button>
                <div id="travelAccessories">
                    <div><button onclick="viewAllAccessories()">View All Accessories</button></div>
                    <div><button onclick="approveNewAccessories()">Approve New Accessories</button></div>
                </div>
            </div>
            <div onmouseover="tourPackages()" onmouseout="tourPackages()">
                <button>Packages</button>
                <div id="tourPackages">
                    <div><button onclick="viewAllPackages()">View All Packages</button></div>
                    <div><button onclick="approveNewPackages()">Approve New Packages</button></div>
                </div>
            </div>
            <div><a href="../../logout_control.php"><button>Logout</button></a></div>
        </div>
    </header>

    <div id="adminSearch">
        <input type="text" id="searchEmail" placeholder="Enter email to search" />
        <button onclick="searchAdminEmail()">Search</button>
    </div>
    <div id="customerSearch">
        <input type="text" id="searchCustomerEmail" placeholder="Enter email to search" />
        <button onclick="searchCustomerByEmail()">Search</button>
    </div>
    <div id="employeeSearch">
        <input type="text" id="searchEmployeeEmail" placeholder="Enter email to search" />
        <button onclick="searchEmployeeByEmail()">Search</button>
    </div>
    <div id="sellerSearch">
        <input type="text" id="searchSellerEmail" placeholder="Enter email to search" />
        <button onclick="searchSellerByEmail()">Search</button>
    </div>

    <div id="output"></div>
    <div id="employeeAdd"></div>
    <div id="adminAdd"></div>
    <div id="successMessage"></div>
    <div id="errorMessage"></div>

    <!-- Pop up message -->
    <div id="popup" style="display: none;">
        <div id="popupContent">
            <p id="popupMessage"></p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>
</body>

</html>