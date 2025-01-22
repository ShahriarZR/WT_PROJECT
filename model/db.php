<?php

class mydb{
    function openCon() {
        $dbhost="localhost";
        $dbusername="root";
        $dbpassword="";
        $dbname="mydb";        
        $conn=new mysqli($dbhost, $dbusername, $dbpassword,$dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    

    function addSeller($table_name, $name, $email, $shop_name, $address,$password, $phone, $tradeLicenseNo,$noOfProducts , $connobject) {
        $sql = "INSERT INTO $table_name (name, email, shop_name, address, password, phone, tradeLicenseNo,noOfProducts) VALUES('$name', '$email', '$shop_name', '$address','$password',' $phone',' $tradeLicenseNo','$noOfProducts' )";
        return $connobject->query($sql);
       
    }
    function findUser($table,$email,$pass,$connobject)
    {
        $sql="SELECT email,password FROM $table WHERE email='$email' AND password='$pass'";
        return $connobject->query($sql);
    }
    function addProduct($table_name,$name, $description, $price, $stock,  $connobject) {
        $sql = "INSERT INTO $table_name (name, description, price, stock,seller_id) VALUES('$name',  '$description', '$price',' $stock', 4)";
        return $connobject->query($sql);
       
    }
    function findSeller($tradeLicense,  $connobject) {
        $sql = "SELECT seller_id from  seller  WHERE tradeLicenseNo=$tradeLicense";
        return $connobject->query($sql);
       
    }

    function viewall($table_name, $connobject) {
        $sql = "SELECT * FROM $table_name ";
        return $connobject->query($sql);
       
    }
}
?>