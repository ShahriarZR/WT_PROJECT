<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <script src="../js/myjs.js"></script>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <header>
        <h3>Admin: <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>!</h3>
        <ul id="panel">
            <li><button onclick="viewProfile()">Profile</button></li>
            <li onmouseover="dashboard()" onmouseout="dashboard()">
                <button>Dashboard</button>
                <div id="adminDashboard">
                    <div><button onclick="manageAdmin()">Manage Admin</button></div>
                    <div><button onclick="manageCustomer()">Manage Customer</button></div>
                    <div><button onclick="manageEmployee()">Manage Employee</button></div>
                    <div><button onclick="manageSeller()">Manage Seller</button></div>
                </div>
            </li>
            <li><button onclick="travelAccessories()">Travel Accessories</button>
                <ul id="travelAccessories">
                    <li><button onclick="viewAllAccessories()">View All Accessories</button></li>
                    <li><button onclick="approveNewAccessories()">Approve New Accessories</button></li>
                </ul>
            </li>
            <li><button onclick="tourPackages()">Packages</button>
                <ul id="tourPackages">
                    <li><button onclick="viewAllPackages()">View All PAckages</button></li>
                    <li><button onclick="approveNewPackages()">Approve New Packages</button></li>
                </ul>
            </li>
            <li><a href="../control/logout_control.php"><button>Logout</button></a></li>
        </ul>
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
    <div id="successMessage"></div>
    <div id="errorMessage"></div>

    <!-- <div id="addEmployee" style="display:none;">
        <input type="email" id="addEmployeeEmail" placeholder="Enter email to add" />
        <button onclick="addEmployeeRow()">Add Email</button>
    </div> -->

    <!-- Pop up message -->
    <div id="popup" style="display: none;">
        <div id="popupContent">
            <p id="popupMessage"></p>
            <button onclick="closePopup()">OK</button>
        </div>
    </div>
</body>

</html>