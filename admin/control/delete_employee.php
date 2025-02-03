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

    if (isset($data['employee_id'])) {
        $db = new adminDB();
        $conn = $db->openCon();

        $employee_id = $conn->real_escape_string($data['employee_id']);

        if ($db->adminDeleteEmployee($conn, $employee_id)) {
            echo "Employee ID $employee_id deleted successfully.";
        } else {
            echo "Error deleting Employee ID $employee_id: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}
?>
