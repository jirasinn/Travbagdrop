<?php
require_once('../libs/connect.class.php');
// การเชื่อมต่อฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

// ตรวจสอบว่าฟอร์มถูกส่งหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากฟอร์ม
    $role = $_POST['roleAdmin'];
    $id = $_POST['id'];
    $password = $_POST['password'];
    $urole = "admin";

    // ตรวจสอบข้อมูลที่กรอกเข้ามา
    if (!empty($role) && !empty($id) && !empty($password)) {
        // เข้ารหัสรหัสผ่าน
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // เตรียมคำสั่ง SQL
        $sql = "INSERT INTO register (urole, Ad_rank, admin_id, m_password) VALUES (?, ?, ?, ?)"; // แทนที่ your_table_name ด้วยชื่อของตารางจริง

        if ($stmt = $conn->prepare($sql)) {
            // ผูกตัวแปรกับคำสั่งที่เตรียมไว้เป็นพารามิเตอร์
            $stmt->bind_param("ssss", $urole, $role, $id, $hashed_password);

            // พยายามประมวลผลคำสั่งที่เตรียมไว้
            if ($stmt->execute()) {
                echo "เพิ่มข้อมูลแอดมินสำเร็จ";
            } else {
                echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลแอดมิน: " . $stmt->error;
            }

            // ปิดคำสั่ง
            $stmt->close();
        } else {
            echo "เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error;
        }
    } else {
        echo "ต้องกรอกข้อมูลทุกช่อง";
    }

    // ปิดการเชื่อมต่อ
    $conn->close();
}
?>
