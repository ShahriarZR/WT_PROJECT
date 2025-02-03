<?php
require 'customer/control/package_control.php';

// Fetch data
$rows = [];
$rows1 = [];
while ($row = $respackage->fetch_assoc()) {
    $rows[] = $row;
}
while ($row = $resaccessory->fetch_assoc()) {
    $rows1[] = $row;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Trip Booking & Travel Accessories</title>
    <link rel="stylesheet" type="text/css" href="customer/style/mainhomepage.css">
</head>

<body>
    <h1>Discover the Boundless Wonders of the World</h1>
    <p>Craving Adventure? Discover the Best Travel Packages and Gear for Your Next Journey!</p>
        <a href="customer/view/travel_package.php">
            <button type="button">Book a Trip</button>
        </a>
        <a href="customer/view/travel_accessory.php">
            <button type="button">Shop Accessories</button>
        </a>
        <a href="login.php">
            <button type="button">LOG IN</button>
        </a>
    <fieldset>
        <legend>
            <h2>Most Popular Travel Packages</h2>
        </legend>
        <table border="0" cellpadding="20" cellspacing="0">
            <tr>
                <?php
                foreach ($rows as $row) {
                    echo '<td align="center">';
                    echo '<img src="customer/resources/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["tour_package_name"]) . '" width="450" height="300">';
                    echo '</td>';
                }
                ?>
            </tr>
            <tr>
                <?php
                foreach ($rows as $row) {
                    echo '<td align="center" valign="middle">';
                    echo '<h3>' . htmlspecialchars($row["tour_package_name"]) . '</h3>';
                    
                    echo '<p>Status: ' . htmlspecialchars($row["tour_package_status"]) . '</p>';
                    echo '<p><a href="customer/view/travel_package.php' . '">Book Now</a></p>';
                    echo '</td>';
                }
                ?>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <legend>
            <h2>Top Travel Accessories</h2>
        </legend>
        <table cellpadding="20">
            <tr>
                <?php
                foreach ($rows1 as $row) {
                    echo '<td align="center">';
                    echo '<img src="customer/resources/' . htmlspecialchars($row["travel_accessory_image"]) . '" alt="' . htmlspecialchars($row["name"]) . '" width="450" height="300">';
                    echo '</td>';
                }
                ?>
            </tr>
            <tr>
                <?php
                foreach ($rows1 as $row) {
                    echo '<td align="center" valign="middle">';
                    echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
                    echo '<p><a href="customer/view/travel_accessory.php' . '">Buy Now</a></p>';
                    echo '</td>';
                }
                ?>
            </tr>
        </table>
    </fieldset>
</body>

</html>