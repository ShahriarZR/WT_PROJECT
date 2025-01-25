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
            $employee_id = $conn->real_escape_string($employee['employee_id']);
            $name = $conn->real_escape_string($employee['name']);
            $email = $conn->real_escape_string($employee['email']);
            $password = $conn->real_escape_string($employee['password']);
            $phone = $conn->real_escape_string($employee['phone']);
            $gender = $conn->real_escape_string($employee['gender']);
            $address = $conn->real_escape_string($employee['address']);
            $position = $conn->real_escape_string($employee['position']);

            $sql = "UPDATE employee SET 
                        name = '$name', 
                        email = '$email',
                        phone = '$phone', 
                        password = '$password',
                        gender = '$gender', 
                        address = '$address',
                        position = '$position'
                    WHERE employee_id = '$employee_id'";

            if ($conn->query($sql) === TRUE) {
                echo "Employee ID $employee_id updated successfully.";
            } else {
                echo "Error updating employee ID $employee_id: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}