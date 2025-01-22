<?php
include '../model/db.php';
$name= $_POST["name"];
$email = $_POST["email"];
$shopName = $_POST["shop_name"];
$address= $_POST["address"];
$password = $_POST["password"];
$phone = $_POST["phone"];
$tradeLicenseNo = $_POST["trade_license"];
$noOfProducts= $_POST["product_count"];
$confirmPassword = $_POST["confirm_password"];
$table_name="seller";
$db=new mydb();
$con=$db->openCon();


if (!ctype_alpha(str_replace(' ', '', $shopName))) {
    echo "Shop name should not contain any numeric values or special characters.<br>";
}

if (empty($email)) {
    echo "Email is required.<br>";
} else if (!preg_match("/@.+\.xyz$/", $email)) {
    echo "Enter a valid Email with domain .xyz.<br>";
}

if (empty($phone)) {
    echo "Phone number is required.<br>";
} else if (!preg_match("/^[0-9]{10}$/", $phone)) { 
    echo "Invalid phone number format; 10 digits required.<br>";
}

if (empty($tradeLicenseNo)) {
    echo "Trade license number is required.<br>";
} else if (!ctype_digit($tradeLicenseNo)) {
    echo "Trade license number must be numeric.<br>";
}

if ($password === $confirmPassword) {
    if (empty($password)) {
        echo "Password is required.<br>";
    } else if (!preg_match("/\d/", $password)) {
        echo "Password must contain at least one numeric character.<br>";
    }
    $result=$db->addSeller($table_name, $name, $email, $shopName, $address,$password, $phone, $tradeLicenseNo,$noOfProducts , $con);
    echo '<a href="../view/customer_login.php">RETRY LOGIN</a>';
} else {
    echo "Passwords do not match.<br>";


}
?>
