<?php
require_once('../libs/connect.class.php');
// Check if admin_id is set
if (isset($_POST['admin_id'])) {
    // Get the admin_id from POST data
    $admin_id = $_POST['admin_id'];

    // Database connection
    $db = new ConnectDb();
    $conn = $db->getConn();

    // Prepare and bind
    $stmt = $conn->prepare("DELETE FROM register WHERE admin_id = ?");
    $stmt->bind_param("s", $admin_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "ลบข้อมูลแอดมินเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูลแอดมิน: " . $conn->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "No admin_id provided.";
}
