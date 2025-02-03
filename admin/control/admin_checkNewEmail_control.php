<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    include '../model/mydb.php';
    $db = new adminDB();
    $conn = $db->openCon();
    $result = $db->getTempAdmin($conn, $email);
    if ($result && $result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        $_SESSION["admin_email"] = $employee["email"];
        header("LOCATION: ../view/admin_reg.php"); 
    } else {
        echo "Wrong Email";
    }
}
?>