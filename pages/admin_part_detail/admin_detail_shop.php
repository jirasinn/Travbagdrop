<?php
require_once('../../libs/connect.class.php');
// เชื่อมต่อฐานข้อมูล
?>

<!-- detail request -->
<div id="detail_shop">
    <div style="text-align:center; margin-left: -1vw; margin-right: -1vw; padding: 10px; background-color: white;">
        <div class="d-flex align-items-center" style="margin:1%;">
            <a onclick="showContent('request', 'request-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900; ">รายละเอียดพาร์ทเนอร์</h4>
            </div>
        </div>
    </div>

    <?php
    $db = new ConnectDb();
    $conn = $db->getConn();

    // ตรวจสอบว่ามีการส่ง mk_id มาหรือไม่
    if (isset($_POST['mk_id'])) {
        // รับค่า mk_id จาก HTTP POST request
        $mk_id = $_POST['mk_id'];

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


                    <div class="row1">
                        <!--  -->
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

                            <br><br>
                            <div style="display: flex; justify-self: center; ">
                                <!-- Button to open modal -->
                                <input type="submitA" id="submitApprove" value="อนุมัติการเป็นพาร์ทเนอร์" data-bs-toggle="modal" data-bs-target="#myApprove_<?php echo $mk_id ?>" data-mk-id="<?php echo $mk_id ?>">

                            </div>

                        </div>
                        <!--  -->
                        <!-- Modal myApprove_-->
                        <div id="myApprove_<?php echo $mk_id ?>" class="modal" tabindex="-1" aria-labelledby="myApproveModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form id="form_<?php echo $mk_id ?>" method="post" action="./crud/insert_approve_partner.php">
                                            <center>
                                                <img src="images/correct.png" height="100px" width="100px" alt="">
                                                <p style="font-size: 28px;">อนุมัติการเป็นพาร์ทเนอร์
                                                    ของสถานประกอบการ <?php echo $row["mk_name"]; ?> หรือไม่?</p>
                                            </center>
                                            <input type="hidden" name="mk_id" value="<?php echo $mk_id ?>">

                                            <div class="d-flex justify-content-evenly align-items-center" style="margin-bottom: 3%;">
                                                <button type="submit" class="btn btn-success" style="background-color: #31D141; color: black;  padding: 2%; width: 35%; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">ยืนยัน</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="background-color: #F90000; color: black;  padding: 2%; width: 35%; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">ยกเลิก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->
                        <!--  -->
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
                                <!-- Button to open modal -->
                                <input type="submitC" id="submitNot-Approve" value="ไม่อนุมัติการเป็นพาร์ทเนอร์" data-bs-toggle="modal" data-bs-target="#mynot-Approve_<?php echo $mk_id ?>" data-mk-id="<?php echo $mk_id ?>">

                            </div>

                        </div>

                        <!-- Modal myApprove_-->
                        <div id="mynot-Approve_<?php echo $mk_id ?>" class="modal" tabindex="-1" aria-labelledby="mynot-ApproveModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form id="form_<?php echo $mk_id ?>" method="post" action="./crud/insert_not-Approve_partner.php">
                                            <center>
                                                <img src="images/X.png" height="100px" width="100px" alt="">
                                                <p style="font-size: 28px;">ไม่อนุมัติการเป็นพาร์ทเนอร์
                                                    ของสถานประกอบการ <?php echo $row["mk_name"]; ?> หรือไม่?</p>
                                            </center>
                                            <textarea type="text" name="cause" placeholder="สาเหตุ" required></textarea>
                                            <input type="hidden" name="mk_id" value="<?php echo $mk_id ?>">

                                            <div class="d-flex justify-content-evenly align-items-center" style="margin-bottom: 3%;">
                                                <button type="submit" class="btn btn-success" style="background-color: #31D141; color: black;  padding: 2%; width: 35%; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">ยืนยัน</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" style="background-color: #F90000; color: black;  padding: 2%; width: 35%; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);">ยกเลิก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end modal -->
                        <!--  -->
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


<style>
    /* ในส่วนของพาร์ทเนอร์ */
    .row1 {
        padding: 4%;
        margin-top: -3%;

        display: flex;
        justify-content: center;
    }

    .col-4 {
        position: relative;
        padding: 3%;
        /* background-color: #D9D9D9; */
        margin-bottom: 45px;
    }

    .col-3 {

        height: 100%;

    }

    /*  */
    .label {
        display: block;
        margin-bottom: 2%;
        padding: -15px;
        font-size: 24px;
        font-weight: bold;
        width: 100%;
    }

    textarea[type="text"] {
        display: block;
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
        /* ให้ผู้ใช้สามารถปรับขนาดในแนวตั้งได้ */
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
        /* เพิ่ม Drop shadow */
    }

    #submitApprove {
        font-size: 20px;
        font-weight: bold;
        width: 75%;
        padding: 15px;
        background-color: #31D141;
        color: #000000;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        display: block;
        margin: auto;
        /* margin-top: 25px; */
        /* margin-top: 27%; */
        text-align: center;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        /* เพิ่ม Drop shadow */
    }

    #submitNot-Approve {
        font-size: 16px;
        font-weight: bold;
        width: 60%;
        padding: 18px;
        background-color: #F90000;
        color: #000000;
        border: none;
        border-radius: 14px;
        cursor: pointer;

        margin: auto;
        margin-left: 10%;
        display: flex;
        justify-content: center;
        text-align: center;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
        /* เพิ่ม Drop shadow */
        position: absolute;
        bottom: 0;
    }

    #submitApprove:hover,
    #submitNot-Approve:hover {
        background-color: #419ba3;
    }
</style>