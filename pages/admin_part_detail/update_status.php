<?php
require_once('../../libs/connect.class.php');
echo $mk_id;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'] ?? '';
    $cause = $_POST['cause'] ?? '';
    $mk_id = $_POST['mk_id'] ?? '';

    // ตรวจสอบและประมวลผลค่าที่ได้รับ
    if ($status === 'open') {
        // อัพเดท status ในตาราง market
        $newStatus = 'approve';
    } elseif ($status === 'closed') {
        // ตรวจสอบการกรอก cause และอัพเดท status ในตาราง market
        if (!empty($cause)) {
            $newStatus = 'closed';
            $causeText = $cause;
        } else {
            // ข้อผิดพลาด: ไม่มีการกรอก cause
            echo 'กรุณากรอกสาเหตุ';
            exit;
        }
    } elseif ($status === 'cancel') {
        // ตรวจสอบการกรอก cause และอัพเดท status ในตาราง market
        if (!empty($cause)) {
            $newStatus = 'cancel';
            $causeText = $cause;
        } else {
            // ข้อผิดพลาด: ไม่มีการกรอก cause
            echo 'กรุณากรอกสาเหตุ';
            exit;
        }
    } else {
        // ข้อผิดพลาด: สถานะไม่ถูกต้อง
        echo 'สถานะไม่ถูกต้อง';
        exit;
    }

    $db = new ConnectDb();
    $conn = $db->getConn();
    // ทำการอัพเดทฐานข้อมูล
    $sql = "UPDATE market SET status='$newStatus', cause='$causeText' WHERE mk_id='$mk_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'อัพเดทสถานะเรียบร้อย';
        
    } else {
        echo 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล';
    }
}
?>
