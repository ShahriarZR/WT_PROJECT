<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
$db = new adminDB();
$conn = $db->openCon();

$currentEmail = $_SESSION["admin_email"];
$data = json_decode(file_get_contents("php://input"), true);

$currentPassword = trim($data["currentPassword"]);
$newPassword = trim($data["newPassword"]);

if (!$db->checkAdminPassword($conn, $currentEmail, $currentPassword)) {
    echo json_encode(["success" => false, "message" => "Current password is incorrect."]);
    exit();
}

if ($db->changeAdminPassword($conn, $currentEmail, $newPassword)) {
    echo json_encode(["success" => true, "message" => "Password updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update password."]);
}

$conn->close();

?>