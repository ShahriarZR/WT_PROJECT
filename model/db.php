<?php

class mydb{
    function openCon() {
        $dbhost="localhost";
        $dbusername="root";
        $dbpassword="";
        $dbname="mydb";        
        $connobject=new mysqli($dbhost, $dbusername, $dbpassword,$dbname);
        return $connobject;
    }

    function tablecreation($tablename,$connobject)
    {
        $sql ="CREATE TABLE $tablename (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50))";
            return $connobject->query($sql);
    }

    function addUser($table, $name, $email, $dob, $gender, $address, $password, $phone, $connobject) {
        $sql = "INSERT INTO $table (name, email, dob, gender, address,password,phone) VALUES ('$name','$email', '$dob', '$gender', '$address', '$password',$phone)";
        return $connobject->query($sql);
    }

    function findUser($table,$email,$pass,$connobject)
    {
        $sql="SELECT email,password FROM $table WHERE email='$email' AND password='$pass'";
        return $connobject->query($sql);
    }
    function findUserinsert($table,$email,$connobject)
    {
        $sql="SELECT email FROM $table WHERE email='$email'";
        return $connobject->query($sql);
    }

    function findPackage($table,$connobject)
    {
        $sql="SELECT tour_package_name,tour_package_description,tour_package_status,tour_package_price,image FROM $table";
        return $connobject->query($sql);
    }

 
}

?>