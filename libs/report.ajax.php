<?php
session_start();
require_once("connect.class.php");
$mk_id = $_SESSION['bagdrop_member_id'];
if (isset($_SESSION['mk_id'])) {


    // ตรวจสอบการส่งค่าปีและเดือนเริ่มต้น
    if (isset($_GET['start_year']) && isset($_GET['start_month']) && isset($_GET['end_month'])) {
        $startYear = $_GET['start_year'];
        $startMonth = $_GET['start_month'];
        $endMonth = $_GET['end_month'];

        // คำสั่ง SQL เพื่อค้นหาข้อมูลจากฐานข้อมูล
        $sql = "SELECT COUNT(bag_id) AS total_orders, SUM(total_price) AS total_price
                FROM bagreserv
                WHERE mk_id = '$mk_id'
                AND status != 'รอดำเนินการ'
                AND MONTH(curr_timestamp) >= '$startMonth'
                AND MONTH(curr_timestamp) <= '$endMonth'
                AND YEAR(curr_timestamp) = '$startYear'";

        // ดำเนินการ query กับฐานข้อมูล
        $result = mysqli_query($conn, $sql);

        // ตรวจสอบว่า query สำเร็จหรือไม่
        if ($result) {
            // ดึงข้อมูลจากผลลัพธ์ query
            $row = mysqli_fetch_assoc($result);
            $sumorder = $row['total_orders'];
            $sumprice = $row['total_price'];

            // สร้าง associative array เพื่อระบุข้อมูลที่จะส่งกลับในรูปแบบ JSON
            $responseData = array(
                'sumorder' => $sumorder,
                'sumprice' => $sumprice
            );

            // Encode the data as JSON and send it back
            echo json_encode($responseData);
        } else {
            // หาก query ไม่สำเร็จ
            echo json_encode(array('error' => mysqli_error($conn)));
        }
    } else {
        // กระทำเมื่อไม่ได้รับข้อมูลที่ส่งมาในรูปแบบที่ต้องการ
        echo json_encode(array('error' => 'Incomplete data'));
    }
}

?>
