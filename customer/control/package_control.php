<?php
/* session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: login.php");
    exit();
} */
$currentPage = basename($_SERVER['PHP_SELF']);

if ($currentPage === "admin_homepage.php" || $currentPage === "seller_homepage.php" ||$currentPage === "employee_homepage.php") { 
    include '../../customer/model/mydb.php';  // Include this file for page1.php
} elseif ($currentPage === "homepage.php") {
    include 'customer/model/mydb.php';  // Include this file for page2.php
}
else{
    include '../model/mydb.php';  // Include this file for page2.php
}
$table = "tour_package";
$table1 = "travel_accessory";
$table2 = "customer";


$db = new customerDB();
$con = $db->openCon();
$respackage = $db->findPackage($table, $con);
$resaccessory = $db->findAccessory($table1, $con);

?>