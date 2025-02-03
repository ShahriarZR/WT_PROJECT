<?php
session_start();
if (!isset($_SESSION["seller_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode the incoming JSON data
    $inputData = json_decode(file_get_contents("php://input"), true);

    // Validate input
    if (
        empty($inputData["name"]) || empty($inputData["shopname"]) || empty($inputData["tradelicensenumber"]) || empty($inputData["shopaddress"]) || empty($inputData["shopphone"])
    ) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit();
    }

    $name = trim($inputData["name"]);
    $shop_name = trim($inputData["shopname"]);
    $trade_license_number = trim($inputData["tradelicensenumber"]);
    $shop_address = trim($inputData["shopaddress"]);
    $shop_phone = trim($inputData["shopphone"]);
    $shop_email = $_SESSION["seller_email"];

    // Connect to the database
    $db = new sellerDB();
    $conn = $db->openCon();

    // Call the function to update the seller profile
    $updateResult = $db->updateSellerProfile($conn, $shop_email, $name, $shop_name, $trade_license_number, $shop_address, $shop_phone);

    if ($updateResult) {
        echo json_encode(["success" => true, "message" => "Profile updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error updating profile: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
