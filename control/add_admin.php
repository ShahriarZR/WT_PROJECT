<?php
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['name'], $data['email'], $data['password'], $data['phone'], $data['gender'], $data['address'])) {
        $db = new myDB();
        $conn = $db->openCon();

        $name = $conn->real_escape_string($data['name']);
        $email = $conn->real_escape_string($data['email']);
        $password = $conn->real_escape_string($data['password']);
        $phone = $conn->real_escape_string($data['phone']);
        $gender = $conn->real_escape_string($data['gender']);
        $address = $conn->real_escape_string($data['address']);

        $sql = "INSERT INTO admin (name, email, password, phone, gender, address) VALUES ('$name', '$email', '$password', '$phone', '$gender', '$address')";

        if ($conn->query($sql) === TRUE) {
            echo "New admin added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid input data.";
    }
}
?>
