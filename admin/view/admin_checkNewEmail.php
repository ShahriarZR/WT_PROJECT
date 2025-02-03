<!DOCTYPE html>
<html lang="en">

<head>
    <title>New Admin Sign up</title>
    <link rel="stylesheet" type="text/css" href="../../customer/style/register.css">
</head>

<body>
    <fieldset>
        <legend>
            <h3>Sign Up</h3>
        </legend>
        <form method="POST" action="../control/admin_checkNewEmail_control.php">
            <table>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" id=""></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Submit">
                    </td>
                </tr>
            </table>
        </form>
    </fieldset>
</body>

</html>