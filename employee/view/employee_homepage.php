<?php
session_start();
if (!isset($_SESSION["employee_email"])) {
    header("Location: ../../login.php");
    exit();
}
require '../../customer/control/package_control.php';

// Fetch data
$rows = [];
$rows1 = [];
while ($row = $respackage->fetch_assoc()) {
    $rows[] = $row;
}
while ($row = $resaccessory->fetch_assoc()) {
    $rows1[] = $row;
}
//$email = $_SESSION["email"];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Trip Booking & Travel Accessories</title>
    <link rel="stylesheet" href="../../customer/style/homepage.css">
</head>

<body>
    <h1>Discover the Boundless Wonders of the World</h1>
    <p>Craving Adventure? Discover the Best Travel Packages and Gear for Your Next Journey!</p>
    

    <a href="employee_homepage.php" class="website-name">Thrillscape</a>
    <div class="button-container">
    <a href="../../customer/view/travel_package.php"><button class="btn">Book a Trip</button></a>
    <a href="../../customer/view/travel_accessory.php"><button class="btn">Shop Accessories</button></a>
    <a href="employee_panel.php">
            <button type="button" class="btn" >Employee Panel</button>
        </a>
    <a href="../../logout_control.php">
            <button type="button"class="btn" >LOG OUT</button>
        </a>
</div>
<!--     <p>
        <a href="cart.php">
            <button type="button">My Cart</button>
        </a>
    </p>
    <p>
        <a href="mybuy.php">
            <button type="button">My Items</button>
        </a>
    </p>
    <p>
        <a href="customer_profile.php">
            <button type="button">My Profile</button>
        </a>
    </p> -->
    
    <fieldset>
        <legend>
            <h2>Most Popular Travel Packages</h2>
        </legend>
        <div class="package-container">
            <?php
            $count = 0;
            foreach ($rows as $row) {
                if ($count < 8) { 
                    echo '<div class="package-card">';
                    echo '<img src="../../customer/resources/' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["tour_package_name"]) . '">';
                    echo '<h3>' . htmlspecialchars($row["tour_package_name"]) . '</h3>';
                    echo '<p>' . htmlspecialchars($row["tour_package_description"]) . '</p>';
                    echo '<p>Price: ' . htmlspecialchars($row["tour_package_price"]) . ' BDT</p>';
                    echo '<p>Status: ' . htmlspecialchars($row["tour_package_status"]) . '</p>';
                    echo '<p><a href="travel_package.php">Book Now</a></p>';
                    echo '</div>';
                    $count++;
                }
            }
            ?>
        </div>
       
        <?php if (count($rows) > 8) { ?>
            <a href="travel_package.php" class="see-more-btn">See More</a>
        <?php } ?>
    </fieldset>


    <fieldset>
        <legend>
            <h2>Top Travel Accessories</h2>
        </legend>
        <div class="accessory-container">
            <?php
            $accessoryCount = 0;
            foreach ($rows1 as $row) {
                if ($accessoryCount < 8) { 
                    echo '<div class="accessory-card">';
                    echo '<img src="../../customer/resources/' . htmlspecialchars($row["travel_accessory_image"]) . '" alt="' . htmlspecialchars($row["name"]) . '">';
                    echo '<h3>' . htmlspecialchars($row["name"]) . '</h3>';
                    echo '<p>Price: ' . htmlspecialchars($row["price"]) . ' BDT</p>';
                    echo '<p>Stock: ' . htmlspecialchars($row["stock"]) . '</p>';
                    echo '<p><a href="travel_accessory.php">Buy Now</a></p>';
                    echo '</div>';
                    $accessoryCount++;
                }
            }
            ?>
        </div>
        
        <?php if (count($rows1) > 8) { ?>
            <a href="travel_accessory.php" class="see-more-btn">See More</a>
        <?php } ?>
    </fieldset>
</body>

</html>