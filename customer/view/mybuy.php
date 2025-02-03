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
    <title>Tour Packages</title>
    <link rel="stylesheet" type="text/css" href="../style/mbuy.css">
</head>

<body>

    <a href="customer_homepage.php">
        <button type="button">Back</button>
    </a>

    <a href="../control/logout_control.php">
        <button type="button">LOG OUT</button>
    </a>

    <a href="../view/cart.php">
        <button type="button">My Cart</button>
    </a>

    <fieldset>


        <legend>
            <h2>My Items</h2>
        </legend>
        <table border="0" cellpadding="20" cellspacing="0">
            <?php
            while ($row = $res_show->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<h3>Product/Package Name: ' . htmlspecialchars($row["p_name"]) . '</h3>';
                echo '<p>Quantity/Person: ' . htmlspecialchars($row["p_quantity"]) . '</p>';
                echo '<p>Total Amount: ' . htmlspecialchars($row["total_price"]) . '</p>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>

    </fieldset>

</body>

</html>