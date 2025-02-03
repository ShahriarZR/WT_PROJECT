<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
include '../model/mydb.php';

$cart_id = $_POST["cart_id"];
$current_quantity = (int) $_POST["current_quantity"];
$product_price=$_POST["price"];
$action = $_POST["action"];
$table = "cart";
$_SESSION["cart_id"]=$cart_id;

$new_quantity = $current_quantity;

$db = new customerDB();
$con = $db->openCon();

// Increment or decrement the quantity
if ($action == "add") {
    $new_quantity++;
} elseif ($action == "subtract" && $current_quantity > 1) {
    $new_quantity--;
}
else
{
    $dlet=$db->removeCart($table,$cart_id,$con);
}

$total_price=$new_quantity*$product_price;
$cartupdate = $db->updateCart($table, $cart_id, $new_quantity,$total_price, $con);

if ($cartupdate) {
    echo "Cart updated successfully.";
} else {
    echo "Failed to update cart: " . $con->error;
}

// Redirect back to the cart page
header("Location: ../view/cart.php");
exit();
?>