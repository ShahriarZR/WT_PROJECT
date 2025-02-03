<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
$payoption = $_POST["payoption"];
$payoptionpkg = $_POST["payoptionpkg"];

if ($payoption == "card") {
    header("Location: ../view/card_payment.php");
} elseif ($payoption == "mobilebanking") {
    header("Location: ../view/mobile_banking_payment.php");
} elseif ($payoption == "cod") {
    header("Location: ../view/cod_payment.php");
} 
elseif ($payoptionpkg == "card") {
    header("Location: ../view/card_payment_pkg.php");
} elseif ($payoptionpkg == "mobilebanking") {
    header("Location: ../view/mobile_banking_payment_pkg.php");
}
else {
    echo "Invalid payment option selected.";
}
?>