<?php
class myDB
{
    function openCon() {
        $dbhost="localhost";
        $dbusername="root";
        $password="";
        $dbname="mydb";        
        $conn=new mysqli($dbhost, $dbusername, $password,$dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    function login($conn, $email, $password)
    {
        $sql="SELECT * FROM admin WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        return $result;
    }

    function newUser($conn, $name, $email, $password, $phone, $gender, $address)
    {
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password, phone, gender, address) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) 
        {
            $stmt->bind_param("sssiss", $name, $email, $password, $phone, $gender, $address);
            if ($stmt->execute()) 
            {
                return "New user added successfully.";
            } 
            else 
            {
                return "Error: " . $stmt->error;
            }
        } 
        else 
        {
            return "Error preparing statement: " . $conn->error;
        }
    }

    function viewall($conn)
    {
        $sql = "SELECT * FROM admin";
        $result = $conn->query($sql);
        return $result;

    }

    function viewbylike($conn)
    {
        $sql = "SELECT * FROM admin WHERE admin_id LIKE '%2%'";
        $result = $conn->query($sql);
        return $result;

    }

    function viewbyidname($conn)
    {
        $sql = "SELECT * FROM admin WHERE admin_id= 2 AND name LIKE '%Shahriar%'";
        $result = $conn->query($sql);
        return $result;

    }

}

?> 