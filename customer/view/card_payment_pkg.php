<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
    <html>

    <head>
        <title>Card Payment</title>
        <link rel="stylesheet" type="text/css" href="../style/card_payment.css">
    </head>

    <body>
        <h3>Card Payment</h3>
        <form action="../control/customer_update_package_control.php">
            <table>
                <tr>
                    <td>Card Number:</td>
                    <td><input type="text" id="cardNumber" name="cardNumber" required></td>
                </tr>
                <tr>
                    <td>Expiry Date:</td>
                    <td><input type="month" id="expiryDate" name="expiryDate" required></td>
                </tr>
                <tr>
                    <td>CVV:</td>
                    <td><input type="text" id="cvv" name="cvv" required></td>
                </tr>
                <tr>
                    <td colspan="2"><button type="submit">Pay Now</button></td>
                </tr>
            </table>
    </form>
</body>

</html>