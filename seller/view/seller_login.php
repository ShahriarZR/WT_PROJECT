<!DOCTYPE html>
<html>

<head>
    <title>Seller Log in</title>
</head>

<body>
    <fieldset>
        <legend>
            <h3>Log In</h3>
        </legend>
        <form method="POST">
            <table>
                <tr>
                    <td>Email:</td>
                    <td><input type="email" name="email" id=""></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" value="Submit">
                    </td>
                </tr>
            </table>
        </form>
        <a href="seller_reg.php">Become a Seller</a>
    </fieldset>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        include '../model/mydb.php';
        $db = new sellerDB();
        $conn = $db->openCon();
        $result = $db->loginSeller($conn, $_POST["email"], $_POST["password"]);
        if ($result && $result->num_rows > 0) {
            $seller = $result->fetch_assoc();
            $_SESSION["seller_email"] = $seller["shop_email"];
            $_SESSION["seller_name"] = $seller["name"];
            header("LOCATION: seller_panel.php");
        } else {
            echo "Wrong Email/Password";
        }
    }
    ?>
</body>
</html>