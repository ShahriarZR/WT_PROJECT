<?php
include '../model/db.php';
$name = $_POST["name"];
$description = $_POST["description"];
$price = $_POST["price"];
$stock= $_POST["stock"];
$table_name="travel_accessory";
$db=new mydb();
$con=$db->openCon();
/*
if(isset($name, $description, $price, $stock)){
    $res=$db-> findSeller( $tradeLicense,$con);
    
    echo "Succesfully Added!!!";
}
else{
    echo "Enter Data Properly!";
}*/

$result=$db->addProduct($table_name,$name, $description, $price, $stock,  $con);
echo "Succesfully Added!!!";
?>
