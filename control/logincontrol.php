<?php
include '../model/db.php';
 
$mail = $_POST["mail"];
$password = $_POST["pass"];
$table="seller";
 
$db1=new mydb();
$con=$db1->openCon();
$result1 = $db1->findUser($table,$mail,$password,$con);
if($result1->num_rows>0)
{
    header("Location:../view/seller_homepage.php");
    

}
else
{
    echo "INVALID EMAIL or PASSWORD.<br>";
    echo '<a href="../view/seller_login.php">RETRY LOGIN</a>';
}
   
?>