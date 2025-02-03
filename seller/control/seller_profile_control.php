<?php
session_start();

if (!isset($_SESSION["seller_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';

$db = new sellerDB();
$conn = $db->openCon();
$email = $_SESSION["seller_email"];

// Call the function to get seller details
$response = $db->getSellerDetails($conn, $email);

echo $response;

$conn->close();
?>
