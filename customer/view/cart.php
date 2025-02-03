<?php
/*session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}*/
require '../control/cart_show.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Cart</title>
    <link rel="stylesheet" type="text/css" href="../style/cart.css">
</head>

<body>
    <div class="button-container">
        <a href="customer_homepage.php">
            <button type="button">Back</button>
        </a>
        <a href="../../logout_control.php">
            <button type="button">LOG OUT</button>
        </a>
    </div>

    <fieldset>
        <legend>
            <h2>My Cart</h2>
        </legend>
        <table>
            <?php
            if ($res_cart->num_rows > 0) {
                while ($row = $res_cart->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>Product Name :</td>';
                    echo '<td>' . htmlspecialchars($row["product_name"]) . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Quantity :</td>';
                    echo '<td>';

                    echo '<form method="POST" action="../control/update_cart_quantity.php">';
                    echo '<input type="hidden" name="cart_id" value="' . htmlspecialchars($row["cart_id"]) . '">';
                    echo '<input type="hidden" name="price" value="' . htmlspecialchars($row["price"]) . '">';
                    echo '<input type="hidden" name="current_quantity" value="' . htmlspecialchars($row["quantity"]) . '">';
                    echo '<button type="submit" name="action" value="add">+</button> ';
                    echo htmlspecialchars($row["quantity"]);
                    echo ' <button type="submit" name="action" value="subtract">-</button>';
                    echo ' <button type="submit" name="action" value="dlet">Delete</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Price :</td>';
                    echo '<td>' . htmlspecialchars($row["total_price"]) . '</td>';
                    echo '</tr>';
                }
                echo '<tr><td colspan="2" class="center">';
                echo '<form action="payment.php" method="POST">';
                echo '<input type="submit" value="Proceed to Pay" name="submit" class="proceed-button"></form>';
                echo '</td></tr>';
            } else {
                echo '<h3>No Items In your Cart</h3>';
            }
            ?>
        </table>
    </fieldset>
    <div class="footer">
        <a href="travel_accessory.php">
            <button type="button">Buy Accessory</button>
        </a>
        <a href="travel_package.php">
            <button type="button">Book a Package</button>
        </a>
    </div>
</body>

</html>