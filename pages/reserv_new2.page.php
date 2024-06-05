<?php
if (!isset($_SESSION['bagdrop_member_id'])) {
    echo "<script>";
    echo "alert('กรุณาเข้าสู่ระบบ');";
    echo "window.location='?page=login';";
    echo "</script>";
    exit;
}
$m_id = $_SESSION['bagdrop_member_id'];
// $storeCode = $_GET['store'];

$storeCode = $_SESSION['store'];
?>
<br><br>
<!--  -->
<div class="row col-md-12">
    <a href="?page=reserv_new&store=<?= $storeCode; ?>"><img src="images/กลับ.png" width="4%" style="margin-left: 15%;  margin-top: 0%; "></a>

</div>

<div class="circle-bar col-md-12">

    <div class="circle">
        1
        <div class="circle-description">ข้อมูลสัมภาระ</div>
    </div>
    <div class="circle active">
        2
        <div class="circle-description">ข้อมูลลูกค้า</div>
    </div>
    <div class="circle">
        3
        <div class="circle-description">ชำระเงิน</div>
    </div>
</div>

<!--  -->

<style>
    .circle-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 850px;
        height: 20px;
        background-color: #F7F41F;
        border-radius: 25px;
        padding: 1px;
        margin-left: 30%;
        margin-bottom: -2%;
    }

    .circle-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 45%;
        height: 20px;
        background-color: #F7F41F;
        border-radius: 25px;
        padding: 1px;
        margin-left: 30%;
        margin-bottom: 0.5%;
        margin-top: -2.5%;
    }

    .circle {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        color: #000;
    }

    .circle.active .circle-description {
        color: #000;
        /* เปลี่ยนสีข้อความที่ active เป็นสีดำ */
    }

    .circle-description {
        position: absolute;
        top: calc(100% + 10px);
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        color: #ccc;
        /* เปลี่ยนสีข้อความที่ไม่ active เป็นสีเทา */
        padding: 5px 10px;
        border-radius: 5px;
        opacity: 1;

    }

    .active {
        background-color: #007bff;
        color: #fff;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.1);
        }
    }
</style>

<!--  -->
<div class="container col-md-12">
    <!--  -->

    <form class="first-form" method="post" action="" enctype="multipart/form-data">
        <div class="card-body">

            <?php
            $db = new ConnectDb();
            $conn = $db->getConn();

            $m_id = $_SESSION['bagdrop_member_id'];

            $sql = "SELECT register.*, tbl_country.ct_nameTHA  FROM register 
  join tbl_country on tbl_country.ct_code = register.m_ctry
   WHERE m_id = '$m_id'";

            $rs = mysqli_query($conn, $sql);

            if ($rs && mysqli_num_rows($rs) > 0) {
                $data = mysqli_fetch_assoc($rs);
            ?>
                <div class="row col-md-12" style="margin-top: 2%; font-size: 24px; margin-left: 10px; margin-bottom: 2%;">

                    <label for="m_fname"><b>ชื่อ: &nbsp;&nbsp;</b> <?= $data['m_fname'] ?></label>
                    <label for="m_lname"><b>นามสกุล: &nbsp;&nbsp;</b> <?= $data['m_lname'] ?></label>
                    <label for="m_email"><b>อีเมล: &nbsp;&nbsp;</b> <?= $data['m_email'] ?></label>
                    <label for="m_ctry"><b>ประเทศ: &nbsp;&nbsp;</b> <?= $data['ct_nameTHA'] ?></label>
                    <label for="m_phone"><b>เบอร์โทรศัพท์: &nbsp;&nbsp;</b> <?= $data['m_phone'] ?></label>

                    <br><br>
                    <div class="note" style="font-size: 20px"> ท่านยอมรับ <span style="color: red;">เงื่อนไขในการฝาก</span> และ <span style="color: red;">เงื่อนไขในการให้บริการ</span>  ของทราฟว์แบ็กดรอปเมื่อดำเนินการ
                        <br>You agree to the deposit terms and terms of service of Trav Back Drop upon proceeding.
                    </div>
                    <!--  -->
                    <!-- <b><label for="note">หมายเหตุถึงเรา</label></b>
        <textarea id="note" name="note"></textarea> -->


                <?php } ?>
                </div>

        </div>
    </form>
    <!--  -->

    <!-- End col-md-6 -->
