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
    <title>Payment Option</title>
    <link rel="stylesheet" type="text/css" href="../style/pay.css">

</head>

<body>
<fieldset>
            <legend>My Packages</legend>
            <table>
                <?php
                if ($res_pkg->num_rows > 0) {
                    while ($row = $res_pkg->fetch_assoc()) {
                        echo '<form action="../control/updatepkg_control.php" method="POST"';
                        echo '<tr><td>Package Name:</td><td>' . htmlspecialchars($row["pkg_name"]) . '</td></tr>';
                        echo '<tr><td>Total Persons:</td><td>' . htmlspecialchars($row["total_person"]) . '</td></tr>';
                        echo '<tr><td>Package Price:</td><td>' . htmlspecialchars($row["totalpkg_price"]) . '</td></tr>';
                        echo '<tr><td>Booking Date:</td><td>' . htmlspecialchars($row["booking_date"]) . '</td></tr>';
                        
                // Add quantity input field
                echo '<input type="hidden" name="package_price" value="' . htmlspecialchars($row["pkg_price"]) . '">';
                echo '<input type="hidden" name="temp_package_id" value="' . htmlspecialchars($row["temp_pkg_id"]) . '">';
                echo '<input type="hidden" name="temp_package_id" value="' . htmlspecialchars($row["temp_pkg_id"]) . '">';
                echo '<tr><td><label>Total Person:</label></td>';
                echo '<td><input type="number" id="person" name="person" name="person" value="1" min="0" required></td></tr>';

                // Add the submit button
                echo '<tr><td><button type="submit" name="action" value="add">Update</button></td></tr>';
                echo '<tr><td><button type="submit" name="action" value="delete">Delete</button></td></tr></form>';
                    }
                }
                ?>
            </table>
        </fieldset>
    <fieldset>
    <legend>Select Payment</legend>
        <form action="../control/payment_control.php" method="POST">
            <table class="payment-table">
                <tr>
                    <td>
                        <label>
                            <input type="radio" name="payoptionpkg" value="card" required> Card Payment
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <input type="radio" name="payoptionpkg" value="mobilebanking"> Mobile Banking
                        </label>
                    </td>
                </tr>
            </table>
            <button type="submit">Continue</button>
        </form>
    </fieldset>
</body>

</html>
