
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <h2>Home Page</h2>
    <form action="../control/product_control.php" method="POST">
        <fieldset>
            <legend>Product Information</legend>
            <table>
                <tr>
                    <td>Product Name: </td>
                    <td>
                        <input type="text" name="name" required>
                    </td>
                </tr>
                <tr>
                    <td> Description:</td>
                    <td>
                        <textarea name="description" rows="3" cols="20"></textarea>
                    </td>
                </tr>
                <tr>
                    <td> Price: </td>
                    <td>
                        <input type="text" name="price" required>
                    </td>
                </tr>
                <tr>
                    <td> Stock:</td>
                    <td>
                        <input type="text" name="stock" required>
                    </td>
                </tr>
            </table>
            <input type="submit" value="ADD">
        </fieldset>
    </form>


    <form method="POST">
        <br>
        <input type="submit" name="action" value="View All">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
        include '../model/db.php';
 
        $db = new myDB();
        $con=$db->openCon();
        $result = $db->viewall("travel_accessory", $con);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "Name: " . $row["name"];
            }
        } else {
            echo "no result";
        }
    }
    ?>
    <script> src="../js/myjs.js"</script>
</body>

</html>