<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Customer Login</title>
    <link rel="stylesheet" href="../style/login.css">
</head>

<body>
    <form action="../control/login_control.php" method="POST">
        <h2>Customer Login Page</h2>
        <fieldset>
            <table>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="mail" required></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="pass" required></td>
                </tr>
                <tr>
                    <td><input type="submit" name="submit" value="LOG IN"></td>
                </tr>
            </table>
        </fieldset>
    </form>
    <p>
        <a href="../view/customer_signup.php">
            <button type="button">Register Here.</button>
        </a>
    </p>


</body>

</html>