<!DOCTYPE html>
<html>
<head>
    <title>Customer Login</title>
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
                <td><a href="customer_signup.php">REGISTER HERE</a></td>
            </tr>
        </table>
</form>
</fieldset>
    
</body>
</html>