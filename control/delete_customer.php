<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: admin_login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['customer_id'])) {
        $db = new myDB();
        $conn = $db->openCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $customer_id = $conn->real_escape_string($data['customer_id']);

        $sql = "DELETE FROM customer WHERE customer_id = '$customer_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Customer ID $customer_id deleted successfully.";
        } else {
            echo "Error deleting admin ID $customer_id: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}
?>
