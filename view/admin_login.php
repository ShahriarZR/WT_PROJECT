<!DOCTYPE html>
<html>

<head>
    <title>Admin Log in</title>
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
    </fieldset>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        include '../model/mydb.php';
        $db = new myDB();
        $conn = $db->openCon();
        $result = $db->login($conn, $_POST["email"], $_POST["password"]);
        if ($result && $result->num_rows > 0) {
            $admin = $result->fetch_assoc();
            $_SESSION["admin_email"] = $admin["email"];
            $_SESSION["admin_name"] = $admin["name"];
            header("LOCATION: ../view/admin_panel.php");
        } else {
            echo "Wrong Email/Password";
        }
    }
    ?>
</body>
</html>