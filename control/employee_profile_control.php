<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: employee_login.php");
    exit();
}

include '../model/mydb.php';
$db = new myDB();
$conn = $db->openCon();

$email = $_SESSION["employee_email"];
$sql = "SELECT name, email, phone, gender, address, position FROM employee WHERE email = '$email'";
$result = $conn->query($sql);

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
