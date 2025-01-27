<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

include '../model/mydb.php';
$db = new myDB();
$conn = $db->openCon();

$email = $_SESSION["admin_email"];
$sql = "SELECT name, email, phone, gender, address FROM admin WHERE email = '$email'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "name" => $row["name"],
        "email" => $row["email"],
        "phone" => $row["phone"],
        "gender" => $row["gender"],
        "address" => $row["address"]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Admin not found."]);
}

$conn->close();
?>
