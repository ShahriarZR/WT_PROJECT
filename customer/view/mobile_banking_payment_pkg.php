<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
?><!DOCTYPE html>
<html>

<head>
    <title>Mobile Banking Payment</title>
    <link rel="stylesheet" type="text/css" href="../style/mb.css">
</head>

<body>
    <h3>Mobile Banking</h3>
    <form action="../control/customer_update_package_control.php" method="POST">
        <table>
            <tr>
                <td>
                    Mobile Number:
                </td>
                <td>
                    <input type="text" id="mobileNumber" name="mobileNumber" required>
                </td>
            </tr>
            <tr>
                <td>
                    Transaction ID:
                </td>
                <td>
                    <input type="text" id="transactionId" name="transactionId" required>
                </td>
            </tr>
            <tr>
                <td>
                    <button type="submit">Pay Now</button>
                </td>
            </tr>

        </table>
    </form>
</body>

</html>