<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

$table = "cart";
$table1 = "customer";
$table2="temp_pkg";
$table3="sold_items";
$mail = $_SESSION["customer_email"];
$c_id;

$db1 = new customerDB();
$con = $db1->openCon();
$rescustomer = $db1->findUserinsert($table1, $mail, $con);
while ($row = $rescustomer->fetch_assoc()) {
    $c_id = $row["customer_id"];
    $_SESSION["c_id"] = $c_id;

}
$res_cart = $db1->collectCart($table, $c_id, $con);
$res_pkg= $db1->collectCart($table2, $c_id, $con);
$res_show=$db1->collectSold($table3, $c_id, $con);
?>