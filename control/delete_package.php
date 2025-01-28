<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: employee_login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['tour_package_id'])) {
        $db = new myDB();
        $conn = $db->openCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $tour_package_id = $conn->real_escape_string($data['tour_package_id']);

        $sql = "DELETE FROM tour_package WHERE tour_package_id = '$tour_package_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Package ID $tour_package_id deleted successfully.";
        } else {
            echo "Error deleting Package ID $tour_package_id: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}
?>
