<!DOCTYPE html>
<html lang="en">

<head>
    <title>Project Task 1</title>
    <script src="../js/myjs.js"></script>
</head>

<body>
    <h1>Admin Registration</h1>
    <fieldset>
        <legend>
            <h3>New Admin</h3>
        </legend>
        <form onsubmit="return validateForm()" action="../control/admin_reg_control.php" method="post" >
            <table>
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="name" id="name"></td>
                    <td><p id="invalidName"><?php echo ""; ?></p></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" id="email"></td>
                    <td><p id="invalidEmail"><?php echo ""; ?></p></td> 
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td><input type="text" name="phone" id="phone"></td>
                    <td><p id="invalidPhone"><?php echo ""; ?></p></td>
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
                    <td><p id="invalidPassword"><?php echo "" ?></p></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="conf_password" id="conf_password"></td>
                    <td><p id="invalidConfPass"><?php echo ""; ?></p></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Submit">
                        <input type="reset" value="Reset">
                    </td>
                </tr>
            </table>
        </form>

        <h6>1. Name Should be at least 4 characters<br>
            2. Email Address field is required, and the input must contain aiub.edu domain<br>
            3. Validate drop-down/select fields which user must select one option.<br>
            4. Phone Number field must contain only numbers<br>
            5. Password must have at least one special character and confirm password should match the password.<br>
        </h6>

    </fieldset>
    
</body>

</html>
