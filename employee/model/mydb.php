<?php
class employeeDB
{
    function openCon()
    {
        $dbhost = "localhost";
        $dbusername = "root";
        $password = "";
        $dbname = "mydb";
        $conn = new mysqli($dbhost, $dbusername, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    //Employee Model
    function loginEmployee($conn, $email, $password)
    {
        $sql = "SELECT * FROM employee WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        return $result;
    }
function employeeAddNewPackage($conn, $name, $description, $status, $price, $employee_email) {
    // SQL query creation
    $sql = "INSERT INTO approve_tour_package (employee_id, name, description, status, price) 
            VALUES ((SELECT employee_id FROM employee WHERE email = ?), ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $employee_email, $name, $description, $status, $price);

    // Execute the query and return the result
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Package added successfully."];
    } else {
        return ["success" => false, "message" => "Error: " . $conn->error];
    }
}
function deleteTourPackage($conn, $tour_package_id) {
    // SQL query to delete the tour package by ID
    $sql = "DELETE FROM tour_package WHERE tour_package_id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tour_package_id);

    // Execute the query and return the result
    if ($stmt->execute()) {
        return ["success" => true, "message" => "Package ID $tour_package_id deleted successfully."];
    } else {
        return ["success" => false, "message" => "Error deleting Package ID $tour_package_id: " . $conn->error];
    }
}
function updateEmployeePassword($conn, $currentEmail, $currentPassword, $newPassword) {
    // Fetch current password from database
    $sql = "SELECT password FROM employee WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $currentEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $oldPassword = $row["password"];

        // Check if current password matches the stored one
        if ($currentPassword !== $oldPassword) {
            return ["success" => false, "message" => "Current password is incorrect."];
        }

        // Update password
        $newSql = "UPDATE employee SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($newSql);
        $stmt->bind_param("ss", $newPassword, $currentEmail);

        if ($stmt->execute()) {
            return ["success" => true, "message" => "Password updated successfully."];
        } else {
            return ["success" => false, "message" => "Failed to update password."];
        }
    } else {
        return ["success" => false, "message" => "Employee not found."];
    }
}
function getNewEmployeeByEmail($conn, $email)
{
    // Escape the email to prevent SQL injection
    $email = $conn->real_escape_string($email);
    
    // Prepare the SQL query
    $sql = "SELECT * FROM temp_employee WHERE email = '$email'";

    // Execute the query and return the result
    return $conn->query($sql);
}

function employeeProfile($conn, $email)
{
    $sql = "SELECT name, email, phone, gender, address, position FROM employee WHERE email = '$email'";
    $result = $conn->query($sql);
    return $result;
}
function newEmployee($conn, $name, $email, $password, $phone, $gender, $address)
{
    // Prepare the SQL query to insert a new employee
    $sql = "INSERT INTO employee (name, email, password, phone, gender, address) 
            VALUES ('$name', '$email', '$password', '$phone', '$gender', '$address')";
    
    // Execute the query and return the result
    $result = $conn->query($sql);
    return $result;
}
function updateEmployeeProfile($conn, $name, $phone, $gender, $address, $email)
{
    // Prepare the SQL query to update the employee profile
    $sql = "UPDATE employee SET name = '$name', phone = '$phone', gender = '$gender', address = '$address' WHERE email = '$email'";

    // Execute the query and return the result
    return $conn->query($sql);
}
function employeeApproveTourPackage($conn, $employee_id, $tour_package_id, $tour_package_name, $tour_package_description, $tour_package_status, $tour_package_price)
{
    // Prepare the SQL query to insert the approved tour package
    $sql = "INSERT INTO approve_tour_package (approve_tour_package_id, employee_id, name, description, status, price)
            VALUES ('$tour_package_id', '$employee_id', '$tour_package_name', '$tour_package_description', '$tour_package_status', '$tour_package_price')";

    // Execute the query and return the result
    return $conn->query($sql);
}
function employeeGetTourPackages($conn, $name = '')
{
    // Build the query
    if (!empty($name)) {
        $name = $conn->real_escape_string($name);
        $sql = "SELECT tour_package_id, tour_package_name, tour_package_description, tour_package_status, tour_package_price FROM tour_package WHERE tour_package_name = '$name'";
    } else {
        $sql = "SELECT tour_package_id, tour_package_name, tour_package_description, tour_package_status, tour_package_price FROM tour_package";
    }

    // Execute the query
    return $conn->query($sql);
}



}
