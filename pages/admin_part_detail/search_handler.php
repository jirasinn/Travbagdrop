<?php
require_once('../../libs/connect.class.php');
// เชื่อมต่อฐานข้อมูล
?>
<div id="searchP" >
    <div style="text-align:center; margin-left: -1vw; margin-right: -1vw; padding: 10px; background-color: white;">
        <div class="d-flex align-items-center" style="margin:1%;">
            <a onclick="showContent('partner', 'partner-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900;">รายการค้นหา</h4>
                </div>
            </div>
        </div>

        <?php
// admin_part_detail/search_handler.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // เชื่อมต่อฐานข้อมูล
    $db = new ConnectDb();
    $conn = $db->getConn();

    $mk_name = $_POST['mk_name'];
    $mk_code = $_POST['mk_code'];
    $mk_email = $_POST['mk_email'];
    $mk_province = $_POST['mk_province'];

    $sql4 = "SELECT * FROM market WHERE 1=1";

    if (!empty($mk_name)) {
        $sql4 .= " AND market.mk_name LIKE '%" . mysqli_real_escape_string($conn, $mk_name) . "%'";
    }

    if (!empty($mk_code)) {
        $sql4 .= " AND market.mk_code LIKE '%" . mysqli_real_escape_string($conn, $mk_code) . "%' AND market.mk_code IS NOT NULL AND market.mk_code != ''";
    }

    if (!empty($mk_email)) {
        $sql4 .= " AND market.mk_email LIKE '%" . mysqli_real_escape_string($conn, $mk_email) . "%' AND market.mk_email IS NOT NULL AND market.mk_email != ''";
    }

    if (!empty($mk_province)) {
        $sql4 .= " AND market.mk_province LIKE '%" . mysqli_real_escape_string($conn, $mk_province) . "%'";
    }

    $rs4 = mysqli_query($conn, $sql4);

    while ($data4 = mysqli_fetch_array($rs4)) {
        $mk_id = $data4['mk_id'];
        echo '<div class="card2" style="display: flex; align-items: stretch;" onclick="postSearchDetail(\'search_detail\', \'search_detail-link\', ' . $data4['mk_id'] . ')">';
        echo '<div class="col-2" style="flex: 1 0 20%;">' . $data4['mk_name'] . '</div>';
        echo '<div class="col-8" style="flex: 1 0 70%;">' . $data4['location'] . '</div>';

        $db = new ConnectDb();
        $conn = $db->getConn();
        
        // เรียกข้อมูลจากฐานข้อมูล
        $sql = "SELECT status FROM market where mk_id = $mk_id "; // เพิ่มเงื่อนไขที่ต้องการตรวจสอบใน WHERE clause
        $result = $conn->query($sql);
        
        // ตรวจสอบว่ามีข้อมูลที่ได้จากฐานข้อมูลหรือไม่
        if ($result->num_rows > 0) {
            // เรียกข้อมูลแต่ละแถว
            while ($data4 = $result->fetch_assoc()) {
                // ตรวจสอบค่าของ status และกำหนดสีและข้อความที่จะแสดง
                if ($data4['status'] == 'closed') {
                    echo '<div class="col-2" style="flex: 1 0 10%; background-color: #FF0000; padding: 0px;">ปิดให้บริการ</div>';
                } elseif ($data4['status'] == 'approve') {
                    echo '<div class="col-2" style="flex: 1 0 10%; background-color: #51DA10; padding: 0px;">เปิดให้บริการ</div>';
                } elseif ($data4['status'] == 'not_approve') {
                    echo '<div class="col-2" style="flex: 1 0 10%; background-color: #FFA500; padding: 0px;">ไม่อนุมัติ</div>';
                } elseif ($data4['status'] == 'cancel') {
                    echo '<div class="col-2" style="flex: 1 0 10%; background-color: Violet; padding: 0px;">ยกเลิก</div>';
                }
            }
        } else {
            // ถ้าไม่มีข้อมูล
            echo "ไม่มีข้อมูล";
        }

        echo '</div>';
        
    }
}
?>

<!-- margin-left: 5%; -->
    </div>

    <style>

input[type="submitC"] {
        font-size: 26px;
        font-weight: bold;
         width: 82%;
        padding: 7%;
        background-color: #F90000;
        color: #000000;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        display: block;
        margin: auto;
        
        text-align: center;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25); /* เพิ่ม Drop shadow */
        position: absolute;
            bottom: 1.5%;
    }

    input[type="submitC"]:hover{
        background-color: #419ba3;
    }

    input[type="text1"] {
    /* display: block;
    margin: 10 auto; */
    background-color: #F7F41F;
    color: #000000;
    width: 100%;
    /* height: 15%; */
    padding: 15%;
    margin-bottom: 30%;
    border: 1px solid #ddd;
    border-radius: 14px;
    font-size: 20px;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25); /* เพิ่ม Drop shadow */
}


    </style>