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
    <title>Payment Option</title>
    <link rel="stylesheet" type="text/css" href="../style/pay.css">
</head>

<body>

<a href="customer_homepage.php"><button>Homepage</button></a>
    <fieldset>
        <legend>Select Payment</legend>
        <form action="../control/payment_control.php" method="POST">
            <input type="radio" name="payoption" id="card" value="card" required> Card Payment<br>
            <input type="radio" name="payoption" id="mobilebanking" value="mobilebanking"> Mobile Banking<br>
            <input type="radio" name="payoption" id="cod" value="cod"> Cash on Delivery<br><br>
            <button type="submit">Continue</button>
        </form>
    </fieldset>
</body>

</html>
