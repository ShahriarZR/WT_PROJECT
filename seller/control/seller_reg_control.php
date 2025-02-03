<?php
include '../model/mydb.php';

$name = $_POST["name"];
$email = $_POST["email"];
$shopName = $_POST["shopName"];
$tradeLicenseNumber = $_POST["tradeLicenseNumber"];
$shopAddress = $_POST["address"];
$phone = $_POST["phone"];
$password = $_POST["password"];
$conf_password = $_POST["conf_password"];

$db = new sellerDB();
$conn = $db->openCon();

// Check if email is already registered
$emailCheckResult = $db->checkSellerEmailExists($conn, $email);

// Send response back as JSON if email exists
if ($emailCheckResult->num_rows > 0) {
    echo "Email Already Registered";
} else {
    // Register the new seller
    $result = $db->registerNewSeller($conn, $name, $email, $shopName, $tradeLicenseNumber, $shopAddress, $password, $phone);

    if ($result) {
        header("Location: ../../login.php"); // Redirect to login page after successful registration
    } else {
        echo "Error: Unable to register user.";
    }
}

// Close the connection
$conn->close();
?>
