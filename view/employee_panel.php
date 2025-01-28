<?php
session_start();
if (!isset($_SESSION["employee_name"]) ) {
    header("Location: employee_reg.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Employee Panel</title>
    <script src="../js/myjs.js"></script>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <header>
        <div id="employeeDashboard">
            <button onclick="viewEmployeeProfile()">Profile</button></li>
            <div><button onclick="viewPackages()">View Packages</button></div>
            <div><button onclick="addNewPackage()">Add New Package</button></div>
            <div><a href="../control/logout_control.php"><button>Logout</button></a></div>
        </div>

        <div id="output"></div>
        <div id="successMessage"></div>
        <div id="errorMessage"></div>

        <div id="popup" style="display: none;">
            <div id="popupContent">
                <p id="popupMessage"></p>
                <button onclick="closePopup()">OK</button>
            </div>
        </div>
</body>

</html>