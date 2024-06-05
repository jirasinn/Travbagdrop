<?php
require_once('../libs/connect.class.php');
session_start();

$db = new ConnectDb();
$conn = $db->getConn();
$mk_name = $_SESSION['mkname'];
$sql = "SELECT tracking FROM bagreserv 
        WHERE bagreserv.mk_name LIKE ? AND bagreserv.status != 'คืนสำเร็จ'";

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $mk_name);
$stmt->execute();

// Fetch the tracking data
$result = $stmt->get_result();
$trackingData = [];
while ($row = $result->fetch_assoc()) {
    $row['mk_name'] = $mk_name;
    $trackingData[] = $row;
}

// Return the tracking data as JSON
header('Content-Type: application/json');
echo json_encode($trackingData);
