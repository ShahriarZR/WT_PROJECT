<?php
class myDB
{
    function openCon()
    {
        $dbhost = "localhost";
        $dbusername = "root";
        $password = "";
        $dbname = "mydb";
        $conn = new mysqli($dbhost, $dbusername, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
    function loginEmployee($conn, $email, $password)
    {
        $sql = "SELECT * FROM employee WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        return $result;
    }
}
