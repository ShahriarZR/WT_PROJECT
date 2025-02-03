<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';

//$c_id=$_SESSION["c_id"];
$table2="sold_items";
$table3="temp_pkg";
$email = $_SESSION["customer_email"];



$db=new customerDB();
$con=$db->openCon();
$sqlCustId ="SELECT customer_id FROM customer where email ='$email'";
$resultId = $con->query($sqlCustId);
$result = $resultId->fetch_assoc();
$c_id = $result['customer_id'];

$resultpkg=$db->collectCart($table3,$c_id,$con);

if($resultpkg->num_rows>0)
{
    while($row=$resultpkg->fetch_assoc())
    {
        $pkg_id=$row["pkg_id"];
        $pkg_name=$row["pkg_name"];
        $pkg_price=$row["pkg_price"];
        $pkg_person=$row["total_person"];
        $total=$pkg_price*$pkg_person;
        $soldpkg=$db->addSold($table2,$pkg_name,$pkg_id,$c_id,$pkg_price,$pkg_person,$total,$con);
        $removepkg=$db->removePkg($table3,$pkg_id,$con);


    }
    header("Location:../view/confirmation.php");
}

?>