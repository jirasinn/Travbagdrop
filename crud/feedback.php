<?php
session_start();
require_once("../libs/connect.class.php");
// ตรวจสอบว่ามีการส่งข้อมูล POST มาหรือไม่
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    exit();
}

// ตรวจสอบว่ามีข้อมูลที่ส่งมาครบหรือไม่
if (!isset($_POST['mk_id']) || !isset($_POST['m_id']) || !isset($_POST['rating']) || !isset($_POST['suggestion'])) {
    http_response_code(400);
    exit();
}

// รับข้อมูลจากแบบฟอร์ม
$mk_id = $_POST['mk_id'];
$m_id = $_POST['m_id'];
$rating = $_POST['rating'];
$suggestion = $_POST['suggestion'];

// เชื่อมต่อฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

// ตรวจสอบการเชื่อมต่อกับฐานข้อมูล
if ($conn->connect_error) {
    http_response_code(500);
    exit();
}

// เตรียมและ execute คำสั่ง SQL เพื่อบันทึกข้อมูล
$sql = "INSERT INTO feedback (mk_id, m_id, rating, suggestion) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiis", $mk_id, $m_id, $rating, $suggestion);

if ($stmt->execute()) {
    // ตั้งค่า header เพื่อบอกว่าข้อมูลที่ส่งกลับเป็น JSON
    header('Content-Type: application/json');
    echo json_encode(array('success' => true));
} else {
    http_response_code(500);
    // ตั้งค่า header เพื่อบอกว่าข้อมูลที่ส่งกลับเป็น JSON
    header('Content-Type: application/json');
    echo json_encode(array('success' => false, 'error' => $conn->error));
}

// ปิดการเชื่อมต่อฐานข้อมูล
$stmt->close();
$conn->close();
?>
