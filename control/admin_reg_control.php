<?php
include '../model/mydb.php';
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
$conf_password = $_POST["conf_password"];
$address = $_POST["address"];


$db = new myDB();
$conn = $db->openCon();
$result = $db->newUser($conn,  $name, $email, $password,$phone, $gender, $address);
echo $result;
$conn->close();
header("LOCATION: ../view/admin_login.php"); 
            
