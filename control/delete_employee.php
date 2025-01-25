<?php
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['employee_id'])) {
        $db = new myDB();
        $conn = $db->openCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $employee_id = $conn->real_escape_string($data['employee_id']);

        $sql = "DELETE FROM customer WHERE employee_id = '$employee_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Employee ID $employee_id deleted successfully.";
        } else {
            echo "Error deleting admin ID $employee_id: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid data received.";
    }
}
?>
