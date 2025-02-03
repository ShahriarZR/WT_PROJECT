<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

$db = new adminDB();
$conn = $db->openCon();

header('Content-Type: application/json');

// Get input from the request
$input = json_decode(file_get_contents("php://input"), true);
$email = $conn->real_escape_string($input['email']);


$result = $db->tempAdmin($conn, $email);
if ($result === TRUE) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
}

$conn->close();
?>
