<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['name'], $data['email'], $data['shop_name'], $data['address'], $data['password'], $data['phone'])) {
        $db = new adminDB();
        $conn = $db->openCon();

        $name = $conn->real_escape_string($data['name']);
        $email = $conn->real_escape_string($data['email']);
        $shop_name = $conn->real_escape_string($data['shop_name']);
        $address = $conn->real_escape_string($data['address']);
        $password = $conn->real_escape_string($data['password']);
        $phone = $conn->real_escape_string($data['phone']);

        $result = $db->adminAddSeller($conn, $name, $email, $shop_name, $address, $password, $phone);
        if ($result === TRUE) {
            echo "New Seller added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid input data.";
    }
}
?>
