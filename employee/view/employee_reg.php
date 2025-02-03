<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employee Registration</title>
    <link rel="stylesheet" type="text/css" href="../../customer/style/register.css">
    <script src="../js/myjs.js"></script>
</head>

<body>
    <h1>Employee Registration</h1>
    <fieldset>
        <legend>
            <h3>New Employee</h3>
        </legend>
        <form onsubmit="return validateEmployeeForm()" method="POST" action="../control/employee_reg_control.php">
            <table>
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="name" id="name"></td>
                    <td>
                        <p id="invalidName"><?php echo ""; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td><input type="text" name="phone" id="phone"></td>
                    <td>
                        <p id="invalidPhone"><?php echo ""; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>
                        <input type="radio" name="gender" value="Male">Male
                        <input type="radio" name="gender" value="Female">Female
                        <input type="radio" name="gender" value="Other">Other
                    </td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td>
                        <textarea name="address" rows="3" cols="20"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="password"></td>
                    <td>
                        <p id="invalidPassword"><?php echo "" ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="conf_password" id="conf_password"></td>
                    <td>
                        <p id="invalidConfPass"><?php echo ""; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>
        <div id="output"></div>
        <div id="successMessage"></div>
        <div id="errorMessage"></div>

        <!-- Pop up message -->
        <div id="popup" style="display: none;">
            <div id="popupContent">
                <p id="popupMessage"></p>
                <button onclick="closePopup()">OK</button>
            </div>
        </div>

    </fieldset>

</body>

</html>