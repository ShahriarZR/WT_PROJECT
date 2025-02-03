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

if (isset($input['tour_package_id'])) {
    $tour_package_id = $conn->real_escape_string($input['tour_package_id']);

    // Call the function to delete the package and get the result
    $result = $db->deleteTourPackage($conn, $tour_package_id);

    // Output the result as JSON
    echo json_encode($result);
} else {
    echo json_encode(["success" => false, "message" => "Invalid data received."]);
}

$conn->close();
?>
