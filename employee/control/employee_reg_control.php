<?php
// Get POST data and session info
$name = $_POST["name"];
$email = $_SESSION["employee_email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
$conf_password = $_POST["conf_password"];
$address = $_POST["address"];

// Assuming $conn is the database connection
$db = new employeeDB();
$conn = $db->openCon();

// Call the newEmployee function
$result = $db->newEmployee($conn, $name, $email, $password, $phone, $gender, $address);

if ($result) {
    // After successfully inserting the employee, delete from the temp_employee table
    $sqlDel = "DELETE FROM temp_employee WHERE email = '$email'";
    if ($conn->query($sqlDel)) {
        $_SESSION["employee_name"] = $name;
        header("LOCATION: ../view/employee_panel.php");
    }
} else {
    echo "Error: Unable to register employee.";
}

// Close the connection
$conn->close();

?>