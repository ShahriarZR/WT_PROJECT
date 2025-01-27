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
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        foreach ($data as $package) {
            // Replace these with actual data for the package
            $approve_tour_package_id = $conn->real_escape_string($package['approve_tour_package_id']);
            $name = $conn->real_escape_string($package['name']);
            $description = $conn->real_escape_string($package['description']);
            $status = $conn->real_escape_string($package['status']);
            $price = $conn->real_escape_string($package['price']);
            $employee_id = $conn->real_escape_string($package['employee_id']);

            // Insert query to approve the package
            $sql = "INSERT INTO tour_package (tour_package_id, tour_package_name, tour_package_description, tour_package_status, tour_package_price, employee_id) VALUES ('$approve_tour_package_id', '$name', '$description', '$status', '$price', '$employee_id')";

            if ($conn->query($sql) === TRUE) {
                $sqlDel ="DELETE FROM approve_tour_package WHERE approve_tour_package_id = '$approve_tour_package_id'";
                if($conn->query($sqlDel) === TRUE){
                    echo "Package approved successfully.";
                }
                
            } else {
                echo "Error approving package: " . $conn->error;
            }
        }

        $conn->close();
    } else {
        echo "No valid data received.";
    }
}
?>
