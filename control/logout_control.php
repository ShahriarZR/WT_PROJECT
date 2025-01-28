<?php
session_start();
session_destroy();
header("Location: ../view/employee_login.php");
exit();
?>
