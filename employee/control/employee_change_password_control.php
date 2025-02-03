<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
include 'functions.php'; // Include the function file

$db = new employeeDB();
$conn = $db->openCon();

$currentEmail = $_SESSION["employee_email"];
$data = json_decode(file_get_contents("php://input"), true);

$currentPassword = trim($data["currentPassword"]);
$newPassword = trim($data["newPassword"]);

// Call the function to update the password
$result = $db->updateEmployeePassword($conn, $currentEmail, $currentPassword, $newPassword);

// Output the result as JSON
echo json_encode($result);

$conn->close();
?>
