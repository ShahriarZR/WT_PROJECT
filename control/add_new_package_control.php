<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: employee_login.php");
    exit();
}
include '../model/mydb.php';

$db = new myDB();
$conn = $db->openCon();

header('Content-Type: application/json');

// Get input from the request
$input = json_decode(file_get_contents("php://input"), true);
$name = $conn->real_escape_string($input['name']);
$description = $conn->real_escape_string($input['description']);
$status = $conn->real_escape_string($input['status']);
$price = $conn->real_escape_string($input['price']);
/* $mail = $conn->real_escape_string($input['email']); */
$employee_email = $conn->real_escape_string($_SESSION["employee_email"]);

$sqlEmail = "SELECT employee_id FROM employee WHERE email = '$employee_email'";

$result = $conn->query($sqlEmail);
$row = $result->fetch_assoc();
$employee_id = $row["employee_id"];

// Insert data into the database
$sql = "INSERT INTO approve_tour_package (employee_id, name, description, status, price) VALUES ('$employee_id', '$name', '$description', '$status', '$price')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
?>
