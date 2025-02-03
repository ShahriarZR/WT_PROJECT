<?php
session_start();
include '../model/mydb.php';
$name = $_POST["name"];
$email = $_SESSION["admin_email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
$conf_password = $_POST["conf_password"];
$address = $_POST["address"];
$db = new adminDB();
$conn = $db->openCon();

$emailCheckQuery = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($emailCheckQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$emailCheckResult = $stmt->get_result();

// Send response back as JSON
if ($emailCheckResult->num_rows > 0) {
    echo "Email Already Registered";
} else {
    $result = $db->newAdmin($conn, $name, $email, $password, $phone, $gender, $address);

    if ($result) {
        $sqlDel = "DELETE FROM temp_admin where email ='$email'";
        if ($conn->query($sqlDel)) {
            $_SESSION["employee_name"] = $name;
            header("LOCATION: ../../login.php");
        }
    } else {
        echo "Error: Unable to register user.";
    }
}
// Close the connection
$stmt->close();
$conn->close();
