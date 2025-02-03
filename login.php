<!DOCTYPE html>
<html>

<head>
    <title>Log in</title>
    <link rel="stylesheet" type="text/css" href="customer/style/mainlogin.css">
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
        <a href="customer/view/customer_signup.php">New User</a><br>
        <a href="seller/view/seller_reg.php">Become a Seller</a><br>
        <a href="employee/view/employee_checkNewEmail.php">Sign Up As Employee</a><br>
        <a href="admin/view/admin_checkNewEmail.php">Sign Up As Admin</a>
    </fieldset>
    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        include 'admin/model/mydb.php';
        include 'seller/model/mydb.php';
        include 'employee/model/mydb.php';
        include 'customer/model/mydb.php';
        $db1 = new adminDB();
        $db2 = new customerDB();
        $db3 = new sellerDB();
        $db4 = new employeeDB();
        $conn1 = $db1->openCon();
        $conn2 = $db2->openCon();
        $conn3 = $db3->openCon();
        $conn4 = $db4->openCon();
        $adminResult = $db1->loginAdmin($conn1, $_POST["email"], $_POST["password"]);
        $employeeResult = $db4->loginEmployee($conn4, $_POST["email"], $_POST["password"]);
        $sellerResult = $db3->loginSeller($conn3, $_POST["email"], $_POST["password"]);
        $customerResult = $db2->loginCustomer($conn2, $_POST["email"], $_POST["password"]);
        
        if ($adminResult && $adminResult->num_rows > 0) {
            $admin = $adminResult->fetch_assoc();
            $_SESSION["admin_email"] = $admin["email"];
            $_SESSION["admin_name"] = $admin["name"];
            header("LOCATION: admin/view/admin_homepage.php");
        }
        else if($employeeResult && $employeeResult->num_rows > 0){
            $employee = $employeeResult->fetch_assoc();
            $_SESSION["employee_email"] = $employee["email"];
            $_SESSION["employee_name"] = $employee["name"];
            header("LOCATION: employee/view/employee_homepage.php");
        } 
        else if($sellerResult && $sellerResult->num_rows > 0){
            $seller = $sellerResult->fetch_assoc();
            $_SESSION["seller_email"] = $seller["shop_email"];
            $_SESSION["seller_name"] = $seller["name"];
            header("LOCATION: seller/view/seller_homepage.php");
        }
        else if($customerResult && $customerResult->num_rows > 0){
            $customer = $customerResult->fetch_assoc();
            $_SESSION["customer_email"] = $customer["email"];
            $_SESSION["customer_name"] = $customer["name"];
            $_SESSION["pass"] = $customer["password"];
            header("LOCATION: customer/view/customer_homepage.php");
        }
        else {
            echo "Wrong Email/Password";
        }
    }
    ?>
</body>
</html>