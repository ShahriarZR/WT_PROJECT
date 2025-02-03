<!-- admin_reg_email_exist_check.php -->
<?php
include '../..//model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);
    $checkEmail = trim($data['checkEmail']);
    
    $db = new adminDB();
    $conn = $db->openCon();
    
    // Check if the email exists
    $emailCheckQuery = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $checkEmail);
    $stmt->execute();
    $emailCheckResult = $stmt->get_result();
    
    // Send response back as JSON
    if ($emailCheckResult->num_rows > 0) {
        echo json_encode(["exists" => true]);
    } else {
        echo json_encode(["exists" => false]);
    }
    // Close the connection
    $stmt->close();
    $conn->close();
}
?>