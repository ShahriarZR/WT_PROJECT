<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    include '../model/mydb.php';
    
    // Connect to the database
    $db = new employeeDB();
    $conn = $db->openCon();

    // Call the getEmployeeByEmail function
    $result = $db->getNewEmployeeByEmail($conn, $email);

    if ($result && $result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        $_SESSION["employee_email"] = $employee["email"];
        header("LOCATION: ../view/employee_reg.php"); 
    } else {
        echo "Wrong Email";
    }

    // Close the connection
    $conn->close();
}
?>
