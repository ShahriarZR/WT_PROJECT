<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

$c_id=$_SESSION["c_id"];
$table="cart";
$table1="travel_accessory";
$table2="sold_items";



$db=new customerDB();
$con=$db->openCon();
$resquantity=$db->collectCart($table,$c_id,$con);

if($resquantity->num_rows>0)
{
    while($row=$resquantity->fetch_assoc())
    {
        $p_id=$row["travel_accessory_id"];
        $p_quantity=$row["quantity"];
        $cart_id=$row["cart_id"];
        $availablequantity=$db->findStock($table1,$p_id,$con);
        while($row1=$availablequantity->fetch_assoc())
        {
            $availquantity=$row1["stock"];
            $new_q=$availquantity-$p_quantity;
            $p_name=$row1["name"];
            $p_price=$row1["price"];
            $total=$p_price*$p_quantity;
            $update=$db->updateAccessory($table1,$p_id,$new_q,$con);
            $sold=$db->addSold($table2,$p_name,$p_id,$c_id,$p_price,$p_quantity,$total,$con);
            $removecart=$db->removeCart($table,$cart_id,$con);
            

        }

    }

    header("Location:../view/confirmation.php");
    
}
?>