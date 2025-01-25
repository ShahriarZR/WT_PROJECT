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

        foreach ($data as $employee) {
            $seller_id = $conn->real_escape_string($employee['seller_id']);
            $name = $conn->real_escape_string($employee['name']);
            $email = $conn->real_escape_string($employee['email']);
            $shop_name = $conn->real_escape_string($employee['shop_name']);
            $address = $conn->real_escape_string($employee['address']);
            $password = $conn->real_escape_string($employee['password']);
            $phone = $conn->real_escape_string($employee['phone']);

            $sql = "UPDATE employee SET 
                        name = '$name', 
                        email = '$email',
                        shop_name = '$shop_name', 
                        address = '$address',
                        password = '$password', 
                        phone = '$phone'
                    WHERE seller_id = '$seller_id'";

            if ($conn->query($sql) === TRUE) {
                echo "Seller ID $seller_id updated successfully.";
            } else {
                echo "Error updating Seller ID $seller_id: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}