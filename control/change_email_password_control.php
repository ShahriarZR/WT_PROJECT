<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

include '../model/mydb.php';
$db = new myDB();
$conn = $db->openCon();

// Get the current admin email from session
$currentEmail = $_SESSION["admin_email"];

// Get JSON input from the request
$data = json_decode(file_get_contents("php://input"), true);

$newEmail = trim($data["email"]);
$newPassword = trim($data["password"]);

// Update email and password in the database
$sql = "UPDATE admin SET email = '$newEmail', password = '$newPassword' WHERE email = '$currentEmail'";
if ($conn->query($sql) === TRUE) {
    // Update the session email if the update is successful
    $_SESSION["admin_email"] = $newEmail;

    echo json_encode(["success" => true, "message" => "Email and password updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update email or password."]);
}

$conn->close();
