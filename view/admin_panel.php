<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
</head>

<body>
    <h1>Admin</h1>
    <form method="POST">
        <table>
            <tr>
                <td>Choose Action: </td>
                <td><input type="radio" name="action" value="viewall">View All
                    <input type="radio" name="action" value="viewby">View By
                    <input type="radio" name="action" value="and">And
                </td>
            </tr>
        </table>
        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
        include '../model/mydb.php';

        $action = $_POST["action"];
        if ($action === "viewall") {
            $db = new myDB();
            $conn = $db->openCon();
            $result = $db->viewall($conn);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "Serial: " . $row["admin_id"]." "."Name: " . $row["name"]." "."Email: " . $row["email"]." "."Phone: " . $row["phone"]." "."Gender: " . $row["gender"]." "."Address: " . $row["address"];
                }
            } else {
                echo "no result";
            }

            $conn->close();
        } elseif($action === "viewby") {
            $db = new myDB();
            $conn = $db->openCon();
            $result = $db->viewbylike($conn);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "Password: " . $row["password"];
                }
            } else {
                echo "no result";
            }

            $conn->close();
        }
        elseif($action === "and") {
            $db = new myDB();
            $conn = $db->openCon();
            $result = $db->viewbyidname($conn);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "Phone: " . $row["phone"];
                }
            } else {
                echo "no result";
            }

            $conn->close();
        }
        else{
            echo "Please select one action";
        }
    }
    ?>

</body>

</html>