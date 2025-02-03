<?php
session_start();
if (!isset($_SESSION["seller_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
include 'approveAccessories.php'; // Include the service functions

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new sellerDB();
    $conn = $db->openCon();

    $seller_email = $_SESSION["seller_email"];
    $seller_id = $db->getSellerIdByEmail($conn, $seller_email);

    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (is_array($data) && count($data) > 0) {
        foreach ($data as $package) {
            $travel_accessory_id = $conn->real_escape_string($package['travel_accessory_id']);
            $name = $conn->real_escape_string($package['name']);
            $description = $conn->real_escape_string($package['description']);
            $price = $conn->real_escape_string($package['price']);
            $stock = $conn->real_escape_string($package['stock']);

            $result = $db->sellerInsertApproveAccessory($conn, $seller_id, $travel_accessory_id, $name, $description, $price, $stock);

            if ($result) {
                echo "Waiting for Admin to approve";
            } else {
                echo "Error updating Accessory ID $travel_accessory_id: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}
?>
