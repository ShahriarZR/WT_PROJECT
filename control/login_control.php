<?php
include '../model/db.php';

$mail = $_POST["mail"];
$password = $_POST["pass"];
$table="customer";

$db1=new mydb();
$con=$db1->openCon();
$result1 = $db1->findUser($table,$mail,$password,$con);
if($result1->num_rows==1) 
{
    header("Location:../view/homepage.php");
    /*echo "Successfully Logged In.<br>";
    echo '<a href="../view/homepage.php">HOMPAGE</a>';*/
}
else
{
    echo "INVALID EMAIL or PASSWORD.<br>";
    echo '<a href="../view/customer_login.php">RETRY LOGIN</a>';
}
    
?>