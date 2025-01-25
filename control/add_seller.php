<?php
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (isset($data['name'], $data['email'], $data['shop_name'], $data['address'], $data['password'], $data['phone'])) {
        $db = new myDB();
        $conn = $db->openCon();

        $name = $conn->real_escape_string($data['name']);
        $email = $conn->real_escape_string($data['email']);
        $shop_name = $conn->real_escape_string($data['shop_name']);
        $address = $conn->real_escape_string($data['address']);
        $password = $conn->real_escape_string($data['password']);
        $phone = $conn->real_escape_string($data['phone']);

        $sql = "INSERT INTO seller (name, email, shop_name, address, password, phone) VALUES ('$name', '$email', '$shop_name', '$address', '$password', '$phone')";

        if ($conn->query($sql) === TRUE) {
            echo "New Seller added successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid input data.";
    }
}
?>
