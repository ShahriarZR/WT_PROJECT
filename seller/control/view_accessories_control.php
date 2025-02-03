<?php
session_start();
if (!isset($_SESSION["seller_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connect to the database
    $db = new sellerDB();
    $conn = $db->openCon();

    // Get input from the request
    $input = json_decode(file_get_contents("php://input"), true);
    $name = isset($input['name']) ? $input['name'] : '';

    // Call the function to get the travel accessories
    $rows = $db->sellerGetTravelAccessories($conn, $name);

    // Return the result as JSON
    echo json_encode($rows);

    // Close the connection
    $conn->close();
}
?>
