<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    include '../model/mydb.php';
    $db = new myDB();
    $conn = $db->openCon();
    $sql = "SELECT * FROM temp_employee where email = '$email'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        $_SESSION["employee_email"] = $employee["email"];
        header("LOCATION: ../view/employee_reg.php"); 
    } else {
        echo "Wrong Email";
    }
}
?>