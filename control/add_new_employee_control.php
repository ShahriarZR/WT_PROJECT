<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: admin_login.php");
    exit();
}
include '../model/mydb.php';

$db = new myDB();
$conn = $db->openCon();

header('Content-Type: application/json');

// Get input from the request
$input = json_decode(file_get_contents("php://input"), true);
$email = $conn->real_escape_string($input['email']);


$sql = "INSERT INTO temp_employee (email) VALUES ('$email')";
if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
?>
