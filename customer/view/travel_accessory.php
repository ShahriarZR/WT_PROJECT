<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
require '../control/package_control.php';
$email = $_SESSION["customer_email"];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tour Packages</title>
    <link rel="stylesheet" type="text/css" href="../style/ta.css">
</head>

<body>

<div class="button-container">
        <a href="customer_homepage.php"><button class="btn">Back</button></a>
        <a href="cart.php"><button class="btn">My Cart</button></a>
        <a href="../../logout_control.php"><button class="btn">LOG OUT</button></a>
    </div>

    <fieldset>

        <legend>
            <h2>Travel Accessories</h2>
        </legend>
        <table border="0" cellpadding="20" cellspacing="0">
            <?php
            while ($row = $resaccessory->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<img src="../resources/' . htmlspecialchars($row["travel_accessory_image"]) . '" alt="' . htmlspecialchars($row["name"]) . '" width="450" height="300">';
                echo '</td>';
                echo '<td>';
                echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
                echo '<p>Price: ' . htmlspecialchars($row["price"]) . ' BDT</p>';
                echo '<p>'. htmlspecialchars($row["description"]).'</p>';
                echo '<p>Available Stock:'. htmlspecialchars($row["stock"]).'</p>';
                echo '<form method="POST" action="../control/cart_control.php">';
                echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($row["travel_accessory_id"]) . '">'; // Pass product ID
                echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($row["name"]) . '">'; // Pass product name
                echo '<input type="hidden" name="product_price" value="' . htmlspecialchars($row["price"]) . '">'; // Pass product price
            
                // Add quantity input field
                echo '<label>Quantity:</label> ';
                echo '<input type="number" id="quantity" name="quantity" name="quantity" value="1" min="1" required>';

                // Add the submit button
                echo '<button type="submit">Add to Cart</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            ?>

        </table>

    </fieldset>

</body>

</html>