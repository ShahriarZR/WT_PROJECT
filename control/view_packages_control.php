<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: employee_login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $db = new myDB();
    $conn = $db->openCon();

    // Get input from the request
    $input = json_decode(file_get_contents("php://input"), true);
    //$email = isset($data['email']) ? $data['email'] : '';
    $name = isset($input['name']) ? $input['name'] : '';

    // Build the query
    if (!empty($name)) {
        $name = $conn->real_escape_string($name);
        $sql = "SELECT tour_package_id, tour_package_name, tour_package_description, tour_package_status, tour_package_price FROM tour_package WHERE tour_package_name = '$name'";
    } else {
        $sql = "SELECT tour_package_id, tour_package_name, tour_package_description, tour_package_status, tour_package_price FROM tour_package";
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
