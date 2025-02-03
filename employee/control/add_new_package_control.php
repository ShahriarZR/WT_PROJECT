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

header('Content-Type: application/json');

// Get input from the request
$input = json_decode(file_get_contents("php://input"), true);
$employee_email = $_SESSION["employee_email"];

// Call the function to add a new package and get the result
$result = $db->employeeAddNewPackage($conn, $input['name'], $input['description'], $input['status'], $input['price'], $employee_email);

// Output the result as JSON
echo json_encode($result);

$conn->close();
?>
