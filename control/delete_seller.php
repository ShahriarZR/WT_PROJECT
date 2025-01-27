<?php
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['seller_id'])) {
        $db = new myDB();
        $conn = $db->openCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $seller_id = $conn->real_escape_string($data['seller_id']);

        $sql = "DELETE FROM seller WHERE seller_id = '$seller_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Seller ID $seller_id deleted successfully.";
        } else {
            echo "Error deleting Seller ID $seller_id: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}
?>