</div>
<div class="container col-12">
    <form class="third-form">

        <br>
        <!--  -->

        <!--  -->
        <div class="container col-12">

            <?php
            $db = new ConnectDb();
            $conn = $db->getConn();
            // ตรวจสอบว่ามีการเชื่อมต่อกับฐานข้อมูลหรือไม่
            if ($conn) {
                // สร้างคำสั่ง SQL เพื่อดึงข้อมูลร้านค้าโดยใช้ mk_code
                $sql2 = "SELECT * FROM market 

            WHERE mk_id = '$storeCode'";
                // ส่งคำสั่ง SQL ไปทำงาน
                $rs2 = mysqli_query($conn, $sql2);
                // ตรวจสอบว่ามีข้อมูลที่ได้จากการค้นหาหรือไม่
                if (mysqli_num_rows($rs2) > 0) {
                    // วนลูปเพื่อแสดงข้อมูลทุกแถวที่ได้จากการค้นหา
                    while ($data2 = mysqli_fetch_array($rs2)) {
                        $mk_img = $data2['mk_img'];
            ?>

                        <!--  -->
                        <!-- แสดงรูปภาพร้านค้า -->
                        <br>
                        <div class="row col-12">
                            <div class="col-4">
                                <img src="images/market/<?= $mk_img; ?>" style="max-width: 560px;" height="300" width="100%"><br>
                            </div>
                            <br>
                            <!-- แสดงชื่อร้านค้า -->
                            <div class="col-8">
                                <!--  -->
                                <div class="text" style="padding: 25px; margin-left: 20px;">
                                    <h5 style="font-size: 30px;"><b>
                                            <?= $data2['mk_name']; ?>
                                        </b></h5>


                                    <h5><b>
                                            เวลเปิด-ปิด
                                        </b> 00.00-24.00 น.</h5>

                                    <?php
                                    $db = new ConnectDb();
                                    $conn = $db->getConn();

                                    // คำสั่ง SQL เพื่อหาค่าเฉลี่ยของคะแนนรีวิวและจำนวนรีวิวทั้งหมด
                                    $sql3 = "SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews 
         FROM feedback 
         WHERE mk_id = '$storeCode'";
                                    $rs3 = mysqli_query($conn, $sql3);

                                    // เรียกดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
                                    $data3 = mysqli_fetch_array($rs3);

                                    // หากต้องการแสดงค่าเฉลี่ยและจำนวนรีวิวทั้งหมด
                                    $average_rating = $data3['average_rating'];
                                    $total_reviews = $data3['total_reviews'];
                                    ?>

                                    <!-- แสดงคะแนนรีวิวเฉลี่ยและจำนวนรีวิวทั้งหมด -->
                                    <h5><b>
                                            คะแนนรีวิว <?= number_format($average_rating, 1); ?>
                                            <span style="color: #F7F41F; pointer-events: none;">&#9733;</span>

                                            <span style="font-weight: normal; font-size: 0.9em; vertical-align: middle; display: inline-block; margin-left: 10px; pointer-events: none;">จาก
                                                <?= $total_reviews; ?> รีวิว</span>
                                        </b></h5>
                                    <!--  -->
                                </div>
                                <br>
                                <!-- แสดงเบอร์โทร -->
                                <!-- <b>เบอร์โทร:</b>
                                    <?= $data2['mk_phone']; ?><br> -->
                    <?php
                    }
                } else {
                    // ถ้าไม่พบข้อมูลร้านค้า
                    echo "ไม่พบข้อมูลร้านค้า";
                }
            } else {
                // ถ้าไม่สามารถเชื่อมต่อกับฐานข้อมูลได้
                echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
            }
                    ?>

                    <!-- end text -->
                            </div>

                        </div>
        </div>
        <!--  -->
        <hr>
        <br>

        <!--  -->
        <?php
        if (isset($_SESSION['reservation_date']) && isset($_SESSION['reservation_time']) && isset($_SESSION['retrieval_date']) && isset($_SESSION['retrieval_time'])) {
            $reserv_date = $_SESSION['reservation_date'];
            $reserv_time = $_SESSION['reservation_time'];
            $retrive_date = $_SESSION['retrieval_date'];
            $retrive_time = $_SESSION['retrieval_time'];
        ?>


            <div class="reservation-info">
                <div class="reservation-info green-text">เวลาในการฝาก <?= $reserv_date; ?> <span class="time">เวลา <?= $reserv_time; ?></div>
                <div class="reservation-info red-text">เวลาในการรับคืน <?= $retrive_date; ?> <span class="time2">เวลา <?= $retrive_time; ?></div>
            </div>
        <?php
        }
        ?>
        <style>
            .reservation-info {
                font-family: Arial, sans-serif;
                font-size: 22px;
                /* ปรับขนาดตัวอักษรตามต้องการ */
                line-height: 1.5;
                /* ปรับระยะห่างระหว่างบรรทัด */
                margin-left: 20px;
                /* จัดช่องไฟด้านล่าง */
            }

            .reservation-info .time {
                margin-left: 23%;
            }

            .reservation-info .time2 {
                margin-left: 22%;
            }

            .green-text {
                color: green;
            }

            .red-text {
                color: red;
            }
        </style>

        <div class="col-md-12">

            <div class="card-body " style="margin-left: 20px; margin-right: 20px;">
                <!-- ส่วนของโค้ดที่ใช้แสดงตะกร้าสินค้า -->
                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();
                $sql = "SELECT * FROM cart 
                        WHERE m_id = $m_id and mk_id = '$storeCode'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $category_name = $row['category_name'];
                        $quantity = $row['quantity'];
                        $price = $row['price'];
                ?>

                        <div class="row" style="margin-left: 10px;">


                            <div class="col">
                                <a class="text text-dark">
                                    <?php echo $category_name; ?>
                                </a>
                            </div>
                            <div class="col text-center" style="margin-left: 15%;">
                                <a class="text text-warning">จำนวน
                                    <?php echo $quantity; ?> ใบ
                                </a>
                            </div>
                            <div class="col text-right" style="margin-left: 18%;">
                                <a class="price text-success">ราคา
                                    <?php echo $price; ?> บาท
                                </a>
                            </div>

                            <!-- <a href="?page=clear_cart&store=<?= $storeCode ?>&id=<?= $row['cart_id'] ?>"
                                    class="btn btn-danger btn-sm">ลบ</a> -->


                        </div>
                        <br>
                        <!--  -->

                <?php
                    }
                }
                ?>
                <!-- ส่วนของการส่งคำสั่งดำเนินการ -->
                <style>
                    .yellow-button {
                        background-color: #E5E71A;
                        border: black;
                        color: #000000;
                        padding: 10px 20px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-weight: bold;
                        /* ทำให้ข้อความเป็นตัวหนา */
                        font-size: 24px;
                        /* ปรับขนาดข้อความ */
                        margin: 4px 2px;
                        cursor: pointer;
                        border-radius: 4px;
                    }

                    .yellow-button:hover {
                        background-color: #ffc200;
                    }
                </style>

                <!--  -->
                <?php
                // เชื่อมต่อฐานข้อมูล
                $db = new ConnectDb();
                $conn = $db->getConn();

                // เตรียม SQL query
                $sql6 = "SELECT * FROM cart WHERE cart.m_id = $m_id AND cart.mk_id = '$storeCode'";

                $rs6 = mysqli_query($conn, $sql6);

                // เริ่มแถวใหม่
                echo '<div class="row" style="margin-left: 10px;">';

                // สร้าง array เพื่อเก็บชื่อ idcard ที่เคยแสดงแล้ว
                $already_shown_idcards = [];

                // แสดงข้อมูล idcard และรูปภาพที่ไม่ซ้ำ
                while ($data6 = mysqli_fetch_assoc($rs6)) {
                    $idcard = $data6['idcard'];

                    // ตรวจสอบว่า idcard นี้เคยแสดงไว้แล้วหรือไม่
                    if (!empty($idcard) && !in_array($idcard, $already_shown_idcards)) {
                        // ถ้ายังไม่ได้แสดง ให้เพิ่ม idcard เข้าไปในตัวแปรเพื่อระบุว่าได้แสดงไว้แล้ว


                        // แสดงรูป idcard
                ?>
                        <!-- รูปภาพ -->
                        <div class="col-md-2">
                            <img src="images/idcard/<?= $idcard; ?>" class="img-fluid" style="width: 50%; height: 55%;" alt="<?= $idcard; ?>">
                            <p><?= $idcard; ?></p>
                        </div>
                    <?php
                        $already_shown_idcards[] = $idcard;
                    }

                    // แยกชื่อรูปภาพทั้งหมดออกมาแล้วแสดงทั้งหมด
                    $pictures = preg_split('/,\s*"/', $data6['picture']);
                    foreach ($pictures as $picture) {
                        // ตัดเครื่องหมาย " ออกจากชื่อไฟล์
                        $picture = trim($picture, '"');
                    ?>
                        <!-- รูปภาพ -->
                        <div class="col-md-2">
                            <img src="images/<?php echo $picture; ?>" class="img-fluid " style="width: 50%; height: 55%;" alt="<?php echo $picture; ?>">
                            <p><?php echo $picture; ?></p>
                        </div>

                <?php
                    }
                }
                // ปิดแถว
                echo '</div>';
                ?>
                <!--  -->
                <?php
                // เชื่อมต่อฐานข้อมูล
                $db = new ConnectDb();
                $conn = $db->getConn();

                // เตรียม SQL query
                $sql7 = "SELECT SUM(price) AS total_price FROM cart WHERE cart.m_id = $m_id and cart.mk_id = '$storeCode'";

                $rs6 = mysqli_query($conn, $sql7);
                $data6 = mysqli_fetch_assoc($rs6);
                $sumprice = $data6['total_price'];
                ?>
                <label class="card-text">
                    <h3>
                        <div id="total-price-display" name="total_price"><b>ราคารวมทั้งสิ้น <?php echo $sumprice; ?>
                                บาท</b></div>
                        <input type="hidden" id="total_price_input" name="total_price" value="<?php echo $sumprice; ?>">
                    </h3>
                </label>
                <br>

                <!--  -->
                <div class="card-submit" align="center">
                    <a href="?page=payment" class="yellow-button">ดำเนินการ</a>
                </div>
                <!--  -->
            </div>
        </div>
    </form>
