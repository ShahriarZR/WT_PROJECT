<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: admin_login.php");
    exit();
}
include '../model/mydb.php';

header("Content-Type: application/json");

$db = new myDB();
$conn = $db->openCon();

if ($conn) {
    $sql = "SELECT * FROM tour_package";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = array();

        while ($row = $result->fetch_assoc()) {
            $data[] = array(
                "tour_package_id" => $row["tour_package_id"],
                "tour_package_name" => $row["tour_package_name"],
                "tour_package_description" => $row["tour_package_description"],
                "tour_package_status" => $row["tour_package_status"],
                "tour_package_price" => $row["tour_package_price"],
                "employee_id" => $row["employee_id"]
            );
        }

        echo json_encode($data);
    } else {
        echo json_encode([]);
    }

    $conn->close();
} else {
    echo json_encode(["error" => "Database connection failed"]);
}
?>
