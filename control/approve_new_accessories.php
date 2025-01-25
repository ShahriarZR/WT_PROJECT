<?php
include '../model/mydb.php';

header("Content-Type: application/json");

$db = new myDB();
$conn = $db->openCon();

if ($conn) {
    $sql = "SELECT approve_travel_accessory_id, name, description, price, stock, seller_id FROM approve_travel_accessory";
    $result = $conn->query($sql);

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

    $conn->close();
} else {
    echo json_encode(["error" => "Database connection failed"]);
}
?>
