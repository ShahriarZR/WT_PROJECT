<?php
require '../control/package_control.php';  // Include the control logic and DB connection

$rows = [];

// Fetch and store all rows from the result set
while ($row = $res->fetch_assoc()) {
    $rows[] = $row;  // Store each row in the $rows array
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tour Packages</title>
</head>
<body>
    
<fieldset>
    <legend><h2>Most Popular Travel Packages</h2></legend>
    <table border="0" cellpadding="20" cellspacing="0">

<?php
// Iterate over the fetched rows and display images with their descriptions and other info
foreach ($rows as $row) {
    echo '<tr>
            <td>
                <img src="' . htmlspecialchars($row["image_location"]) . '" alt="' . htmlspecialchars($row["tour_package_name"]) . '" width="450" height="300">
            </td>
            <td align="center" valign="middle">
                <h3>' . htmlspecialchars($row["tour_package_name"]) . '</h3>
                <p>' . htmlspecialchars($row["tour_package_description"]) . '</p>
                <p>' . htmlspecialchars($row["tour_package_price"]) . ' BDT</p>
                <p><a href="booking.php?id=' . htmlspecialchars($row["id"]) . '">Book Now</a></p>
            </td>
        </tr>';
    echo '<br>Image Location: ' . htmlspecialchars($row["image_location"]) . '<br>';
}
?>

    </table>
</fieldset>

</body>
</html>
