<?php
include '../model/db.php'; // Assumes you have a db.php file for database connection setup

$shopName = $_POST["shop_name"];
$contactName = $_POST["contact_name"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$tradeLicense = $_POST["trade_license"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirm_password"];

// Validation for shop name and contact name, assuming you don't want numeric values in names
if (ctype_alpha(str_replace(' ', '', $shopName)) && ctype_alpha(str_replace(' ', '', $contactName))) {
    if (!empty($email) && preg_match("/@.+\.xyz$/", $email)) {
        if ($password == $confirmPassword) {
            if (preg_match("/\d/", $password)) {
                if (isset($_POST["gender"])) {
                    echo "Successfully Signed Up.<br>";
                    echo "Welcome " . $contactName . "<br>";
                    // Assuming 'mydb' is a class in 'db.php' that handles database operations
                    // $sellerDb = new mydb();
                    // $sellerDb->addSeller(...); // Add seller to database here
                } else {
                    echo "Please Select Gender.<br>";
                }
            } else {
                echo "Password must contain at least one numeric character.<br>";
            }
        } else {
            echo "Passwords do not match.<br>";
        }
    } else {
        echo "Enter a valid Email with domain .xyz.<br>";
    }
} else {
    echo "Name should not contain any numeric values or special characters.<br>";
}

$formData = array(
    'shopName' => $_POST['shop_name'],
    'shopAddress' => $_POST['shop_address'],
    'contactName' => $_POST['contact_name'],
    'email' => $_POST['email'],
    'phone' => $_POST['phone'],
    'gender' => $_POST['gender'],
    'tradeLicense' => $_POST['trade_license'],
    'productCategories' => $_POST['product_categories'],
    'productCount' => $_POST['product_count']
);

$jsonData = json_encode($formData, JSON_PRETTY_PRINT);

// Attempt to save the JSON data to a file
if (file_put_contents("../data/sellerdata.json", $jsonData)) {
    echo 'Seller data successfully saved';
} else {
    echo "Failed to save data";
}
?>
