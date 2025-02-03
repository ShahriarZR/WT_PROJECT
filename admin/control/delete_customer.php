<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
include 'functions.php'; // Ensure this file contains the function

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['customer_id'])) {
        $db = new adminDB();
        $conn = $db->openCon();

        $customer_id = $conn->real_escape_string($data['customer_id']);

        if ($db->adminDeleteCustomer($conn, $customer_id)) {
            echo "Customer ID $customer_id deleted successfully.";
        } else {
            echo "Error deleting customer ID $customer_id: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}
?>
