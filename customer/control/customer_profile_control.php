<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';
$table = "customer";

$mail = $_SESSION["customer_email"];
$o_pass = $_SESSION["pass"];

$db1 = new customerDB();
$con = $db1->openCon();
$c_result = $db1->findUserinsert($table, $mail, $con);

?>