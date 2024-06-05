<?php
require_once('../libs/connect.class.php');

// Database connection
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];

    // Query to fetch data from the database
    $sql = "SELECT urole, admin_id, m_password FROM register WHERE admin_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
    $conn->close();
}
