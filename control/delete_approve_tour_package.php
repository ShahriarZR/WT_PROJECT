<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: admin_login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (is_array($data) && count($data) > 0) {
        $db = new myDB();
        $conn = $db->openCon();

        foreach ($data as $package) {
            // Replace these with actual data for the package
            $approve_tour_package_id = $conn->real_escape_string($package['approve_tour_package_id']);

            // Insert query to approve the package
            $sqlDel = "DELETE FROM approve_tour_package WHERE approve_tour_package_id = '$approve_tour_package_id'";
            if ($conn->query($sqlDel) === TRUE) {
                echo "Package rejected.";
            } else {
                echo "Error rejecting package: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}
?>