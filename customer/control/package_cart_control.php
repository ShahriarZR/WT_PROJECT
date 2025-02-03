<?php
session_start();
/*/if (!isset($_SESSION["customer_email"])) {
    header("Location: ../../login.php");
    exit();
}*/
include '../model/mydb.php';

$package_id = $_POST["package_id"];
$_SESSION["package_id"]=$package_id;
$package_name = $_POST["package_name"];
$package_price = $_POST["package_price"];
$package_person = $_POST["person"];
$table = "temp_pkg";
$table1 = "customer";
$table2 = "tour_package";
$mail = $_SESSION["customer_email"];
$date = date("Y-m-d");


$db1 = new customerDB();
$con = $db1->openCon();
$rescustomer = $db1->findUserinsert($table1, $mail, $con);

while ($row = $rescustomer->fetch_assoc()) {
    $c_id = $row["customer_id"];
    $_SESSION["c_id"] = $c_id;

}
$pkgresult=$db1->findPackages($table,$c_id,$package_id,$con);
if($pkgresult->num_rows>0)
{
    while($row=$pkgresult->fetch_assoc())
    {
        $pk_id=$row["pkg_id"];

        if($package_id==$pk_id)
        {
            $package_person+=$row["total_person"];
            $pricepkg=$package_person*$package_price;
            $updatepkg=$db1->updatePkg($table,$c_id,$pk_id,$package_person,$pricepkg,$con);
            header("Location:../view/payment_pkg.php");
        }
    }
}
else
{
    $respkg = $db1->pkgAvailable($table2, $package_id, $con);
while($row=$respkg->fetch_assoc())
{
    $status=$row["tour_package_status"];
    if($status=="Open" || $status=="Available")
    {
        $total=$package_person*$package_price;
        $insrtpkg = $db1->addpkg($table, $c_id, $package_id, $package_person, $package_price,$total, $date, $package_name, $con);
        header("Location:../view/payment_pkg.php");

    }
    else
    {
        echo "Package Unavailable.";
        echo '<br><a href="../view/travel_package.php">Click Here to buy Another package.</a>';
    }
}
}

?>