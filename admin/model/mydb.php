<?php
class adminDB
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

    function loginAdmin($conn, $email, $password)
    {
        $sql = "SELECT * FROM admin WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);
        return $result;
    }

    function newAdmin($conn, $name, $email, $password, $phone, $gender, $address)
    {
        $stmt = $conn->prepare("INSERT INTO admin (name, email, password, phone, gender, address) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssiss", $name, $email, $password, $phone, $gender, $address);
            if ($stmt->execute()) {
                return "New user added successfully.";
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error preparing statement: " . $conn->error;
        }
    }
    function adminAddCustomer($conn, $name, $email, $dob, $password, $phone, $gender, $address, $c_image)
    {
        $sql = "INSERT INTO customer (name, email, dob, password, phone, gender, address, c_image) VALUES ('$name', '$email', '$dob', '$password', '$phone', '$gender', '$address', '$c_image')";
        return $conn->query($sql);
    }
    function adminAddEmployee($conn, $name, $email, $password, $phone, $gender, $address, $position)
    {
        $sql = "INSERT INTO employee (name, email, password, phone, gender, address, position) VALUES ('$name', '$email', '$password', '$phone', '$gender', '$address', '$position')";
        return $conn->query($sql);
    }
    function tempAdmin($conn, $email)
    {
        $sql = "INSERT INTO temp_admin (email) VALUES ('$email')";
        return $conn->query($sql);
    }
    function tempEmployee($conn, $email)
    {
        $sql = "INSERT INTO temp_employee (email) VALUES ('$email')";
        return $conn->query($sql);
    }
    function adminAddSeller($conn, $name, $email, $shop_name, $address, $password, $phone)
    {
        $sql = "INSERT INTO admin_seller (name, email, shop_name, address, password, phone) 
                VALUES ('$name', '$email', '$shop_name', '$address', '$password', '$phone')";
        return $conn->query($sql);
    }
    function getTempAdmin($conn, $email)
    {
        $sql = "SELECT * FROM temp_admin WHERE email = '$email'";
        return $conn->query($sql);
    }
    function adminApproveTravelAccessory($conn)
    {
        $sql = "SELECT * FROM approve_travel_accessory";
        return $conn->query($sql);
    }
    function adminApproveTourPackage($conn)
    {
        $sql = "SELECT * FROM approve_tour_package";
        return $conn->query($sql);
    }
    function deleteAdmin($conn, $admin_id)
    {
        $sql = "DELETE FROM admin WHERE admin_id = '$admin_id'";
        return $conn->query($sql);
    }

    function checkAdminPassword($conn, $admin_email, $currentPassword)
    {
        $sql = "SELECT password FROM admin WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row["password"] === $currentPassword;
        }
        return false;
    }

    function changeAdminPassword($conn, $admin_email, $newPassword)
    {
        $sql = "UPDATE admin SET password = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newPassword, $admin_email);
        return $stmt->execute();
    }
    function adminProfileControl($conn, $admin_email)
    {
        $sql = "SELECT name, email, phone, gender, address FROM admin WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    function adminDeleteApproveTourPackage($conn, $approve_tour_package_id)
    {
        $sql = "DELETE FROM approve_tour_package WHERE approve_tour_package_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $approve_tour_package_id);

        return $stmt->execute();
    }
    function adminDeleteApproveTravelAccessory($conn, $approve_travel_accessory_id)
    {
        $sql = "DELETE FROM approve_travel_accessory WHERE approve_travel_accessory_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $approve_travel_accessory_id);

        return $stmt->execute();
    }
    function adminDeleteCustomer($conn, $customer_id)
    {
        $sql = "DELETE FROM customer WHERE customer_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);

        return $stmt->execute();
    }
    function adminDeleteEmployee($conn, $employee_id)
    {
        // Delete related tour packages
        $sqlDelPackageT = "DELETE FROM tour_package WHERE employee_id = ?";
        $stmtT = $conn->prepare($sqlDelPackageT);
        $stmtT->bind_param("i", $employee_id);
        $stmtT->execute();

        // Delete related approved tour packages
        $sqlDelPackageA = "DELETE FROM approve_tour_package WHERE employee_id = ?";
        $stmtA = $conn->prepare($sqlDelPackageA);
        $stmtA->bind_param("i", $employee_id);
        $stmtA->execute();

        // Delete employee record
        $sql = "DELETE FROM employee WHERE employee_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $employee_id);

        return $stmt->execute();
    }
    function adminDeleteSeller($conn, $seller_id)
    {
        // Delete related travel accessories
        $sqlDelAccessory = "DELETE FROM travel_accessory WHERE seller_id = ?";
        $stmtAccessory = $conn->prepare($sqlDelAccessory);
        $stmtAccessory->bind_param("i", $seller_id);
        $stmtAccessory->execute();

        // Delete related approved travel accessories
        $sqlDelApprovedAccessory = "DELETE FROM approve_travel_accessory WHERE seller_id = ?";
        $stmtApprovedAccessory = $conn->prepare($sqlDelApprovedAccessory);
        $stmtApprovedAccessory->bind_param("i", $seller_id);
        $stmtApprovedAccessory->execute();

        // Delete seller record
        $sql = "DELETE FROM seller WHERE seller_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $seller_id);

        return $stmt->execute();
    }
    function adminInsertApproveTourPackage($conn, $package) {
        $approve_tour_package_id = $conn->real_escape_string($package['approve_tour_package_id']);
        $name = $conn->real_escape_string($package['name']);
        $description = $conn->real_escape_string($package['description']);
        $status = $conn->real_escape_string($package['status']);
        $price = $conn->real_escape_string($package['price']);
        $employee_id = $conn->real_escape_string($package['employee_id']);
    
        // Insert query to approve the package
        $sql = "INSERT INTO tour_package (tour_package_id, tour_package_name, tour_package_description, tour_package_status, tour_package_price, employee_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssdi", $approve_tour_package_id, $name, $description, $status, $price, $employee_id);
    
        if ($stmt->execute()) {
            // Delete from approve_tour_package
            $sqlDel = "DELETE FROM approve_tour_package WHERE approve_tour_package_id = ?";
            $stmtDel = $conn->prepare($sqlDel);
            $stmtDel->bind_param("i", $approve_tour_package_id);
            
            if ($stmtDel->execute()) {
                return "Package approved successfully.";
            }
        } 
        return "Error approving package: " . $conn->error;
    }
    function adminInsertApproveTravelAccessory($conn, $package) {
        $approve_travel_accessory_id = $conn->real_escape_string($package['approve_travel_accessory_id']);
        $name = $conn->real_escape_string($package['name']);
        $description = $conn->real_escape_string($package['description']);
        $price = $conn->real_escape_string($package['price']);
        $stock = $conn->real_escape_string($package['stock']);
        $seller_id = $conn->real_escape_string($package['seller_id']);
    
        // Insert query to approve the travel accessory
        $sql = "INSERT INTO travel_accessory (travel_accessory_id, name, description, price, stock, seller_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issdii", $approve_travel_accessory_id, $name, $description, $price, $stock, $seller_id);
    
        if ($stmt->execute()) {
            // Delete from approve_travel_accessory
            $sqlDel = "DELETE FROM approve_travel_accessory WHERE approve_travel_accessory_id = ?";
            $stmtDel = $conn->prepare($sqlDel);
            $stmtDel->bind_param("i", $approve_travel_accessory_id);
            
            if ($stmtDel->execute()) {
                return "Accessory approved successfully.";
            }
        }
        return "Error approving accessory: " . $conn->error;
    }
}
