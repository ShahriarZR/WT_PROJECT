<!DOCTYPE html>
<html>

<head>
    <title>Employee Log in</title>
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
        <a href="employee_checkNewEmail.php">Sign Up As Employee</a>
    </fieldset>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        include '../model/mydb.php';
        $db = new employeeDB();
        $conn = $db->openCon();
        $result = $db->loginEmployee($conn, $_POST["email"], $_POST["password"]);
        if ($result && $result->num_rows > 0) {
            $employee = $result->fetch_assoc();
            $_SESSION["employee_email"] = $employee["email"];
            $_SESSION["employee_name"] = $employee["name"];
            header("LOCATION: ../view/employee_panel.php");
        } else {
            echo "Wrong Email/Password";
        }
    }
    ?>
</body>
</html>