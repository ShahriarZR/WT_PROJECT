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

    if (isset($data['admin_id'])) {
        $db = new adminDB();
        $conn = $db->openCon();


        $admin_id = $conn->real_escape_string($data['admin_id']);
        $result=$db->deleteAdmin($conn, $admin_id);
        
        if ($result === TRUE) {
            echo "Admin ID $admin_id deleted successfully.";
        } else {
            echo "Error deleting admin ID $admin_id: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}
?>
