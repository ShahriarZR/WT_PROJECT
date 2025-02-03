<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

$tablename = "customer";
$mail = $_SESSION["customer_email"]; // Fetch the logged-in user's email

$db = new customerDB();
$con = $db->openCon();

// Fetch current user data using `findUserinsert`
$result = $db->findUserinsert($tablename, $mail, $con);

if ($result && $result->num_rows > 0) {
    $currentData = $result->fetch_assoc(); // Get the current data for the user

    // Get form inputs; fallback to existing values if the field is not filled
    $name = !empty($_POST["name"]) ? $_POST["name"] : $currentData["name"];
    $phone = !empty($_POST["phone"]) ? $_POST["phone"] : $currentData["phone"];
    $dob = !empty($_POST["dob"]) ? $_POST["dob"] : $currentData["dob"];
    $gender = !empty($_POST["gender"]) ? $_POST["gender"] : $currentData["gender"];
    $address = !empty($_POST["address"]) ? $_POST["address"] : $currentData["address"];

    // Update user data (name, phone, dob, gender, address)
    $res = $db->updateUser($tablename, $name, $dob, $mail, $gender, $address, $phone, $con);

    if ($res) {
        header("Location:../view/customer_profile.php");
        echo "Profile updated successfully.";
    } else {
        echo "Error updating profile.";
    }

    // Handle password update (without hashing)
    if (!empty($_POST["current_password"]) && !empty($_POST["new_password"]) && !empty($_POST["confirm_password"])) {
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        // Verify the current password (assuming plain text password)
        if ($current_password === $currentData["password"]) {
            if ($new_password === $confirm_password) {
                // Update password without hashing (not recommended for security reasons)
                $passwordUpdated = $db->updatePassword($tablename, $new_password, $mail, $con);
                if ($passwordUpdated) {
                    header("Location:../view/customer_profile.php");
                    echo "Password updated successfully.";
                } else {
                    echo "Error updating password.";
                }
            } else {
                echo "New password and confirmation do not match.";
            }
        } else {
            echo "Current password is incorrect.";
        }
    }
} else {
    echo "User data not found.";
}
?>
