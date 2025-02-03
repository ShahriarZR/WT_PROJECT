<?php
/*session_start();
if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}*/
require '../control/customer_profile_control.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="../style/profile.css">
</head>

<body>
    <form>
            <a href="../view/customer_homepage.php">
                <button type="button">Back</button>
            </a>
            <a href="../../logout_control.php">
                <button type="button">LOG OUT</button>
            </a>

        <fieldset>

            <legend>
                <h2>My Profile</h2>
            </legend>
            <table>
                <?php
                while ($row = $c_result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>Customer ID :</td>';
                    echo '<td>' . htmlspecialchars($row["customer_id"]) . '</td>';
                    $_Session["c_id"]=htmlspecialchars($row["customer_id"]);
                    echo '<td rowspan="7" align="center">
              <img src="../resources/' . htmlspecialchars($row["c_image"]) . '" alt="Profile Picture" width="400" height="300"></td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Name :</td>';
                    echo '<td>' . htmlspecialchars($row["name"]) . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Email :</td>';
                    echo '<td>' . htmlspecialchars($row["email"]) . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Date Of Birth :</td>';
                    echo '<td>' . htmlspecialchars($row["dob"]) . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Gender :</td>';
                    echo '<td>' . htmlspecialchars($row["gender"]) . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Address :</td>';
                    echo '<td>' . htmlspecialchars($row["address"]) . '</td>';
                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>Phone :</td>';
                    echo '<td>0' . htmlspecialchars($row["phone"]) . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <p>
                <a href="customer_editprofile.php">
                    <button type="button">Edit</button>
                </a>
            </p>



        </fieldset>
    </form>

</body>

</html>