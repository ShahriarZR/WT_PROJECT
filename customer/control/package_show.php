<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

$table = "temp_pkg";
$table1 = "customer";
$mail = $_SESSION["customer_email"];
$c_id;

$db1 = new customerDB();
$con = $db1->openCon();
$rescustomer = $db1->findUserinsert($table1, $mail, $con);
while ($row = $rescustomer->fetch_assoc()) {
    $c_id = $row["customer_id"];

}
$res_pkg= $db1->collectCart($table, $c_id, $con);
?>