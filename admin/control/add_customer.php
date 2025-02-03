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

    if (isset($data['name'], $data['email'], $data['password'], $data['phone'], $data['gender'], $data['address'])) {
        $db = new adminDB();
        $conn = $db->openCon();

        $name = $conn->real_escape_string($data['name']);
        $email = $conn->real_escape_string($data['email']);
        $dob = $conn->real_escape_string($data['dob']);
        $gender = $conn->real_escape_string($data['gender']);
        $address = $conn->real_escape_string($data['address']);
        $password = $conn->real_escape_string($data['password']);
        $phone = $conn->real_escape_string($data['phone']);
        $image_name = basename($_FILES['c_image']['name']);

        if (isset($_FILES['c_image']) && $_FILES['c_image']['error'] == 0) {
            $target_dir = "admin/resources/";

            $target_file = $target_dir . $image_name;
            if (move_uploaded_file($_FILES['c_image']['tmp_name'], $target_file)) {
                $c_image = $image_name;
            } else {
                echo "Error uploading image.";
                exit();
            }
        } else {
            $c_image = $conn->real_escape_string($data['c_image']);
        }

        $result = $db->adminAddCustomer($conn, $name, $email, $dob, $password, $phone, $gender, $address, $c_image);

        if ($result === TRUE) {
            echo "New Customer added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid input data.";
    }
}
?>
