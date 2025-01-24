<?php
include '../model/mydb.php';
$db = new myDB();
$conn = $db->openCon();
$result = $db->viewall($conn);

if ($result && $result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

$conn->close();

?>