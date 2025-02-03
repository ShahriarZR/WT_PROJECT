<?php
session_start();

// Check if the seller is logged in
if (!isset($_SESSION["seller_email"])) {
    header("Location: ../../login.php");
    exit();
}

// Include the functions file and database connection
include '../model/mydb.php';
include 'functions.php';  // Include the file where the function is defined

// Create the database object and establish the connection
$db = new sellerDB();
$conn = $db->openCon();

// Set the header to JSON
header('Content-Type: application/json');

// Get input from the request (assuming JSON body)
$input = json_decode(file_get_contents("php://input"), true);

// Escape input to prevent SQL injection
$name = $conn->real_escape_string($input['name']);
$description = $conn->real_escape_string($input['description']);
$price = $conn->real_escape_string($input['price']);
$stock = $conn->real_escape_string($input['stock']);

// Get the seller's email from the session and fetch the seller_id
$seller_email = $conn->real_escape_string($_SESSION["seller_email"]);
$sqlEmail = "SELECT seller_id FROM seller WHERE email = '$seller_email'";

$result = $conn->query($sqlEmail);
$row = $result->fetch_assoc();
$seller_id = $row["seller_id"];

// Call the function to add the new accessory
$response = $db->sellerAddNewAccessory($conn, $seller_id, $name, $description, $price, $stock);
echo $response;

// Close the database connection
$conn->close();
?>
