<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}include '../model/mydb.php';

$product_id = $_POST["product_id"];
$_SESSION["product_id"]=$product_id;
$product_name = $_POST["product_name"];
$product_price = $_POST["product_price"];
$product_quantity = $_POST["quantity"];
$table = "cart";
$table1 = "customer";
$table2 = "travel_accessory";
$table3="tour_package";
$mail = $_SESSION["customer_email"];
$date = date("Y-m-d");


$db1 = new customerDB();
$con = $db1->openCon();
$rescustomer = $db1->findUserinsert($table1, $mail, $con);
$stock = $db1->findStock($table2, $product_id, $con);

while ($row = $rescustomer->fetch_assoc()) {
    $c_id = $row["customer_id"];
    $_SESSION["c_id"] = $c_id;

}
$resultcart = $db1->collectCart($table, $c_id, $con);
while ($row = $stock->fetch_assoc()) {
    $current_stock = $row["stock"];
    if ($current_stock >= $product_quantity) {
        while ($row = $resultcart->fetch_assoc()) {
            $c_product_name = $row["product_name"];
            $cart_id = $row["cart_id"];
            if ($product_name == $c_product_name) {
                $c_quantity = $row["quantity"];
                $product_quantity += $c_quantity;
                $total_price=$product_quantity*$product_price;
                $up_cart = $db1->updateCart($table, $cart_id, $product_quantity,$total_price, $con);
                header("Location:../view/travel_accessory.php");
                exit();
            }
        }
        $total_price=$product_quantity*$product_price;
        $insrt_cart = $db1->addCart($table, $c_id, $product_id, $product_quantity, $product_price,$total_price, $date, $product_name, $con);
        header("Location:../view/travel_accessory.php");
    } else {
        echo "Out of Stock.";
    }
}
?>