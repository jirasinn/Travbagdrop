<?php
require_once('../libs/connect.class.php');
session_start();

$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_POST['bag_id']) && isset($_POST['tracking_data'])) {
    $bag_id = $_POST['bag_id'];
    $tracking_data = $_POST['tracking_data'];
    $mk_name = $_SESSION['mkname'];

    $tracking_data = str_replace("Tracking : ", "", $tracking_data);

    $tracking_data = ltrim($tracking_data, ',');

    $sql = "SELECT * FROM bagreserv 
            WHERE bagreserv.bag_id = ? 
            AND bagreserv.mk_name LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $bag_id, $mk_name);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sql_update = "UPDATE bagreserv SET tracking = ?, status = 'ฝากสำเร็จ' WHERE bag_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $tracking_data, $bag_id);

        if ($stmt_update->execute()) {
            $stmt_update->close();
        }

        $stmt_update->close();
    } else {
        echo "No matching records found";
    }

    $stmt->close();
}
