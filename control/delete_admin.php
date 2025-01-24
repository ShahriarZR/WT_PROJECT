<?php
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['admin_id'])) {
        $db = new myDB();
        $conn = $db->openCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $admin_id = $conn->real_escape_string($data['admin_id']);

        $sql = "DELETE FROM admin WHERE admin_id = '$admin_id'";

        if ($conn->query($sql) === TRUE) {
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
