<?php
session_start();
if (!isset($_SESSION["seller_email"]) ) {
    header("Location: ../../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Seller Panel</title>
    <script src="../js/myjs.js"></script>
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
        <div id="sellerDashboard">
            <button onclick="viewSellerProfile()">Profile</button></li>
            <div><button onclick="viewAccessories()">View Accessories</button></div>
            <div><button onclick="addNewAccessories()">Add New Accessories</button></div>
            <div><a href="../../logout_control.php"><button>Logout</button></a></div>
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