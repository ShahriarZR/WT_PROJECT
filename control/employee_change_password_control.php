<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: employee_login.php");
    exit();
}

include '../model/mydb.php';
$db = new myDB();
$conn = $db->openCon();

$currentEmail = $_SESSION["employee_email"];

$data = json_decode(file_get_contents("php://input"), true);

$currentPassword = trim($data["currentPassword"]);
$newPassword = trim($data["newPassword"]);

$sql = "SELECT password FROM employee WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $currentEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $oldPassword = $row["password"];

    if ($currentPassword !== $oldPassword) {
        echo json_encode(["success" => false, "message" => "Current password is incorrect."]);
        exit();
    }

    $newSql = "UPDATE employee SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($newSql);
    $stmt->bind_param("ss", $newPassword, $currentEmail);


    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Password updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update password."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Admin not found."]);
}

$conn->close();
?>