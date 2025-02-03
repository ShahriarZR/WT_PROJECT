<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
$db = new adminDB();
$conn = $db->openCon();

$email = $_SESSION["admin_email"];
$adminData = $db->adminProfileControl($conn, $email);

if ($adminData) {
    echo json_encode(array_merge(["success" => true], $adminData));
} else {
    echo json_encode(["success" => false, "message" => "Admin not found."]);
}

$conn->close();

?>
