<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
require '../control/package_control.php';
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
            <h2>Most Popular Travel Packages</h2>
        </legend>
        <table border="0" cellpadding="20" cellspacing="0">
            <?php
            while ($row = $respackage->fetch_assoc()) {
                echo '<tr>';
                echo '<td>';
                echo '<img src="../resources/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["tour_package_name"]) . '" width="450" height="300">';
                echo '</td>';
                echo '<td>';
                echo '<h3>' . htmlspecialchars($row["tour_package_name"]) . '</h3>';
                echo '<p>' . htmlspecialchars($row["tour_package_description"]) . '</p>';
                echo '<p>Price: ' . htmlspecialchars($row["tour_package_price"]) . ' BDT</p>';
                echo '<form method="POST" action="../control/package_cart_control.php">';
                echo '<input type="hidden" name="package_id" value="' . htmlspecialchars($row["tour_package_id"]) . '">'; // Pass product ID
                echo '<input type="hidden" name="package_name" value="' . htmlspecialchars($row["tour_package_name"]) . '">'; // Pass product name
                echo '<input type="hidden" name="package_price" value="' . htmlspecialchars($row["tour_package_price"]) . '">'; // Pass product price
            
                // Add quantity input field
                echo '<label>Person:</label> ';
                echo '<input type="number" id="person" name="person" name="person" value="1" min="1" required>';

                // Add the submit button
                echo '<button type="submit">Book Now</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>

    </fieldset>

</body>

</html>