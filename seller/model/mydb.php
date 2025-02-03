<?php
class sellerDB
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


    //Seller Model
    function loginSeller($conn, $email, $password)
    {
        $sql = "SELECT * FROM seller WHERE shop_email='$email' AND password='$password'";
        $result = $conn->query($sql);
        return $result;
    }

    function newSeller($conn, $name, $email, $shopName, $tradeLicenseNumber, $shopAddress, $password, $phone)
    {
        $stmt = $conn->prepare("INSERT INTO seller (name, shop_email, shop_name, trade_license_number, shop_Address, password, shop_phone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssissi", $name, $email, $shopName, $tradeLicenseNumber, $shopAddress, $password, $phone);
            if ($stmt->execute()) {
                return "New seller added successfully.";
            } else {
                return "Error: " . $stmt->error;
            }
        } else {
            return "Error preparing statement: " . $conn->error;
        }
    }
    function sellerAddNewAccessory($conn, $seller_id, $name, $description, $price, $stock)
    {
        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO approve_travel_accessory (seller_id, name, description, price, stock) VALUES (?, ?, ?, ?, ?)");

        // Check if the statement is prepared successfully
        if ($stmt) {
            // Bind the parameters to the statement
            $stmt->bind_param("issii", $seller_id, $name, $description, $price, $stock);

            // Execute the statement and check if it's successful
            if ($stmt->execute()) {
                return json_encode(["success" => true]);
            } else {
                return json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
            }
        } else {
            return json_encode(["success" => false, "message" => "Error preparing statement: " . $conn->error]);
        }
    }
    function sellerDeleteAccessory($conn, $travel_accessory_id)
    {
        $sql = "DELETE FROM travel_accessory WHERE travel_accessory_id = '$travel_accessory_id'";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            return "Accessory ID $travel_accessory_id deleted successfully.";
        } else {
            return "Error deleting Accessory ID $travel_accessory_id: " . $conn->error;
        }
    }
    function updateSellerPassword($conn, $currentEmail, $currentPassword, $newPassword)
    {
        // Verify current password
        $sql = "SELECT password FROM seller WHERE shop_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $currentEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $oldPassword = $row["password"];

            if ($currentPassword !== $oldPassword) {
                return json_encode(["success" => false, "message" => "Current password is incorrect."]);
            }

            // Update to the new password
            $newSql = "UPDATE seller SET password = ? WHERE shop_email = ?";
            $stmt = $conn->prepare($newSql);
            $stmt->bind_param("ss", $newPassword, $currentEmail);

            if ($stmt->execute()) {
                return json_encode(["success" => true, "message" => "Password updated successfully."]);
            } else {
                return json_encode(["success" => false, "message" => "Failed to update password."]);
            }
        } else {
            return json_encode(["success" => false, "message" => "Admin not found."]);
        }
    }
    function getSellerDetails($conn, $email)
    {
        $sql = "SELECT name, shop_email, shop_name, trade_license_number, shop_address, password, shop_phone FROM seller WHERE shop_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return json_encode([
                "success" => true,
                "name" => $row["name"],
                "shop_email" => $row["shop_email"],
                "shop_name" => $row["shop_name"],
                "trade_license_number" => $row["trade_license_number"],
                "shop_address" => $row["shop_address"],
                "shop_phone" => $row["shop_phone"]
            ]);
        } else {
            return json_encode(["success" => false, "message" => "Seller not found."]);
        }
    }
    function checkSellerEmailExists($conn, $email)
    {
        $emailCheckQuery = "SELECT * FROM seller WHERE shop_email = ?";
        $stmt = $conn->prepare($emailCheckQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    function registerNewSeller($conn, $name, $email, $shopName, $tradeLicenseNumber, $shopAddress, $password, $phone)
    {
        $insertQuery = "INSERT INTO seller (name, shop_email, shop_name, trade_license_number, shop_address, password, shop_phone) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssssss", $name, $email, $shopName, $tradeLicenseNumber, $shopAddress, $password, $phone);
        return $stmt->execute();
    }
    function sellerInsertApproveAccessory($conn, $seller_id, $travel_accessory_id, $name, $description, $price, $stock)
    {
        $sql = "INSERT INTO approve_travel_accessory (approve_travel_accessory_id, seller_id, name, description, stock, price) 
            VALUES ('$travel_accessory_id', '$seller_id', '$name', '$description', '$stock', '$price')";

        if ($conn->query($sql) === TRUE) {
            $sqlDel = "DELETE FROM travel_accessory WHERE travel_accessory_id = '$travel_accessory_id'";
            return $conn->query($sqlDel) === TRUE;
        } else {
            return false;
        }
    }

    function getSellerIdByEmail($conn, $seller_email)
    {
        $sqlEmail = "SELECT seller_id FROM seller WHERE email = '$seller_email'";
        $result = $conn->query($sqlEmail);
        $row = $result->fetch_assoc();
        return $row["seller_id"];
    }
    function updateSellerProfile($conn, $shop_email, $name, $shop_name, $trade_license_number, $shop_address, $shop_phone)
    {
        $sql = "UPDATE seller SET name = ?, shop_name = ?, trade_license_number = ?, shop_address = ?, shop_phone = ? WHERE shop_email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $shop_name, $trade_license_number, $shop_address, $shop_phone, $shop_email);

        return $stmt->execute();
    }
    function sellerGetTravelAccessories($conn, $name = '')
    {
        // Build the query
        if (!empty($name)) {
            $name = $conn->real_escape_string($name);
            $sql = "SELECT travel_accessory_id, name, description, price, stock FROM travel_accessory WHERE name = '$name'";
        } else {
            $sql = "SELECT travel_accessory_id, name, description, price, stock FROM travel_accessory";
        }

        $result = $conn->query($sql);
        $rows = [];

        // Fetch the results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }
}
