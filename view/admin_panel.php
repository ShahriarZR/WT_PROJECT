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
</head>

<body>
    <h1>Admin: <?php echo htmlspecialchars($_SESSION["admin_name"]); ?>!</h1>
    <ul style="list-style-type:none;">
        <li><button onclick="dashboard()">Dashboard</button>
            <ul id="adminDashboard" style="list-style-type:none; display:none;">
                <li><button onclick="manageAdmin()">Manage Admin</button></li>
                <li><button onclick="manageCustomer()">Manage Customer</button></li>
                <li><button onclick="manageEmployee()">Manage Employee</button></li>
                <li><button onclick="manageSeller()">Manage Seller</button></li>
            </ul>
        </li>
        <li><button onclick="travelAccessories()">Travel Accessories</button>
            <ul id="travelAccessories" style="list-style-type:none; display:none;">
                <li><button onclick="viewAllAccessories()">View All Accessories</button></li>
                <li><button onclick="approveNewAccessories()">Approve New Accessories</button></li>
            </ul>
        </li>
        <li><button onclick="tourPackages()">Packages</button>
            <ul id="tourPackages" style="list-style-type:none; display:none;">
                <li><button onclick="viewAllPackages()">View All PAckages</button></li>
                <li><button onclick="approveNewPackages()">Approve New Packages</button></li>
            </ul>
        </li>
        <li><a href="../control/logout_control.php"><button>Logout</button></a></li>
    </ul>
    <div id="adminSearch" style="display:none;">
        <input type="text" id="searchEmail" placeholder="Enter email to search" />
        <button onclick="searchAdminEmail()">Search</button>
    </div>
    <div id="customerSearch" style="display:none;">
        <input type="text" id="searchCustomerEmail" placeholder="Enter email to search" />
        <button onclick="searchCustomerByEmail()">Search</button>
    </div>
    <div id="employeeSearch" style="display:none;">
        <input type="text" id="searchEmployeeEmail" placeholder="Enter email to search" />
        <button onclick="searchEmployeeByEmail()">Search</button>
    </div>
    <div id="sellerSearch" style="display:none;">
        <input type="text" id="searchSellerEmail" placeholder="Enter email to search" />
        <button onclick="searchSellerByEmail()">Search</button>
    </div>

    <div id="output"></div>
    <div id="errorMessage"></div>
</body>

</html>