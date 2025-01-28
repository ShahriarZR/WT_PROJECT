<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: employee_login.php");
    exit();
}

include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode the incoming JSON data
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Validate input
    if (
        empty($inputData["name"]) ||
        empty($inputData["phone"]) ||
        empty($inputData["gender"]) ||
        empty($inputData["address"])
    ) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    $name = trim($inputData["name"]);
    $phone = trim($inputData["phone"]);
    $gender = trim($inputData["gender"]);
    $address = trim($inputData["address"]);
    $email = $_SESSION["employee_email"];

    // Connect to the database
    $db = new myDB();
    $conn = $db->openCon();

    // Update the admin's profile in the database
    $sql = "UPDATE employee SET name = '$name', phone = '$phone', gender = '$gender', address = '$address' WHERE email = '$email'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating profile: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
