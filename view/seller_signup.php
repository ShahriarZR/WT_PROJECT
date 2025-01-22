<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Registration</title>
    <script src="../js/myjs.js"> </script>
   
</head>
<body>
    <h2>Seller Registration Form</h2>
    <form action="../control/seller_regControl.php" method="POST" onsubmit="return validateForm()">
        
        <fieldset>
            <legend>Seller Information</legend>
            <table>
            <tr>
                    <td>Name:</td>
                    <td><input type="text" name="name" required></td>
                </tr>
                <tr>
                    <td>Shop/Company Name:</td>
                    <td><input type="text" name="shop_name" required></td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><textarea name="address" rows="3" cols="20" required></textarea></td>
                </tr>
               
                <tr>
                    <td>Email Address:</td>
                    <td><input type="email" name="email" required></td>
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td><input type="tel" name="phone" id="phn" required></td>
                </tr>
               
                <tr>
                    <td>Trade License Number:</td>
                    <td><input type="text" name="trade_license" id="license" required></td>
                </tr>
                
            </table>
        </fieldset>
        <fieldset>
            <legend>Product Details</legend>
            <table>
                
                <tr>
                    <td>Number of Products:</td>
                    <td><input type="number" name="product_count" id="nop" required ></td>
                </tr>
            </table>
        </fieldset>
        <fieldset>
            <legend>Account Details</legend>
            <table>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="pass" required></td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="confirm_password" required></td>
                </tr>
            </table>
        </fieldset>
        <input type="submit" value="Register as Seller">
        <input type="reset" value="Clear Form">
    </form>
    
</body>
</html>
