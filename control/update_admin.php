<?php
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (is_array($data) && count($data) > 0) {
        $db = new myDB();
        $conn = $db->openCon();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        foreach ($data as $admin) {
            $admin_id = $conn->real_escape_string($admin['admin_id']);
            $name = $conn->real_escape_string($admin['name']);
            $email = $conn->real_escape_string($admin['email']);
            $phone = $conn->real_escape_string($admin['phone']);
            $gender = $conn->real_escape_string($admin['gender']);
            $address = $conn->real_escape_string($admin['address']);

            $sql = "UPDATE admin SET 
                        name = '$name', 
                        email = '$email',
                        phone = '$phone', 
                        gender = '$gender', 
                        address = '$address' 
                    WHERE admin_id = '$admin_id'";

            if ($conn->query($sql) === TRUE) {
                echo "Admin ID $admin_id updated successfully.";
            } else {
                echo "Error updating admin ID $admin_id: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}