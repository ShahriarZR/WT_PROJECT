<?php
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['name'], $data['email'], $data['password'], $data['phone'], $data['gender'], $data['address'], $data['position'])) {
        $db = new myDB();
        $conn = $db->openCon();

        $name = $conn->real_escape_string($data['name']);
        $email = $conn->real_escape_string($data['email']);
        $password = $conn->real_escape_string($data['password']);
        $phone = $conn->real_escape_string($data['phone']);
        $gender = $conn->real_escape_string($data['gender']);
        $address = $conn->real_escape_string($data['address']);
        $position = $conn->real_escape_string($data['position']);

        $sql = "INSERT INTO employee (name, email, password, phone, gender, address, position) VALUES ('$name', '$email', '$password', '$phone', '$gender', '$address', '$position')";

        if ($conn->query($sql) === TRUE) {
            echo "New Employee added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid input data.";
    }
}
?>
