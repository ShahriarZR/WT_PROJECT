<?php
include '../model/mydb.php';
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
$conf_password = $_POST["conf_password"];
$address = $_POST["address"];

if (strlen($name) >= 4) {
    if (preg_match("/aiub.edu\b/", $email) ) {
        if (isset($gender)) {
            if (is_numeric($phone)) {
                echo "Welcome " . $name . "<br>";
                $db = new myDB();
                $conn = $db->openCon();
                $result = $db->newUser($conn,  $name, $email, $password,$phone, $gender, $address);
                echo $result;
                $conn->close();
                /* header("LOCATION: ../lab1/index.php"); */ //to redirect to any other page
            } else {
                echo "Phone number must be numeric";
            }
        } else {
            echo "Please select a gender";
        }

    } else {
        echo "Email must contain aiub.edu domain";
    }

} else {
    echo "Both first name and last name should contain at least 4 characters";
}