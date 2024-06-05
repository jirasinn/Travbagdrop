<?php
require_once('../libs/connect.class.php');
session_start();

$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_POST["mk_id"]) && !empty($_POST["mk_id"])) {
    $mk_id = $_POST['mk_id'];

    $sql = "UPDATE market SET status='approve' WHERE mk_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $mk_id); // Assuming mk_id is an integer

    if ($stmt->execute()) {
        echo "<script>";
        echo "alert('ตอบรับคำร้องการเปิดร้านค้าสำเร็จ');";
        echo "window.location='../?page=admin';"; // เพิ่มการส่งค่า storeCode กลับไปด้วย URL
        echo "</script>";
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    echo "<script>";
    echo "alert('เกิดข้อผิดพลาด: ข้อมูลร้านค้าไม่ถูกต้อง');";
    echo "window.location='../?page=admin';"; // เพิ่มการส่งค่า storeCode กลับไปด้วย URL
    echo "</script>";
}
?>
