<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
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
    $email = trim($inputData["email"]);
    $phone = trim($inputData["phone"]);
    $gender = trim($inputData["gender"]);
    $address = trim($inputData["address"]);

    // Connect to the database
    $db = new myDB();
    $conn = $db->openCon();
    $currentEmail = $_SESSION["admin_email"];

    // Update the admin's profile in the database
    $sql = "UPDATE admin SET name = '$name', email ='$email', phone = '$phone', gender = '$gender', address = '$address' WHERE email = '$currentEmail'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["admin_email"] = $email;
        echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating profile: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
