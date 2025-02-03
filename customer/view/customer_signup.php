<!DOCTYPE html>
<html>

<head>
    <title>Customer Registration</title>
    <link rel="stylesheet" type="text/css" href="../style/register.css">
</head>

<body>
    <script src="../js/myjs.js"></script>
    <form action="../control/reg_control.php" method="POST" enctype="multipart/form-data"
        onsubmit=" return validation()">
        <h2>Customer Registration Form</h2>
        <fieldset>
            <legend>
                <h3>Personal Information</h3>
            </legend>
            <table>
                <tr>
                    <td>First Name:</td>
                    <td><input type="text" id="fname" name="firstname" required></td>
                    <td>
                        <p id="fnameerror"></p>
                    </td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input type="text" id="lname" name="lastname" required></td>
                    <td>
                        <p id="lnameerror"></p>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" id="email" name="email" required></td>
                    <td>
                        <p id="emailerror"></p>
                    </td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><input type="tel" id="phone" name="phone" required></td>
                    <td>
                        <p id="phoneerror"></p>
                    </td>
                </tr>
                <tr>
                    <td>Date of Birth:</td>
                    <td><input type="date" id="dob" name="dob" required></td>
                    <td>
                        <p id="doberror"></p>
                    </td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td>
                        <input type="radio" name="gender" value="male" required>Male
                        <input type="radio" name="gender" value="female">Female
                        <input type="radio" name="gender" value="other">Other

                    </td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><textarea id="address" name="address" rows="3" cols="20" required></textarea></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" id="pass" name="pass" required></td>
                </tr>
                <tr>
                    <td>Re-Enter Password:</td>
                    <td><input type="password" id="repass" name="repass" required></td>
                    <td>
                        <p id="passerror"></p>
                    </td>
                </tr>
                <tr>
                    <td>Upload Image:</td>
                    <td><input type="file" name="images" required></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="checkbox" id="policy" name="policy" required><b>
                            I accept all the terms, policies, and conditions.</b>
                    </td>
                </tr>
            </table>

            <input type="submit" name="submit" value="Sign UP">
            <input type="reset" name="reset" value="Reset">
            <a href="../../login.php">LOG IN HERE</a>
    </form>
    </fieldset>
</body>

</html>