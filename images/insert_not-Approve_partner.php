<?php
require_once('../libs/connect.class.php');
session_start();

$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_POST["mk_id"]) && !empty($_POST["mk_id"])) {
    
    $mk_id = $_POST['mk_id'];
    $cause = $_POST['cause'];

    // ปรับปรุง SQL เพื่ออัพเดตทั้ง status และ cause
    $sql = "UPDATE market SET status='not_approve', cause=? WHERE mk_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $cause, $mk_id); // cause เป็น string และ mk_id เป็น integer

    if ($stmt->execute()) {
        echo "<script>";
        echo "alert('ปฏิเสธคำขอการเป็นพาร์ทเนอร์สำเร็จ');";
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