</div>



<!-- css -->
<style>
    .text,
    .price {
        color: black;
        /* เปลี่ยนสีของตัวหนังสือเป็นสีดำ */
        text-decoration: none;
        /* ไม่มีเส้นใต้ข้อความ */
    }

    .bag {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        height: 100%;
    }
</style>

<!-- End col-md-12 -->
</div>

<!-- css -->

<style>
    .container {
        display: flex;
        padding: 10px;
        justify-content: space-between;
        /* จัดฟอร์มและสถานที่รับฝากอยู่ด้านขวาและซ้ายของพื้นที่ flex */
    }

    .container form {
        width: 100%;
        /* กำหนดความกว้างของฟอร์ม */
    }

    form {
        position: relative;
        /* ต้องเพิ่ม position: relative เพื่อให้สามารถใช้ position: absolute บนส่วนของ form */
        width: 45%;
        margin: 0;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        margin-top: 100px;
        /* เพิ่มระยะห่างด้านขวาของฟอร์ม */
        border: 1px solid black;
        /* เพิ่มเส้นขอบและกำหนดสีดำ */

    }

    .first-form::before {
        content: "ข้อมูลลูกค้า";
        text-align: center;
        position: absolute;
        /* ตั้งค่าให้เป็น absolute เพื่อให้สามารถจัดตำแหน่งได้ */
        top: -30px;
        /* ปรับตำแหน่งให้อยู่บนสุดของ form */
        left: 50%;
        /* ให้ข้อความอยู่ตรงกลาง */
        transform: translateX(-50%);
        /* จัดให้อยู่ตรงกลางแนวนอน */
        padding: 10px;
        width: 100.3%;
        font-size: 24px;
        background-color: #121139;
        color: #FFFFFF;
        /* สีข้อความ */
        border-top-left-radius: 10px;
        /* ปรับ radius ด้านบนซ้าย */
        border-top-right-radius: 10px;
        /* ปรับ radius ด้านบนขวา */
        border-bottom-right-radius: 0;
        /* ปรับให้ด้านล่างขวาเป็นเรียบ */
        border-bottom-left-radius: 0;
        /* ปรับให้ด้านล่างซ้ายเป็นเรียบ */
        border: 1px solid black;
        /* เพิ่มเส้นขอบและกำหนดสีดำ */
    }

    .third-form::before {
        content: "สรุปรายละเอียดการจอง";
        text-align: center;
        position: absolute;
        /* ตั้งค่าให้เป็น absolute เพื่อให้สามารถจัดตำแหน่งได้ */
        top: -30px;
        /* ปรับตำแหน่งให้อยู่บนสุดของ form */
        left: 50%;
        /* ให้ข้อความอยู่ตรงกลาง */
        transform: translateX(-50%);
        /* จัดให้อยู่ตรงกลางแนวนอน */
        padding: 10px;
        width: 100.3%;
        font-size: 24px;
        background-color: #121139;
        color: #FFFFFF;
        /* สีข้อความ */
        border-top-left-radius: 10px;
        /* ปรับ radius ด้านบนซ้าย */
        border-top-right-radius: 10px;
        /* ปรับ radius ด้านบนขวา */
        border-bottom-right-radius: 0;
        /* ปรับให้ด้านล่างขวาเป็นเรียบ */
        border-bottom-left-radius: 0;
        /* ปรับให้ด้านล่างซ้ายเป็นเรียบ */
        border: 1px solid black;
        /* เพิ่มเส้นขอบและกำหนดสีดำ */

    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    .card-text {
        font-size: 20px;
        /* ปรับขนาดข้อความ */
        padding: 5px 6px;
        border-radius: 5px;
        width: 50%;
        margin: 0 auto;
        /* จัดให้อยู่กึ่งกลางตามแนวนอน */
        text-align: center;
        /* จัดให้ข้อความอยู่กึ่งกลางตามแนวนอน */
    }

    /* cart */

    /*  */
</style>