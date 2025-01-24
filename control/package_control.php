<?php
include '../model/db.php';
$table="tour_package";

$db=new mydb();
$con=$db->openCon();
$res=$db->findPackage($table,$con);
$row = $res->fetch_assoc();
if($res->num_rows >0)
    {
        $row = $res->fetch_assoc();
    }
?>