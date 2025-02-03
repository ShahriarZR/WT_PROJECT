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
    <title>Cash on Delivery</title>
    <link rel="stylesheet" type="text/css" href="../style/card_payment.css">
</head>

<body>
    <h3>Cash on Delivery</h3>
    <p>Thank you for choosing Cash on Delivery. Please ensure you have the exact amount ready upon delivery.</p>
    <form action="../control/update_accessory.php" method="POST">
        <button type="submit">Confirm Order</button>
    </form>
</body>

</html>