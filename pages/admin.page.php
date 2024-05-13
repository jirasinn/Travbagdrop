<?php
$m_id = $_SESSION['bagdrop_member_id'];

$m_fname = $_SESSION['bagdrop_member_fname'];

?>

<div class="row col-12">

    <div class="col-3">

        <div class="slide-bg3">
            <div class="d-flex flex-column flex-shrink-0 p-3 " style="width: 350px; background-color: #121139;">
                <br>
                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();

                // สร้าง SQL query เพื่อดึงข้อมูลร้านค้าและรูปภาพ
                $sql = "SELECT * FROM register WHERE m_id = $m_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // หากมีข้อมูลในฐานข้อมูล
                    while ($row = $result->fetch_assoc()) {
                        // ดึงข้อมูลร้านค้าและรูปภาพ
                        $a_fname = $row['m_fname'];
                        $a_lname = $row['m_lname'];
                        $admin_img = $row['usr_img'];

                        // แสดงผลร้านค้าและรูปภาพ
                        echo '<div class="container  text-center ">';
                        echo '<img src="images/usr_img/' . $admin_img . '" class="admin-img" width="100px" height="100px">';
                        echo '<a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none text-center">';
                        echo '<span class="fs-4">ผู้ใช้งาน: ' . $a_fname . ' ' . $a_lname . '</span>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    // หากไม่มีข้อมูลในฐานข้อมูล
                    echo "0 results";
                }
                $conn->close();
                ?>


                <div style="height: 1px; background-color: white; margin: 10px 0;"></div>

                <ul class="nav nav-pills flex-column mb-auto">


                    <!-- nav-link active -->
                    <a href="#" class="navMenu" onclick="showContent('search', 'search-link')" id="search-link">
                        ระบบออเดอร์
                    </a>




                    <!-- nav-link active -->
                    <a href="#" class="navMenu" onclick="showContent('partner', 'partner-link')" id="partner-link">
                        ระบบพาทเนอร์
                    </a>




                    <a href="#" class="navMenu" onclick="showContent('cam', 'cam-link')" id="cam-link">
                        ระบบกล้อง
                    </a>


                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->

                    <a href="#" class="navMenu" onclick="showContent('contact','contact-link')" id="contact-link">
                        ระบบติดต่อ
                    </a>

                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->

                    <a href="#" class="navMenu" onclick="showContent('report')" id="report-link">
                        สมาชิก
                    </a>

                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->

                    <a href="crud/logout.php" class="navMenu" onclick="showContent('logout')" id="logout-link">
                        ออกจากระบบ
                    </a>


                </ul>

            </div>
        </div>

    </div>
    <!-- end col-3 -->

    <div class="col-9">

        <div>

            <div class="d-flex justify-content-center" style="margin-top: 10px; height:30%; padding: 10px;">
                <canvas id="barChart" style=" border-radius: 10px; padding: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:100%; width:100%;max-width:800px"></canvas>
            </div>
            <script>
                var xValues = ["Italy", "France", "Spain", "USA", "Argentina"];
                var yValues = [55, 49, 44, 24, 15];
                var barColors = ["red", "green", "blue", "orange", "brown"];

                new Chart("barChart", {
                    type: "horizontalBar",
                    data: {
                        labels: xValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: yValues
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: "ร้านค้าที่ได้รับความนิยมรายการฝากสูงสุด"
                        },
                        scales: {
                            xAxes: [{
                                ticks: {
                                    min: 10,
                                    max: 60
                                }
                            }]
                        }
                    }
                });
            </script>
            <div class="d-flex justify-content-evenly" style="padding: 10px;">
                <div style="background-color: #121138; margin-right:15px; border-radius: 10px; width:20%; color: white; padding: 10px; text-align:center;">
                    รายการฝากทั้งหมด<br>
                    <span style="color: #f7f420; font-size:20px; font-weight:700;">8900</span><br>
                    รายการ
                </div>
                <div style="background-color: #121138; margin-right:15px; border-radius: 10px; width:20%; color: white; padding: 10px; text-align:center;">
                    พาร์ทเนอร์ทั้งหมด<br>
                    <span style="color: #f7f420; font-size:20px; font-weight:700;">8900</span><br>

                </div>
                <div style="background-color: #121138; margin-right:15px; border-radius: 10px; width:20%; color: white; padding: 10px; text-align:center;">
                    จำนวนลูกค้าทั้งหมด<br>
                    <span style="color: #f7f420; font-size:20px; font-weight:700;">8900</span><br>
                    คน
                </div>
                <div class="d-flex justify-content-center align-items-center" style="font-size:20px; font-weight:700; background-color: #121138; border-radius: 10px; width:20%; color: #f7f420; padding: 10px; text-align:center;">
                    รายได้ทั้งหมด
                </div>
            </div>

            <div class="d-flex justify-content-evenly" style=" height:30%; padding: 10px;">
                <div style="padding: 10px;">
                    <canvas id="pieChart" style="border-radius: 10px; padding: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:100%; width:100%;max-width:500px"></canvas>
                </div>
                <div style="padding: 10px;">
                    <canvas id="lineChart" style="border-radius: 10px; padding: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:100%; width:100%;max-width:500px"></canvas>
                </div>
            </div>
            <script>
                //pie chart
                const pValues = ["ภาคกลาง", "ภาคเหนือ", "ภาคใต้", "ภาคตะวันออก", "ภาคตะวันตก"];
                const paValues = [55, 49, 44, 24, 15];
                const pnColors = [
                    "#b91d47",
                    "#00aba9",
                    "#2b5797",
                    "#e8c3b9",
                    "#1e7145"
                ];

                new Chart("pieChart", {
                    type: "pie",
                    data: {
                        labels: pValues,
                        datasets: [{
                            backgroundColor: barColors,
                            data: paValues
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: "โซนที่ได้รับความนิยม"
                        }
                    }
                });
                //line chart
                const cValues = [100, 200, 300, 400, 500, 600, 700, 800, 900, 1000];

                new Chart("lineChart", {
                    type: "line",
                    data: {
                        labels: cValues,
                        datasets: [{
                            data: [860, 1140, 1060, 1060, 1070, 1110, 1330, 2210, 7830, 2478],
                            borderColor: "red",
                            fill: false
                        }, {
                            data: [1600, 1700, 1700, 1900, 2000, 2700, 4000, 5000, 6000, 7000],
                            borderColor: "green",
                            fill: false
                        }, {
                            data: [300, 700, 2000, 5000, 6000, 4000, 2000, 1000, 200, 100],
                            borderColor: "blue",
                            fill: false
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: "อัตราการเติบโต"
                        }
                    }
                });
            </script>
        </div>


        <!-- partner -->
        <div id="partner" style="display: none;">

            <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
                <div class="d-flex align-items-center" style="margin:10px 0 10px 0;">
                    <a href=""><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                    <!-- <div class="flex-grow-1 text-center">
                        <h4 style="font-weight:900; ">ลงทะเบียนฝากกระเป๋า</h4>
                    </div> -->
                </div>
            </div>
            <!--  -->
            <?php
            $db = new ConnectDb();
            $conn = $db->getConn();

            // คำสั่ง SQL เพื่อหาค่าเฉลี่ยของคะแนนรีวิวและจำนวนรีวิวทั้งหมด
            $sql = "SELECT COUNT(urole) AS total_partner
         FROM market 
         WHERE urole = 'partner'";
            $rs = mysqli_query($conn, $sql);
            // เรียกดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
            $data = mysqli_fetch_array($rs);

            ?>
            <!--  -->
            <div class="row">
                <!--  -->
                <div class="col-4" style="margin-right: -4%;">
                    <!--  -->
                    <div class="card">
                        <span>พาร์ทเนอร์ทั้งหมด</span>
                        <h3><b><?= $data['total_partner']; ?></b></h3>
                    </div>

                    <div class="card1" onclick="showContent('request', 'request-link')" id="request-link">
                        <span>คำร้องการสมัครเป็นพาร์ทเนอร์</span>
                    </div>

                    <div class="card1" onclick="showContent('approve', 'approve-link')" id="approve-link">
                        <span>พารท์เนอร์ที่พึ่งอนุมัติ</span>
                    </div>

                    <div class="card1" onclick="showContent('not-approve', 'not-approve-link')" id="not-approve-link">
                        <span>พาร์ทเนอร์ที่ไม่อนุมัติ</span>
                    </div>

                    <div class="card1" onclick="showContent('cancle', 'cancle-link')" id="cancle-link">
                        <span>พาร์ทเนอร์ที่ถูกยกเลิก</span>
                    </div>
                    <!--  -->
                </div>
                <!--  -->
                <div class="col-8">

                    <h3 style="margin-top: 2%;"><b>ค้นหาพาทเนอร์</b></h3>

                    <form method="post" action="" enctype="multipart/form-data">

                        <label for="mk_name">ค้นหาจากชื่อสถานประกอบการ</label><br>
                        <input type="text" id="mk_name" name="mk_name" placeholder="กรอกชื่อสถานประกอบการ"><br>

                        <label for="mk_code">ค้นหาจากหมายเลขจดทะเบียนสถานประกอบการ</label><br>
                        <input type="text" id="mk_code" name="mk_code" placeholder="กรอกเลขที่จดทะเบียนสถานประกอบการ"><br>

                        <label for="mk_email">ค้นหาจากหมายอีเมล</label><br>
                        <input type="email" id="mk_email" name="mk_email" placeholder="กรอกอีเมล"><br>

                        <label for="mk_province">ค้นหาจากจังหวัด</label><br>
                        <input type="text" id="mk_province" name="mk_province" placeholder="กรอกจังหวัด"><br>

                        <input type="submit" name="submit" value="ค้นหา">
                    </form>

                </div>


            </div>
            <!--  -->
        </div>
        <!-- end partner -->
        <!--  -->
    </div>
    <!-- end col-8 -->

    <!-- ระบบพาร์ทเนอร์ -->

    <!-- contact -->
    <div id="contact" style="display: none;">

        <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
            <div class="d-flex align-items-center" style="margin:1%;">
                <a href=""><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                <div class="flex-grow-1 text-center">
                    <h4 style="font-weight:900; ">การแจ้งเตือน</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- End contact -->
    <!-- request -->
    <div id="request" style="display: none;">

        <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
            <div class="d-flex align-items-center" style="margin:1%;">
                <a onclick="showContent('partner', 'partner-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                <div class="flex-grow-1 text-center">
                    <h4 style="font-weight:900; ">คำร้องในการสมัครเป็นพาร์ทเนอร์</h4>
                </div>
            </div>
        </div>

        <!--  -->
        <?php
        // เชื่อมต่อฐานข้อมูล
        $db = new ConnectDb();
        $conn = $db->getConn();

        $sql2 = "SELECT * FROM market WHERE market.status = 'request'";
        $rs2 = mysqli_query($conn, $sql2);
        while ($data2 = mysqli_fetch_array($rs2)) {
        ?>
            <!--  -->
            <div class="card2" onclick="postID('detail_shop', 'detail_shop-link', <?= $data2['mk_id']; ?>)">

                <div class="col-2">
                    <?= $data2['mk_name']; ?>
                </div>
                <div class="col-10">
                    <?= $data2['location']; ?>
                </div>
                <!-- ไม่ต้องเพิ่ม input hidden เพื่อเก็บ mk_id ที่นี่ -->
            </div>
        <?php } ?>


    </div>
    <!-- End request -->
    <!-- approve -->
    <div id="approve" style="display: none;">

        <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
            <div class="d-flex align-items-center" style="margin:1%;">
                <a onclick="showContent('partner', 'partner-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                <div class="flex-grow-1 text-center">
                    <h4 style="font-weight:900; ">พาร์ทเนอร์ที่พึ่งอนุมัติ</h4>
                </div>
            </div>
        </div>
        <!--  -->
        <?php
        // เชื่อมต่อฐานข้อมูล
        $db = new ConnectDb();
        $conn = $db->getConn();

        // ตรวจสอบว่า mk_id มีค่าหรือไม่
        if (isset($_GET['mk_id'])) {
            $mk_id = $_GET['mk_id']; // หรือ $_POST['mk_id']

            // สร้างคำสั่ง SQL เพื่อดึงข้อมูลพาร์ทเนอร์ที่ตรงกับ mk_id
            $sql3 = "SELECT * FROM market WHERE market.status = 'request' AND market.mk_id = $mk_id";
            $rs3 = mysqli_query($conn, $sql3);

            // ตรวจสอบว่ามีข้อมูลที่ตรงกับ mk_id หรือไม่
            if (mysqli_num_rows($rs3) > 0) {
                while ($data3 = mysqli_fetch_array($rs3)) {
        ?>
                    <!-- แสดงข้อมูลพาร์ทเนอร์ -->
                    <div class="card2">
                        <div class="col-2">
                            <?= $data3['mk_name']; ?>
                        </div>
                        <div class="col-10">
                            ffffffffffffffffffffff
                        </div>
                    </div>
        <?php
                }
            } else {
                // หากไม่พบข้อมูลที่ตรงกับ mk_id
                echo "ไม่พบข้อมูลพาร์ทเนอร์ที่ตรงกับ mk_id";
            }
        } else {
            // หากไม่มี mk_id ที่ส่งมา
            echo "ไม่พบ mk_id";
        }
        ?>

    </div>
    <!-- End approve -->
    <!-- not approve -->
    <div id="not-approve" style="display: none;">

        <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
            <div class="d-flex align-items-center" style="margin:1%;">
                <a onclick="showContent('partner', 'partner-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                <div class="flex-grow-1 text-center">
                    <h4 style="font-weight:900; ">พาร์ทเนอร์ที่ไม่ได้รับการอนุมัติ</h4>
                </div>
            </div>
        </div>

        <div class="card2">
            Market
        </div>

    </div>


</div>
<!-- End not approve -->
<!-- cancle -->
<div id="cancle" style="display: none;">

    <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
        <div class="d-flex align-items-center" style="margin:1%;">
            <a onclick="showContent('partner', 'partner-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900; ">พาร์ทเนอร์ที่ถูกยกเลิก</h4>
            </div>
        </div>
    </div>

    <div class="card2">
        Market
    </div>

</div>


</div>
<!-- End cancle -->

<!-- รายละเอียดคำขอร้าน -->

<div id="detail_shop" style="display: none;">

    <div style="text-align:center; margin-left: -1vw; margin-right: -1vw; padding: 10px; background-color: white;">
        <div class="d-flex align-items-center" style="margin:1%;">
            <a onclick="showContent('request', 'request-link')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900; ">รายละเอียดพาร์ทเนอร์</h4>
            </div>
        </div>
    </div>

    <!-- PHP -->
    <?php
    if (isset($_GET['mk_id'])) {
        $mk_id = $_GET['mk_id'];

        if (!empty($mk_id)) {
            $db = new ConnectDb();
            $conn = $db->getConn();

            $sql3 = "SELECT * FROM market WHERE market.status = 'request' AND market.mk_id = $mk_id";
            $rs3 = mysqli_query($conn, $sql3);
            while ($data3 = mysqli_fetch_array($rs3)) {
    ?>
                <div class="col-2"><?= $data3['mk_name']; ?></div>
                <div class="col-10">fffffffffffffffffffffff</div>
                <input type="hidden" name="mk_id" value="<?= $data3['mk_id']; ?>">
    <?php
            }
        } else {
            echo "mk_id ไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบ mk_id";
    }
    ?>


    <!--  -->
</div>

<!--  -->

<!-- End ระบบพาร์ทเนอร์ -->


<!-- end col-12 -->
</div>


<!--  -->
<script>
    function showContent(contentId, clickedLinkId, mk_id) {
        // ซ่อนทุกส่วนของข้อมูล
        document.querySelectorAll('.col-9 > *').forEach(el => {
            el.style.display = 'none';
        });
        // แสดงเฉพาะส่วนข้อมูลที่เลือก
        document.getElementById(contentId).style.display = 'block';

        // ลบคลาส 'active' ออกจากทุก nav-link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });
        // เพิ่มคลาส 'active' ใน nav-link ที่ถูกคลิก
        document.getElementById(clickedLinkId).classList.add('active');

        if (clickedLinkId === 'partner-link') {
            document.getElementById('request').style.display = 'none';
            document.getElementById('approve').style.display = 'none';
            document.getElementById('cancle').style.display = 'none';
            document.getElementById('not-approve').style.display = 'none';
            document.querySelector('.slide-bg3').style.display = 'block';
        }

        // ถ้าคลิกที่ 'contact-link' ให้ซ่อน slide-bg3
        if (clickedLinkId === 'contact-link' || clickedLinkId === 'request-link' || clickedLinkId === 'approve-link' || clickedLinkId === 'not-approve-link' || clickedLinkId === 'cancle-link') {
            document.getElementById('detail_shop').style.display = 'none';
            document.querySelector('.slide-bg3').style.display = 'none';
        }

    }

    function toggleAside(asideId) {
        var aside = document.getElementById(asideId);
        var asideStyle = window.getComputedStyle(aside);
        if (asideStyle.display === "none" || asideStyle.display === "") {
            aside.style.display = "block";
        } else {
            aside.style.display = "none";
        }
    }

    function postID(detailId, linkId, mk_id) {
        // แสดงเนื้อหาของ detailId
        var detailElement = document.getElementById(detailId);
        detailElement.style.display = "block";

        // ซ่อนเนื้อหาของอื่นๆ ที่ไม่ใช่ detailId (ถ้ามี)
        var otherDetails = document.querySelectorAll('[id^="detail_"]');
        otherDetails.forEach(function(detail) {
            if (detail.id !== detailId) {
                detail.style.display = "none";

            }
        });

        // สร้าง XMLHttpRequest object
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // เมื่อข้อมูลถูกโหลดสำเร็จ ให้แทรกข้อมูลลงใน div ที่มี id เป็น detailId
                document.getElementById(detailId).innerHTML = this.responseText;
                document.getElementById('request').style.display = 'none';
                document.getElementById('detail_shop').style.display = 'block';
            }
        };
        // สร้างคำขอ POST เพื่อส่งข้อมูลไปยังไฟล์ PHP
        xhttp.open("POST", "crud/admin_detail_shop.php", true);
        // ตั้งค่า header ให้ Content-Type เป็น application/x-www-form-urlencoded
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // ส่งข้อมูล mk_id ไปยังไฟล์ PHP ด้วยการ encode ให้อยู่ในรูปแบบของ query string
        xhttp.send("mk_id=" + mk_id);
    }
</script>

<!--  -->
<style>
    .card {
        font-size: 20px;
        font-weight: bold;
        top: 20px;
        left: 10%;
        width: 60%;
        height: auto;
        background-color: yellow;
        border: 2px solid black;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
        padding: 30px;
    }

    .card1 {
        font-size: 20px;
        font-weight: bold;
        top: 20px;
        left: 10%;
        width: 60%;
        height: auto;
        border: 2px solid black;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
        padding: 15px;
        margin-top: 8%;
        margin-bottom: -5%;
        margin-left: 10%;
    }

    /* ในส่วนของพาร์ทเนอร์ */
    .card2 {
        font-size: 20px;
        font-weight: bold;
        width: 83%;
        height: auto;
        border: 3px solid black;
        z-index: 1;
        display: flex;
        justify-content: left;
        align-items: center;
        border-radius: 8px;
        padding: 10px;
        margin-left: 10%;
        margin-bottom: 1%;
    }

    /*  */
    input[type="text"],
    input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #D9D9D9;
    }

    input[type="submit"] {
        width: 13%;
        padding: 13px;
        background-color: #F91D1D;
        color: white;
        border: none;
        border-radius: 18px;
        cursor: pointer;
        display: block;
        margin: auto;
        margin-top: 5%;
    }

    input[type="submit"]:hover {
        background-color: #419ba3;
    }

    .admin-img {
        border-radius: 50%;
        height: 100px;
        width: 100px;
        margin-right: 10px;
    }

    .navMenu {
        text-decoration: none;
        color: white;
        border: 3px solid;
        border-radius: 50px;
        padding: 10px;
        margin-top: 10px;
        text-align: center;
        font-size: 20px;
        width: 80%;
    }
</style>