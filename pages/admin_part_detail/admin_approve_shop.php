<?php
require_once('../../libs/connect.class.php');
// เชื่อมต่อฐานข้อมูล
?>

<div id="approve_detail">
    <div class="row" style="margin-left: 0.5%; margin-right: 0.5%;">
        <div style="text-align:center; margin-left: -1vw; margin-right: -1vw; padding: 10px; background-color: white;">
            <div class="d-flex align-items-center" style="margin:1%;">
                <a onclick="showContent('approve', 'approve-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                <div class="flex-grow-1 text-center">
                    <h4 style="font-weight:900; ">รายละเอียดพาร์ทเนอร์</h4>
                </div>
                <!--  -->
                <?php
                if (isset($_POST['mk_id'])) {
                    $mk_id = $_POST['mk_id'];

                    // ดึงข้อมูลจากฐานข้อมูลและแสดงผล
                    $db = new ConnectDb();
                    $conn = $db->getConn();

                    // ตรวจสอบว่า mk_id ไม่เป็นค่าว่าง
                    if (!empty($mk_id)) {
                        // สร้างคำสั่ง SQL เพื่อดึงข้อมูลพาร์ทเนอร์ที่ตรงกับ mk_id
                        $sql = "SELECT * FROM market WHERE mk_id = $mk_id";
                        $result = mysqli_query($conn, $sql);

                        // ตรวจสอบว่ามีข้อมูลพาร์ทเนอร์ที่ตรงกับ mk_id หรือไม่
                        if (mysqli_num_rows($result) > 0) {
                            // แสดงผลลัพธ์ในรูปแบบของ HTML
                            while ($row = mysqli_fetch_assoc($result)) {
                                $mk_img = $row['mk_img'];
                                $store_img = $row['store_img'];
                                $doc_img = $row['doc_img'];
                ?>

                                <!--  -->
                                <div class="cardE" onclick="showContent2(<?php echo $mk_id; ?>)">
    <img src="images/engine.png" style="width:30px;height:30px; margin-right: 3%;">
    <h5 style="margin-top: 5%;">แก้ไขสถานะ</h5>
</div>


                                <!--  -->

            </div>
        </div>
    </div>


    <div class="row1">
        <div class="col-3">
            <div class="label">ชื่อสถานประกอบการ
                <input type="text" value="<?php echo $row["mk_name"]; ?>" readonly>
            </div>
            <div class="label">หมายเลขสถานประกอบการ
                <input type="text" value="<?php echo $row["mk_code"]; ?>" readonly>
            </div>
            <div class="label">เบอร์ติดต่อสถานประกอบการ
                <input type="text" value="<?php echo $row["mk_phone"]; ?>" readonly>
            </div>
            <div class="label">อีเมล
                <input type="text" value="<?php echo $row["mk_email"]; ?>" readonly>
            </div>
            <div class="label">รหัสผ่าน
                <input type="text" value="<?php echo $row["mk_password"]; ?>" readonly>
            </div>
            <div class="label">ที่อยู่สถานประกอบการ
                <input type="text" value="<?php echo $row["location"]; ?>" readonly>
            </div>

        </div>
        <div class="col-4" style="margin-top: -3%;">
            <div class="label">ชื่อ-สกุล ผู้มีอำนาจ
                <input type="text" value="<?php echo $row["mk_fname1"]; ?> <?php echo $row["mk_lname1"]; ?>" readonly>
            </div>
            <div class="label">เบอร์โทรศัพท์ผู้มีอำนาจ
                <input type="text" value="<?php echo $row["mk_phone1"]; ?>" readonly>
            </div>
            <div class="label">ชื่อ-สกุล ผู้ประสานงาน
                <input type="text" value="<?php echo $row["mk_fname2"]; ?> <?php echo $row["mk_lname2"]; ?>" readonly>
            </div>
            <div class="label">เบอร์โทรศัพท์ผู้ประสานงาน
                <input type="text" value="<?php echo $row["mk_phone2"]; ?>" readonly>
            </div>

            <div style="display: flex; justify-self: center; ">
                <input type="submitP" value="เปิดให้บริการ">
            </div>

        </div>
        <div class="row col-5" align="center">
            <div class="col-6">
                <div class="label">หน้าสถานประกอบการ</div>
                <img src="images/market/<?= $mk_img; ?>" style="max-width: 100%;" height="330" width="100%">
            </div>
            <div class="col-6">
                <div class="label">คลังเก็บกระเป๋า</div>
                <img src="images/market/store/<?= $store_img; ?>" style="max-width: 100%;" height="330" width="100%">
            </div>
            <div class="label" style="margin-top: 5%;">เอกสารประกอบการ</div>
            <img src="images/market/documents/<?= $doc_img; ?>" style="max-width: 100%;" height="400" width="100%">
        </div>
    </div>
<?php
                            }
                        } else {
                            echo "ไม่พบข้อมูลพาร์ทเนอร์ที่ตรงกับ mk_id: " . $mk_id;
                        }
                    } else {
                        echo "mk_id ไม่ถูกต้อง";
                    }
                } else {
                    echo "ไม่พบข้อมูล mk_id";
                }
?>


</div>
<!--  -->

<div id="modalContainer"></div>

<!--  -->
<style>
    /* ในส่วนของพาร์ทเนอร์ */
    .cardE {
        background-color: #D9D9D9;
        width: 11%;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 18px;
        padding: 0.7%;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    .row1 {
        padding: 4%;
        margin-top: -3%;
        display: flex;
        justify-content: center;
    }

    .col-4 {
        padding: 3%;
        position: relative;
    }

    .label {
        display: block;
        margin-bottom: 2%;
        padding: -15px;
        font-size: 24px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #D9D9D9;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    input[type="submitP"] {
        font-size: 32px;
        font-weight: bold;
        width: 100%;
        padding: 25px;
        background-color: #51DA10;
        color: #000000;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        display: block;
        margin: auto;
        margin-top: 29%;
        text-align: center;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    input[type="submitP"]:hover {
        background-color: #419ba3;
    }

    textarea[type="text"] {
        display: none;
        margin: 0 auto;
        width: 80%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #D9D9D9;
        font-size: 1em;
        resize: vertical;
    }
</style>