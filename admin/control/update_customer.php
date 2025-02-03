<?php
/* session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: login.php");
    exit();
}
include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (is_array($data) && count($data) > 0) {
        $db = new myDB();
        $conn = $db->openCon();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        foreach ($data as $customer) {
            $customer_id = $conn->real_escape_string($customer['customer_id']);
            $name = $conn->real_escape_string($customer['name']);
            $email = $conn->real_escape_string($customer['email']);
            $dob = $conn->real_escape_string($customer['dob']);
            $gender = $conn->real_escape_string($customer['gender']);
            $address = $conn->real_escape_string($customer['address']);
            $password = $conn->real_escape_string($customer['password']);
            $phone = $conn->real_escape_string($customer['phone']);
            $image_name = basename($_FILES['c_image']['name']);

            if (isset($_FILES['c_image']) && $_FILES['c_image']['error'] == 0) {
                $target_dir = "../resources/";
    
                $target_file = $target_dir . $image_name;
                if (move_uploaded_file($_FILES['c_image']['tmp_name'], $target_file)) {
                    $c_image = $image_name;
                } else {
                    echo "Error uploading image.";
                    exit();
                }
            } else {
                $c_image = $conn->real_escape_string($data['c_image']);
            }

            $sql = "UPDATE customer SET 
                name = '$name', 
                email = '$email',
                dob = '$dob',
                gender = '$gender', 
                address = '$address',
                password = '$password',
                phone = '$phone',
                c_image = '$c_image'          
            WHERE customer_id = '$customer_id'";

            if ($conn->query($sql) === TRUE) {
                echo "Customer ID $customer_id updated successfully.";
            } else {
                echo "Error updating customer ID $customer_id: " . $conn->error;
            }
        }
        $conn->close();
    } else {
        echo "Invalid request.";
    }
} */
?>



<?php
session_start();
if (!isset($_SESSION["admin_email"])) {
    header("Location: ../../login.php");
    exit();
}

include '../model/mydb.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new adminDB();
    $conn = $db->openCon();

    $customer_id = $conn->real_escape_string($_POST['customer_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $address = $conn->real_escape_string($_POST['address']);
    $password = $conn->real_escape_string($_POST['password']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $c_image = ""; // Default value if no new image is uploaded

    // Check if a new image is uploaded
    if (isset($_FILES['c_image']) && $_FILES['c_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../resources/";
        $c_image = basename($_FILES["c_image"]["name"]);
        $targetFilePath = $uploadDir . $c_image;

        if (move_uploaded_file($_FILES["c_image"]["tmp_name"], $targetFilePath)) {
            echo "Image uploaded successfully: $c_image<br>";
        } else {
            echo "Error uploading image. Please try again.<br>";
            exit;
        }
    } else {
        // If no new image is uploaded, keep the existing one
        $sql = "SELECT c_image FROM customer WHERE customer_id = '$customer_id'";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $c_image = $row['c_image'];
        }
    }

    // Update Customer Data
    $sql = "UPDATE customer SET 
        name = '$name', 
        email = '$email',
        dob = '$dob',
        gender = '$gender', 
        address = '$address',
        password = '$password',
        phone = '$phone',
        c_image = '$c_image' 
        WHERE customer_id = '$customer_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Customer ID $customer_id updated successfully.";
    } else {
        echo "Error updating customer ID $customer_id: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>



