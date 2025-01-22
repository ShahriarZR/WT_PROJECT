<!DOCTYPE html>
<html>
<head>
    <title>Customer Registration</title>
</head>
<body>
<script src="../js/myscript.js"></script>
<form action="../control/reg_control.php" method="POST" onsubmit=" return isValidName()">
    <h2>Customer Registration Form</h2>
    <fieldset>
        <legend><h3>Personal Information</h3></legend>
        <table>
            <tr>
                <td>First Name:</td>
                <td><input type="text" id="fname" name="firstname"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" id="lname" name="lastname" ></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="text" id="email" name="email" placeholder="email@example.com"></td>
            </tr>
            <tr>
                <td>Phone:</td>
                <td><input type="number" name="phone" placeholder="01234567890"></td>
            </tr>
            <tr>
                <td>Date of Birth:</td>
                <td><input type="date" id="dob" name="dob"></td>
            </tr>
            <tr>
                <td>Gender:</td>
                <td>
                    <input type="radio" name="gender" value="male">Male
                    <input type="radio" name="gender" value="female">Female
                    <input type="radio" name="gender" value="other">Other

                </td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><textarea id="address" name="address" rows="3" cols="20"></textarea></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="pass" placeholder="ex-UsER@456" ></td>
            </tr>
            <tr>
                <td>Re-Enter Password:</td>
                <td><input type="password" name="repass" placeholder="********" ></td>
            </tr>
        </table>
        <input type="radio" name="" value=""> I accept all the terms,policies and conditions.<br>
        <input type="submit" name="submit" value="Sign UP">
        <input type="reset" name="reset" value="Reset">
        <a href="../view/customer_login.php">LOG IN HERE</a>
</form>
</fieldset>   
<input type="type" id="input" onkeyup="printText()">
<p id="print"></p>
<button onclick="printText()">Click</button>
</body>
</html>