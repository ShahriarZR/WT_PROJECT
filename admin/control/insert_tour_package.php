<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';
include 'functions.php'; // Ensure this file contains the function

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (is_array($data) && count($data) > 0) {
        $db = new adminDB();
        $conn = $db->openCon();

        foreach ($data as $package) {
            echo $db->adminInsertApproveTourPackage($conn, $package);
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}
?>
