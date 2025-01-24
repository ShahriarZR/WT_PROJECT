<?php
include '../model/db.php';
$fname = $_POST["firstname"];
$lname = $_POST["lastname"];
$mail = $_POST["email"];
$phone=$_POST["phone"];
$dob=$_POST["dob"];
$gender=$_POST["gender"];
$address=$_POST["address"];
$password = $_POST["pass"];
$confirm_pass = $_POST["repass"];
$name=$fname." ".$lname;
$tablename="customer";

$db=new mydb();
$con=$db->openCon();
$res=$db->findUserinsert($tablename,$mail,$con);

if (ctype_alpha($fname . $lname)) {
    if (!empty($mail) && preg_match("/@.+\.com$/", $mail)) {
        if ($password == $confirm_pass) {
            if (preg_match("/\d/", $password)) {
                if (isset($gender)) 
                {
                    if($res->num_rows==0)
                    {
                        echo "Successfully Signed Up.<br>";
                        echo "Welcome " . $fname . "<br>";
                        $result = $db->addUser($tablename,$name,$mail,$dob,$gender,$address,$password,$phone,$con);
                        echo '<a href="../view/customer_login.php">LOGIN HERE</a>';
                    }
                    else
                    {
                        echo "Email already taken.<br>";
                        echo '<a href="../view/customer_signup.php">RETRY SIGNUP</a>';
                    }
                    
                } else {
                    echo "Please Select Gender.<br>";
                }
            } else {
                echo "Password must contain at least one numeric character.<br>";
            }
        } else {
            echo "Password not matched.<br>";
        }
    } else {
        echo "Enter Valid Email with Domain .xyz.<br>";
    }
} else {
    echo "Name Should not Contain any numeric value.<br>";
}
?>