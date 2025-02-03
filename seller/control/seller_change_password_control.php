<?php
session_start();
if (!isset($_SESSION["seller_email"]) ) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
$db = new sellerDB();
$conn = $db->openCon();
$currentEmail = $_SESSION["seller_email"];
$data = json_decode(file_get_contents("php://input"), true);

$currentPassword = trim($data["currentPassword"]);
$newPassword = trim($data["newPassword"]);

$response = $db->updateSellerPassword($conn, $currentEmail, $currentPassword, $newPassword);
echo $response;

$conn->close();
?>