<?php
include '../model/mydb.php';
$fname = $_POST["firstname"];
$lname = $_POST["lastname"];
$mail = $_POST["email"];
$phone = $_POST["phone"];
$dob = $_POST["dob"];
$gender = $_POST["gender"];
$address = $_POST["address"];
$password = $_POST["pass"];
$confirm_pass = $_POST["repass"];
$name = $fname . " " . $lname;
$fileName = basename($_FILES["images"]["name"]);

$tablename = "customer";

$db = new customerDB();
$con = $db->openCon();
$res = $db->findUserinsert($tablename, $mail, $con);

if (ctype_alpha($fname . $lname)) {
    if (!empty($mail) && preg_match("/@.+\.com$/", $mail)) {
        if ($password == $confirm_pass) {
            if (preg_match("/\d/", $password)) {
                if (isset($gender)) {
                    if ($res->num_rows == 0) {
                        if (isset($_FILES["images"]) && $_FILES["images"]["error"] === UPLOAD_ERR_OK) {
                            $uploadDir = "../resources/"; // Directory to save uploaded images
                            //$fileName = basename($_FILES["images"]["name"]); // Get original file name
                            $filePath = $uploadDir . $fileName;

                            // Move file to the upload directory
                            if (move_uploaded_file($_FILES["images"]["tmp_name"], $filePath)) {
                                echo "Image uploaded successfully: $fileName<br>";
                            } else {
                                echo "Error uploading the image. Please try again.<br>";
                                exit;
                            }
                        } else {
                            echo "No file uploaded or an error occurred.<br>";
                            exit;
                        }

                        $result = $db->addUser($tablename, $name, $mail, $dob, $gender, $address, $password, $phone, $fileName, $con);
                        header("LOCATION: ../../login.php");
                    } else {
                        echo "Email already taken.<br>";
                        echo '<a href="../view/customer_signup.php">RETRY SIGNUP</a>';
                    }

                } else {
                    echo "Please Select Gender.<br>";
                }
            } else {
                echo "Password must contain at least one numeric character.<br>";
            }
        } else {
            echo "Password not matched.<br>";
        }
    } else {
        echo "Enter Valid Email with Domain .xyz.<br>";
    }
} else {
    echo "Name Should not Contain any numeric value.<br>";
}
?>