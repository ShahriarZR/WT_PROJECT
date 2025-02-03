<?php
session_start();
if(session_destroy())
{
    header("Location: customer/view/customer_login.php");
}
?>