<?php
$fname=$_POST["firstname"];
$lname=$_POST["lastname"];
$mail=$_POST["email"];
$password=$_POST["pass"];
$confirm_pass=$_POST["repass"];


if(!ctype_alpha($fname.$lname))
{
    echo "Name Should not Contain any numeric value.<br>";
}
if(empty($mail))
{
    echo "Email Required.<br>";
}
if(!empty($mail) && !preg_match("/@.+\.xyz$/", $mail))
{
    echo "Enter Valid Email with Domain .xyz.<br>";
} 
if($password==$confirm_pass)
{
if (!preg_match("/\d/", $password)) {
    echo "Password must contain at least one numeric character.<br>";
}} 
if(isset($_POST["gender"]) )
{
    echo "check box is checked.<br>";
}
else
{
    echo "You must select gender.<br>";
}

?>