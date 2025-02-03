<!DOCTYPE html>
<html lang="en">

<head>
    <title>Seller Registration</title>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../js/myjs.js"></script>
</head>

<body>
    <h1>Seller Registration</h1>
    <fieldset>
        <legend>
            <h3>New Seller</h3>
        </legend>
        <form onsubmit="return validateSellerForm()" method="POST" action="../control/seller_reg_control.php">
            <table>
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="name" id="sellerName"></td>
                    <td>
                        <p id="invalidSellerName"><?php echo ""; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Shop Email:</td>
                    <td><input type="email" name="email" id="sellerEmail"></td>
                    <td>
                        <p id="invalidSellerEmail"><?php echo ""; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Shop Name:</td>
                    <td><input type="text" name="shopName" id="sellerShopName"></td>
                    <td>
                        <p id="invalidSellerShopName"><?php echo ""; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Trade License Number:</td>
                    <td><input type="text" name="tradeLicenseNumber" id="sellerTradeLicense"></td>
                    <td>
                        <p id="invalidSellerTradeLicense"><?php echo ""; ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Shop Address:</td>
                    <td>
                        <textarea name="address" rows="3" cols="20"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td><input type="text" name="phone" id="sellerPhone"></td>
                    <td>
                        <p id="invalidSellerPhone"><?php echo ""; ?></p>
                    </td>
                </tr>
                
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" id="sellerPassword"></td>
                    <td>
                        <p id="invalidSellerPassword"><?php echo "" ?></p>
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password:</td>
                    <td><input type="password" name="conf_password" id="sellerConf_password"></td>
                    <td>
                        <p id="invalidSellerConfPass"><?php echo ""; ?></p>
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