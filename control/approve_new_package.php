<?php
include '../model/mydb.php';

header("Content-Type: application/json");

$db = new myDB();
$conn = $db->openCon();

if ($conn) {
    $sql = "SELECT approve_tour_package_id, name, description, status, price, employee_id FROM approve_tour_package";
    $result = $conn->query($sql);

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
} else {
    echo json_encode(["error" => "Database connection failed"]);
}
?>
