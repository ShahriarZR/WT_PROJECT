<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Connect to the database
    $db = new employeeDB();
    $conn = $db->openCon();

    // Get input from the request
    $input = json_decode(file_get_contents("php://input"), true);
    $name = isset($input['name']) ? $input['name'] : '';

    // Call the getTourPackages function
    $result = $db->employeeGetTourPackages($conn, $name);

    $rows = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    // Output the result as JSON
    echo json_encode($rows);

    // Close the connection
    $conn->close();
}
?>
