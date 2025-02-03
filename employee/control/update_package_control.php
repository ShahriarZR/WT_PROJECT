<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new employeeDB();
    $conn = $db->openCon();

    $employee_email = $conn->real_escape_string($_SESSION["employee_email"]);
    $sqlEmail = "SELECT employee_id FROM employee WHERE email = '$employee_email'";
    $result = $conn->query($sqlEmail);
    $row = $result->fetch_assoc();
    $employee_id = $row["employee_id"];

    // Get the incoming JSON data
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (is_array($data) && count($data) > 0) {
        foreach ($data as $package) {
            $tour_package_id = $conn->real_escape_string($package['tour_package_id']);
            $tour_package_name = $conn->real_escape_string($package['tour_package_name']);
            $tour_package_description = $conn->real_escape_string($package['tour_package_description']);
            $tour_package_status = $conn->real_escape_string($package['tour_package_status']);
            $tour_package_price = $conn->real_escape_string($package['tour_package_price']);

            // Call the approveTourPackage function to insert the approved package
            if ($db->employeeApproveTourPackage($conn, $employee_id, $tour_package_id, $tour_package_name, $tour_package_description, $tour_package_status, $tour_package_price)) {
                // If the approval is successful, delete the package from the tour_package table
                $sqlDel = "DELETE FROM tour_package WHERE tour_package_id = '$tour_package_id'";
                if ($conn->query($sqlDel) === TRUE) {
                    echo "Waiting for Admin to approve";
                }
            } else {
                echo "Error approving Package ID $tour_package_id: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}
?>
