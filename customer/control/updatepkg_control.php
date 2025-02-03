<?php
session_start();
include '../model/mydb.php';

$pkg_id = $_POST["temp_package_id"];
$person= $_POST["person"];
$pkg_price=$_POST["package_price"];
$action = $_POST["action"];
$table = "temp_pkg";

$db = new customerDB();
$con = $db->openCon();

// Increment or decrement the quantity
if ($action == "add") {
    $total=$person*$pkg_price;
    
    $uptemp=$db->updateTemppkg($table,$pkg_id,$person,$total,$con);
    header("Location:../view/payment_pkg.php");
}
else
{
    $dlet=$db->removeTempPKG($table,$pkg_id,$con);
    header("Location:../view/payment_pkg.php");
}
?>