<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: employee_login.php");
    exit();
}
include '../model/mydb.php';
$name = $_POST["name"];
$email = $_SESSION["employee_email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
$conf_password = $_POST["conf_password"];
$address = $_POST["address"];
$db = new myDB();
$conn = $db->openCon();

$sql = "INSERT INTO employee(name, email, password, phone, gender, address) VALUES ('$name','$email','$password','$phone','$gender','$address')";
$result = $conn->query($sql);
if ($result) {
    $sqlDel = "DELETE FROM temp_employee where email ='$email'";
    if ($conn->query($sqlDel)) {
        $_SESSION["employee_name"] = $name;
        header("LOCATION: ../view/employee_panel.php");
    }
} else {
    echo "Error: Unable to register employee.";
}
// Close the connection
$stmt->close();
$conn->close();
?>