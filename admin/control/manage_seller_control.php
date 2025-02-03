<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    $email = isset($data['email']) ? $data['email'] : '';

    $db = new adminDB();
    $conn = $db->openCon();

    if (!empty($email)) {
        $email = $conn->real_escape_string($email);
        $sql = "SELECT * FROM seller WHERE email = '$email'";
    } else {
        $sql = "SELECT * FROM seller";
    }

    $result = $conn->query($sql);

    $rows = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    echo json_encode($rows);

    $conn->close();
}
?>
