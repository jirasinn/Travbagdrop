<?php
require_once('../libs/connect.class.php');

// การเชื่อมต่อฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $original_admin_id = $_POST['original_admin_id'];
    $new_admin_id = $_POST['new_admin_id'];
    $roleAdmin = $_POST['roleAdmin'];
    $adminPass = $_POST['adminPass'];
    $urole = "admin";
    
    // ตรวจสอบข้อมูลที่กรอกเข้ามา
    if (empty($original_admin_id) || empty($new_admin_id) || empty($roleAdmin) || empty($adminPass)) {
        echo "ต้องกรอกข้อมูลทุกช่อง";
        exit;
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($adminPass, PASSWORD_DEFAULT);

    // เตรียมและผูกค่า
    $stmt = $conn->prepare("UPDATE register SET urole = ?, admin_id = ?, Ad_rank = ?, m_password = ? WHERE admin_id = ?");
    $stmt->bind_param("sssss", $urole, $new_admin_id, $roleAdmin, $hashed_password, $original_admin_id);

    if ($stmt->execute()) {
        echo "อัปเดตข้อมูลแอดมินเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูลแอดมิน: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
