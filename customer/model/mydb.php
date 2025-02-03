<?php
class customerDB
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

    /* Customer Model */
    function loginCustomer($conn, $email, $password)
    {
        $sql = "SELECT * FROM customer WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        return $result;
    }
    function addUser($table, $name, $email, $dob, $gender, $address, $password, $phone, $fileName, $connobject)
    {
        $sql = "INSERT INTO $table (name, email, dob, gender, address,password,phone,c_image) VALUES ('$name','$email', '$dob', '$gender', '$address', '$password',$phone,'$fileName')";
        return $connobject->query($sql);
    }
    function findUser($table, $email, $pass, $connobject)
    {
        $sql = "SELECT * FROM $table WHERE email='$email' AND password='$pass'";
        return $connobject->query($sql);
    }
    function findUserinsert($table, $email, $connobject)
    {
        $sql = "SELECT * FROM $table WHERE email='$email'";
        return $connobject->query($sql);
    }
    function findPackage($table, $connobject)
    {
        $sql = "SELECT * FROM $table";
        return $connobject->query($sql);
    }
    function findAccessory($table, $connobject)
    {
        $sql = "SELECT * FROM $table";
        return $connobject->query($sql);

    }
    function updateUser($table, $name, $dob, $mail, $gender, $address, $phone, $connobject)
    {
        $sql = "UPDATE $table SET name = '$name', dob = '$dob', gender = '$gender', address = '$address', phone = '$phone' WHERE email = '$mail'";
        return $connobject->query($sql);
    }
    function addCart($table, $c_id, $product_id, $product_quantity, $product_price,$total_price, $date, $product_name, $connobject)
    {
        $sql = "INSERT INTO $table (customer_id,travel_accessory_id,quantity,price,total_price,added_date,product_name) VALUES ('$c_id','$product_id','$product_quantity','$product_price','$total_price','$date','$product_name')";
        return $connobject->query($sql);
    }
    function collectCart($table, $c_id, $connobject)
    {
        $sql = "SELECT * FROM $table WHERE customer_id='$c_id'";
        return $connobject->query($sql);
    }
    function collectSold($table, $c_id, $connobject)
    {
        $sql = "SELECT * FROM $table WHERE c_id='$c_id'";
        return $connobject->query($sql);
    }
    function updateCart($table, $cart_id, $product_quantity,$total_price, $connobject)
    {
        $sql = "UPDATE $table SET quantity='$product_quantity',total_price='$total_price' WHERE cart_id='$cart_id'";
        return $connobject->query($sql);
    }
    function findPackages($table,$c_id,$package_id,$connobject)
    {
        $sql="SELECT * FROM $table where customer_id='$c_id' AND pkg_id='$$package_id'";
        return $connobject->query($sql);
    }
    function updatePkg($table,$c_id,$pk_id,$package_person,$pricepkg,$connobject)
    {
        $sql ="UPDATE $table SET total_person='$package_person',totalpkg_price='$pricepkg' WHERE customer_id='$c_id' AND pkg_id='$pk_id'";
        return $connobject->query($sql);
    }
    function findStock($table, $product_id, $connobject)
    {
        $sql = "SELECT * FROM $table WHERE travel_accessory_id='$product_id'";
        return $connobject->query($sql);
    }
    function updateAccessory($table,$p_id,$p_quantity,$connobject)
    {
        $sql = "UPDATE $table SET stock='$p_quantity' WHERE travel_accessory_id='$p_id'";
        return $connobject->query($sql);

    }
    function addSold($table,$p_name,$p_id,$c_id,$p_price,$p_quantity,$total,$connobject)
    {
        $sql = "INSERT INTO $table (p_name, p_id, c_id, p_price, p_quantity, total_price) VALUES ('$p_name','$p_id','$c_id','$p_price','$p_quantity','$total')";
        return $connobject->query($sql);
    }
    function removeCart($table,$cart_id,$connobject)
    {
        $sql="DELETE FROM $table WHERE cart_id='$cart_id'";
        return $connobject->query($sql);
    }
    function updateTemppkg($table,$pkg_id,$person,$total,$connobject)
    {
        $sql="UPDATE $table SET total_person='$person',totalpkg_price='$total' WHERE temp_pkg_id='$pkg_id'";
        return $connobject->query($sql);

    }
    function removePkg($table,$pkg_id,$connobject)
    {
        $sql="DELETE FROM $table WHERE pkg_id='$pkg_id'";
        return $connobject->query($sql);
    }
    function removeTempPKG($table,$pkg_id,$connobject)
    {
        $sql="DELETE FROM $table WHERE temp_pkg_id='$pkg_id'";
        return $connobject->query($sql);
    }
    function updatePassword($table, $password, $email, $connobject) {
        $sql = "UPDATE $table SET password = '$password' WHERE email = '$email'";
        return $connobject->query($sql);
    }
    function pkgAvailable($table,$package_id,$connobject)
    {
        $sql="SELECT * FROM $table WHERE tour_package_id='$package_id'";
        return $connobject->query($sql);

    }
    function addpkg($table, $c_id, $package_id, $package_person, $package_price,$total, $date, $package_name, $connobject)
    {
        $sql = "INSERT INTO $table (customer_id,pkg_id,total_person,pkg_price,totalpkg_price,booking_date,pkg_name) VALUES ('$c_id','$package_id','$package_person','$package_price','$total','$date','$package_name')";
        return $connobject->query($sql);
    }
}
