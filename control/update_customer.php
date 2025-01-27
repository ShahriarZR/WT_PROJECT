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

    if (is_array($data) && count($data) > 0) {
        $db = new myDB();
        $conn = $db->openCon();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        foreach ($data as $customer) {
            $customer_id = $conn->real_escape_string($customer['customer_id']);
            $name = $conn->real_escape_string($customer['name']);
            $email = $conn->real_escape_string($customer['email']);
            $password = $conn->real_escape_string($customer['password']);
            $phone = $conn->real_escape_string($customer['phone']);
            $gender = $conn->real_escape_string($customer['gender']);
            $address = $conn->real_escape_string($customer['address']);

            $sql = "UPDATE customer SET 
                        name = '$name', 
                        email = '$email',
                        phone = '$phone', 
                        password = '$password',
                        gender = '$gender', 
                        address = '$address' 
                    WHERE customer_id = '$customer_id'";

            if ($conn->query($sql) === TRUE) {
                echo "Customer ID $customer_id updated successfully.";
            } else {
                echo "Error updating admin ID $customer_id: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}