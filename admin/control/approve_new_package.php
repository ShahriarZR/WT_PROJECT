<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

header("Content-Type: application/json");

$db = new adminDB();
$conn = $db->openCon();


$result = $db->adminApproveTourPackage($conn);

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            "approve_tour_package_id" => $row["approve_tour_package_id"],
            "name" => $row["name"],
            "description" => $row["description"],
            "status" => $row["status"],
            "price" => $row["price"],
            "employee_id" => $row["employee_id"]
        );
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();

?>