<?php
session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Edit</title>
    <link rel="stylesheet" href="../style/edit_profile.css">
    <script src="../js/myjs.js"></script>
</head>
<body>
    <h2>Profile Edit</h2>
    <a href="customer_homepage.php"><button type="button">Homepage</button></a>
    <a href="customer_profile.php"><button type="button">Back</button></a>
    <a href="../../logout_control.php"><button type="button">Log Out</button></a>
    
    <form action="../control/edit_control.php" method="POST" onsubmit="return profilevalidation()">
        <fieldset id="personalInformation">
            <legend><h3>Personal Information</h3></legend>
            
            <table>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" id="name" name="name"></td>
                    <td><p id="nameerror"></p></td>
                </tr>
                <tr>
                    <td>Phone:</td>
                    <td><input type="tel" id="phone" name="phone"></td>
                    <td><p id="phoneerror"></p></td>
                </tr>
                <tr>
                    <td>Date of Birth:</td>
                    <td><input type="date" id="dob" name="dob"></td>
                    <td><p id="doberror"></p></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><textarea id="address" name="address" rows="3" cols="20"></textarea></td>
                </tr>
            </table>
            
            <input type="submit" value="Update Profile">
            
            <input type="reset" value="Reset">
        </fieldset>
        </form>
        <button id="passChange" onclick="passwordChange()">Change Password</button>
        <form action="../control/edit_control.php" method="POST" onsubmit="return profilevalidation()">
        <fieldset id="changePassword">
                <legend><h3>Change Password</h3></legend>
                <table>
                    <tr>
                        <td>Current Password:</td>
                        <td><input type="password" id="current_password" name="current_password" placeholder="Current Password"></td>
                    </tr>
                    <tr>
                        <td>New Password:</td>
                        <td><input type="password" id="new_password" name="new_password" placeholder="New Password"></td>
                    </tr>
                    <tr>
                        <td>Confirm New Password:</td>
                        <td><input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm New Password"></td>
                    </tr>
                </table>
                <input type="submit" value="Update Password">
            
            <input type="reset" value="Reset">
            </fieldset>

            <br>
    </form>
    <button id="profileChange" onclick="profileChange()">Update Profile</button>
    
</body>
</html>
