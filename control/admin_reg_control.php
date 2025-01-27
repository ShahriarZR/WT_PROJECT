<?php
include '../model/mydb.php';
$name = $_POST["name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$gender = $_POST["gender"];
$password = $_POST["password"];
$conf_password = $_POST["conf_password"];
$address = $_POST["address"];
$db = new myDB();
$conn = $db->openCon();

$emailCheckQuery = "SELECT * FROM admin WHERE email = ?";
$stmt = $conn->prepare($emailCheckQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$emailCheckResult = $stmt->get_result();

// Send response back as JSON
if ($emailCheckResult->num_rows < 0) {
    $result = $db->newUser($conn, $name, $email, $password, $phone, $gender, $address);

    if ($result) {
        echo "Successful";
    } else {
        echo "Error: Unable to register user.";
    }
} else {
    echo "Email Already Registered";
}
// Close the connection
$stmt->close();
$conn->close();
?>