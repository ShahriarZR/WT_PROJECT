<?php
session_start();
if (!isset($_SESSION["seller_email"]) ) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['travel_accessory_id'])) {
        $db = new sellerDB();
        $conn = $db->openCon();

        $travel_accessory_id = $conn->real_escape_string($data['travel_accessory_id']);

        $message = $db->sellerDeleteAccessory($conn, $travel_accessory_id);
        echo $message;

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}

?>
