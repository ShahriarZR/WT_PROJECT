<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: admin_login.php");
    exit();
}
include '../model/mydb.php';

header("Content-Type: application/json");

$db = new adminDB();
$conn = $db->openCon();

$result = $db->adminApproveTravelAccessory($conn);
if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = array(
            "approve_travel_accessory_id" => $row["approve_travel_accessory_id"],
            "name" => $row["name"],
            "description" => $row["description"],
            "price" => $row["price"],
            "stock" => $row["stock"],
            "seller_id" => $row["seller_id"]
        );
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}
?>
