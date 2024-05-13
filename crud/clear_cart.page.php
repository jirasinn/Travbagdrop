<?php

$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_GET['id']) && isset($_GET['store'])) { // ตรวจสอบว่ามีการส่งค่า 'id' และ 'store' มาหรือไม่
    $cid = $_GET['id'];
    $m_id = $_SESSION['bagdrop_member_id'];
    $storeCode = $_GET['store'];
    // ทำการลบข้อมูล
    $sql = "DELETE FROM cart WHERE cart_id='$cid' AND m_id = $m_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>";
        echo "alert('ลบข้อมูลสำเร็จ');";
        echo "window.location='?page=reserv_new&store=$storeCode';"; // เพิ่มการส่งค่า storeCode กลับไปด้วย URL
        echo "</script>";
    
    } else {
        echo "<script>";
        echo "alert('เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error . "');";
        echo "window.location='?page=reserv_new&store=$storeCode'"; // ถ้าเกิดข้อผิดพลาดในการลบข้อมูล ให้กลับไปที่หน้า reserv_new พร้อมส่งค่า storeCode กลับไปด้วย
        echo "</script>";
    }

    // Check if any data exists for m_id in the table
    $check_query = "SELECT * FROM cart WHERE m_id = $m_id";
    $check_result = $conn->query($check_query);

    // If no data exists, unset session variables
    if ($check_result->num_rows == 0) {
        unset($_SESSION['reservation_date']);
        unset($_SESSION['reservation_time']);
        unset($_SESSION['retrieval_date']);
        unset($_SESSION['retrieval_time']);
        
    }

    // Close database connection
    $conn->close();
}
?>
