<?php
include '../model/db.php';
$fname = $_POST["firstname"];
$lname = $_POST["lastname"];
$mail = $_POST["email"];
//$phone=$_POST["phone"];
$dob=$_POST["dob"];
/*$gender=$_POST["gender"];
$address=$_POST["address"];
$password = $_POST["pass"];
$confirm_pass = $_POST["repass"];
$name=$fname." ".$lname;
$tablename="customer";*/

//$db=new mydb();
//$con=$db->openCon();
//$res=$db->findUserinsert($tablename,$mail,$con);



                        echo "Successfully Signed Up.<br>";
                        echo "Welcome " . $fname . "<br>";
                        //$result = $db->addUser($tablename,$name,$mail,$dob,$gender,$address,$password,$phone,$con);
                        echo '<a href="../view/customer_login.php">LOGIN HERE</a>';

/*if (ctype_alpha($fname . $lname)) {
    if (!empty($mail) && preg_match("/@.+\.xyz$/", $mail)) {
        if ($password == $confirm_pass) {
            if (preg_match("/\d/", $password)) {
                if (isset($_POST["gender"])) 
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
}*/


/*
TABLE CREATION:
$res = $db->tablecreation($tablename,$con);
if($res)
{	echo "table created successfully";	}
else 
{	echo "error occurred“.$connerror;	}
*/

/*$formdata = array('firstName' => $_POST['firstname'],'lastName' => $_POST['lastname'],
'email' => $_POST['email'],'mobile' => $_POST['phone'],'date of birth' => $_POST['dob'],
'gender' => $_POST['gender'],'address' => $_POST['address']);

$jsondata = json_encode($formdata, JSON_PRETTY_PRINT);

if (file_put_contents("../data/userdata.json", $jsondata)) {

    echo 'Data successfully saved in json.';

} else {

    echo "no data saved";
}*/
?>