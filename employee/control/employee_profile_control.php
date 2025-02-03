<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
$db = new employeeDB();
$conn = $db->openCon();

$email = $_SESSION["employee_email"];
$result = $db->employeeProfile($conn, $email);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "name" => $row["name"],
        "email" => $row["email"],
        "phone" => $row["phone"],
        "gender" => $row["gender"],
        "address" => $row["address"],
        "position" => $row["position"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Admin not found."]);
}

$conn->close();
?>
