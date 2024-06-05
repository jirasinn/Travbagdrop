<?php
$m_id = $_SESSION['bagdrop_member_id'];
$m_fname = $_SESSION['bagdrop_member_fname'];
$admin_id = $_SESSION['bagdrop_member_admin_id'];
$Ad_rank = $_SESSION['bagdrop_member_Ad_rank'];
?>

<div class="row col-12">

    <div class="col-3">

        <div class="slide-bg3">
            <div class="d-flex flex-column flex-shrink-0 p-3 " style="width: 100%; background-color: #121139;">
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
                        echo '<a class="d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none text-center" style="width: 100%; margin-top: 8%; margin-bottom: 8%;">';
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

                    <li class="nav-item" style="display: none;">
                        <!-- nav-link active -->
                        <a href="#" class="nav-link text-white" onclick="displayContent('or_detail', 'or_detail-link')" id="or_detail-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                        </a>

                    </li>


                    <!-- nav-link active -->
                    <a href="#" class="navMenu" onclick="showContent('search', 'search-link')" id="search-link">
                        ระบบออเดอร์
                    </a>

                    <!--  -->
                    <?php
                    if (isset($_SESSION['bagdrop_member_Ad_rank'])) {
                        // เก็บค่า Ad_rank ในตัวแปร
                        $Ad_rank = $_SESSION['bagdrop_member_Ad_rank'];
                        // เช็คว่า Ad_rank ไม่เท่ากับ 'Admin2' และไม่เท่ากับ 'Admin3'
                        if ($Ad_rank !== 'Admin3') {
                            // แสดงลิงก์หรือส่วนนี้เมื่อเงื่อนไขเป็นจริง
                    ?>

                            <a href="#" class="navMenu" onclick="showContent('partner', 'partner-link')" id="partner-link">
                                ระบบพาทเนอร์
                            </a>
                            <!--  -->
                    <?php
                        }
                    }
                    ?>
                    <!--  -->
                    <a href="#" class="navMenu" onclick="showContent('cam', 'cam-link')" id="cam-link">
                        ระบบกล้อง
                    </a>

                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->

                    <a href="#" class="navMenu" onclick="showContent('contact','contact-link')" id="contact-link">
                        ระบบติดต่อ
                    </a>

                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->
                    <?php
                    // เช็คว่ามีค่า Ad_rank ใน session หรือไม่
                    if (isset($_SESSION['bagdrop_member_Ad_rank'])) {
                        // เก็บค่า Ad_rank ในตัวแปร
                        $Ad_rank = $_SESSION['bagdrop_member_Ad_rank'];
                        // เช็คว่า Ad_rank ไม่เท่ากับ 'Admin2' และไม่เท่ากับ 'Admin3'
                        if ($Ad_rank !== 'Admin2' && $Ad_rank !== 'Admin3') {
                            // แสดงลิงก์หรือส่วนนี้เมื่อเงื่อนไขเป็นจริง
                    ?>
                            <a href="#" class="navMenu" onclick="showContent('loyalty', 'loyalty-link')" id="loyalty-link">
                                สมาชิก
                            </a>

                            <a href="#" style="display: none;" class="navMenu" onclick="displayEditM('edit-mem', 'edit-m-link')" id="edit-mem-link">
                                <!-- ส่วนนี้จะไม่แสดงเมื่อเงื่อนไขเป็นจริง -->
                            </a>

                            <a href="#" class="navMenu" onclick="showContent('grantAC', 'grantAC-link')" id="grantAC-link">
                                บริหาร
                            </a>
                    <?php
                        }
                    }
                    ?>

                    <a href="#" style="display: none;" class="navMenu" onclick="showContent('addAC', 'addAC-link')" id="addAC-link">

                    </a>

                    <a href="#" style="display: none;" class="navMenu" onclick="showContent('editAC', 'editAC-link')" id="editAC-link">

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
                    <div class="cardy" style="padding: 5%; margin-top: 8%; margin-bottom: -5%; margin-left: 10%; display: flex; flex-direction: column; align-items: center;">
                        <span style="font-size: 20px; font-weight: bold; margin-bottom: 10px;">พาร์ทเนอร์ทั้งหมด</span>
                        <h3 style="margin-top: 0; font-size: 20px; font-weight: bold;"><b><?= $data['total_partner']; ?></b></h3>
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

                    <form id="searchFormP" method="post" enctype="multipart/form-data" onsubmit="return submitSearchForm();">
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

    <!-- search -->
    <div id="search" style="display: none;">
        <div style="  padding: 10px; background-color: white;">
            <div class="d-flex align-items-center" style="margin:10px 0 10px 0;">
                <div class="flex-grow-1 text-center">
                    <h4 style="font-weight:900; ">ติดตามกระเป๋า</h4>
                </div>
                <a href=""><img src="images/back.png" style="width:40px;height:40px;"></a>
            </div>
            <input id="search-btn" type="text" placeholder="ค้นหาจากชื่อผู้ฝากหรือหมายเลขออเดอร์">
            <div id="results" style="background-color: #121138; border-radius:5px;">
                <!-- Search results will be inserted here -->
            </div>
            <div style=" background-color: #121138; border-radius:5px;">
                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();

                // สร้างคำสั่ง SQL เพื่อค้นหาข้อมูล
                $sql = "SELECT * 
                        FROM bagreserv 
                        JOIN register ON register.m_id = bagreserv.m_id";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $mem_img = $row['usr_img'];
                        $bag_id = $row['bag_id'];
                        $market_name = $row['mk_name'];
                        // แสดงผลลัพธ์ที่ค้นพบในรูปแบบ HTML

                        echo '<div class="d-flex">';
                        echo '<div class="col-6">';

                        echo '<div class="order_search">';
                        echo '<button type="button" onclick="toggleAside(\'aside_' . $row["order_number"] . '\')" style="width: 100%; padding: 10px;  border: 0px;  text-align:left;">';
                        echo '<div class="d-flex">';
                        echo '<div>';
                        echo '<label style="font-size:20px; font-weight:500;">Order ' . $row["order_number"] . '</label><br>';
                        echo '<label style="font-size:20px; font-weight:500;">'  . $row["m_fname"] . ' ' . $row["m_lname"] . '</label>';
                        echo '</div>';
                        echo '</div>';
                        echo '</button>';
                        echo '</div>';
                        echo '</div>';

                        echo '<div style="background-color:white; width:100%;">';
                        echo '<div class="container">';
                        echo '<aside id="aside_' . $row["order_number"] . '" style="display: none;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); ">';
                        echo '<div class="d-flex justify-content-center align-items-center" style="background-color: #121138; color:white; border-radius:5px; height: 50px;">';
                        echo '<label style="font-size:18px;">ร้านค้าที่ฝาก : <span style="color:#eddc45">'  . $row["mk_name"] . '</span></label>';
                        echo '</div>';
                        echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                        echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                        echo '<div style="margin-left: 10px;">';
                        echo '<label style="font-size:20px; font-weight:500;">Order ' . $row["order_number"] . '</label><br>';
                        echo '<label style="font-size:20px; font-weight:500;">' . $row["m_fname"] . ' ' . $row["m_lname"] . '</label>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                        echo '<div style="text-align:left;">';
                        echo '<label style="font-size:20px; font-weight:500;">วันที่ฝาก : ' .  '<span style="color:#808000">' . $row["reserv_date"] . ' ' .  $row["reserv_time"] . '</span>' . '</label><br>';
                        echo '<label style="font-size:20px; font-weight:500;">วันที่มารับ : ' .  '<span style="color:#808000">' . $row["retrive_date"] . ' ' .  $row["retrive_time"] . '</span>' . '</label><br>';
                        echo '<label style="font-size:20px; font-weight:500;">จำนวนกระเป๋า : ' .  '<span style="color:#808000">' . $row["quantity"] . '</span>' . '</label><br>';
                        echo '<label style="font-size:20px; font-weight:500;">สถานะกระเป๋า : ' .  '<span style="color:#808000">' . $row["status"] . '</span>' . '</label>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                        echo '<button  type="button" id="viewOrder" name="viewOrder" onclick="displayContent(\'or_detail\', \'or_detail-link\', \'' . $bag_id . '\' , \'' . $market_name . '\')"  style="display: inline-block; height: 30px; width: 150px; background-color: #949346; color: black; border: none; border-radius: 10px; cursor: pointer; font-weight: bold;">แสดงรายละเอียด</button><br>';
                        echo '<button type="button"  style="display: inline-block; height: 30px; width: 150px; background-color: #ffed47; color: black; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; margin-left: 50px;">แก้ไขข้อมูล</button>';
                        echo '</div>';
                        echo '</aside>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                function displayContent(contentId, clickedLinkId, bag_id, market_name) {
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


                    // ถ้าคลิกที่ 'contact-link' ให้ซ่อน slide-bg3
                    if (clickedLinkId === 'or_detail-link') {
                        document.getElementById('search').style.display = 'none';

                        document.querySelector('.slide-bg3').style.display = 'none';

                    }

                    $.ajax({
                        type: "POST",
                        url: "crud/admin_retrive.php",
                        data: {
                            bag_id: bag_id,
                            market_name: market_name
                        },
                        success: function(response) {
                            if ($('#or_detail').length) {

                                $('#or_detail').html(response);
                            } else {
                                console.error('or_detail div not found');
                            }
                        },
                        error: function(xhr, status, error) {

                            console.error(xhr.responseText);
                        }
                    });
                }

                document.getElementById('search-btn').addEventListener('keyup', function() {
                    var query = this.value.trim();

                    if (query.length > 0) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', 'crud/admin_search.php?q=' + encodeURIComponent(query), true);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                document.getElementById('results').innerHTML = xhr.responseText;
                            }
                        };
                        xhr.send();
                    } else {
                        document.getElementById('results').innerHTML = '';
                    }
                });
            </script>

        </div>
    </div>
    <div id="or_detail" style="display: none; padding:0; margin:0;"></div>
    <!-- end search -->

    <!-- loyalty -->
    <div id="loyalty" style="display: none;">
        <div class="d-flex align-items-center" style="margin:10px 0 10px 0;">
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900; ">สมาชิก</h4>
            </div>
            <a href=""><img src="images/back.png" style="width:40px;height:40px;"></a>
        </div>
        <center><input id="searchM-btn" type="text" placeholder="ค้นหาสมาชิก"></center>
        <div id="resultsM" style="padding:10px; border-radius:5px;">
            <!-- Search results will be inserted here -->
        </div>
        <div style="padding: 10px;">
            <?php
            $db = new ConnectDb();
            $conn = $db->getConn();

            // สร้างคำสั่ง SQL เพื่อค้นหาข้อมูล
            $sql = "SELECT * FROM register";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $mem_img = $row['usr_img'];
                    $mem_id = $row['m_id'];
                    $mem_fname = $row['m_fname'];
                    $mem_lname = $row['m_lname'];
                    $mem_email = $row['m_email'];
                    $mem_password = $row['m_password'];

                    echo '<div class="d-flex">';
                    echo '<div style="width:50%;">';

                    echo '<div style="padding:5px;">';
                    echo '<button type="button" onclick="toggleAside(\'aside_' . $mem_id . '\')" style="width: 100%; padding: 10px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); border: 0; border-radius:10px; background-color:white;">';
                    echo '<div class="d-flex">';
                    echo '<div style="text-align:center;">';
                    echo '<label style="font-size:20px; font-weight:500;"><img class="noti-img" src="images/usr_img/' . $mem_img . '"> ' . $mem_fname . ' ' . $mem_lname . '</label>';
                    echo '</div>';
                    echo '</div>';
                    echo '</button>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div style="background-color:white; width:80%; padding:5px;">';
                    echo '<div class="container">';
                    echo '<aside id="aside_' . $mem_id . '" style="display: none; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);">';
                    echo '<div class="d-flex justify-content-center align-items-center" style="background-color: #121138; color:white; border-radius:5px; height: 50px;"></div>';
                    echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                    echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                    echo '<div style="margin-left: 10px;">';
                    echo '<label style="font-size:20px; font-weight:500;">' . $mem_fname . ' ' . $mem_lname . '</label>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                    echo '<div style="text-align:left;">';
                    echo '<label style="font-size:20px; font-weight:500;">ชื่อ : <span style="color:#808000">' . $mem_fname . '</span></label><br>';
                    echo '<label style="font-size:20px; font-weight:500;">นามสกุล : <span style="color:#808000">' . $mem_lname . '</span></label><br>';
                    echo '<label style="font-size:20px; font-weight:500;">อีเมล : <span style="color:#808000">' . $mem_email . '</span></label><br>';
                    echo '<label style="font-size:20px; font-weight:500;">รหัสผ่าน : <span style="color:#808000">' . $mem_password . '</span></label>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                    echo '<button type="button" onclick="displayEditM(\'edit-mem\', \'edit-mem-link\', \'' . $mem_id . '\' )"   style="display: inline-block; height: 30px; width: 150px; background-color: #ffed47; color: black; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; margin-left: 50px;">แก้ไขข้อมูล</button>';
                    echo '</div>';
                    echo '</aside>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>

        <script>
            function displayEditM(contentId, clickedLinkId, mem_id) {
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

                if (clickedLinkId === 'edit-mem-link') {
                    document.querySelector('.slide-bg3').style.display = 'none';
                    document.getElementById('loyalty').style.display = 'none';
                }


                $.ajax({
                    type: "POST",
                    url: "crud/edit_member.php",
                    data: {
                        mem_id: mem_id
                    },
                    success: function(response) {
                        if ($('#edit-mem').length) {

                            $('#edit-mem').html(response);
                        } else {
                            console.error('or_detail div not found');
                        }
                    },
                    error: function(xhr, status, error) {

                        console.error(xhr.responseText);
                    }
                });

            }

            document.getElementById('searchM-btn').addEventListener('keyup', function() {
                var query = this.value.trim();

                if (query.length > 0) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'crud/admin_search.php?qM=' + encodeURIComponent(query), true);
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById('resultsM').innerHTML = xhr.responseText;
                        }
                    };
                    xhr.send();
                } else {
                    document.getElementById('resultsM').innerHTML = '';
                }
            });
        </script>

    </div>
    <!-- end loyalty -->

    <!-- edit member -->
    <div id="edit-mem" style="display: none;"></div>

    <!-- grant access -->
    <div id="grantAC" style="display:none">
        <div class="d-flex align-items-center" id="editAd">
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight: 900; font-size: 28px;">กำหนดสิทธิ์</h4>
            </div>
            <a href=""><img src="images/back.png" style="width:40px;height:40px;"></a>
        </div>

        <center>
            <table>
                <tr>
                    <th>ตำแหน่ง</th>
                    <th>ไอดี</th>
                    <th>แก้ไข</th>
                    <th>ลบ</th>
                </tr>
                <tr>
                    <?php
                    // Database connection
                    $db = new ConnectDb();
                    $conn = $db->getConn();

                    // Query to fetch data from the database
                    $sql = "SELECT Ad_rank, admin_id, m_password FROM register WHERE urole LIKE '%admin%'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($row["Ad_rank"]) . '</td>';
                            echo '<td>' . htmlspecialchars($row["admin_id"]) . '</td>';
                            echo '<td><a onclick="showEdit(\'editAC\', \'editAC-link\', \'' . htmlspecialchars($row["admin_id"]) . '\')"><img class="grant-img" src="images/edit.png" alt="edit access"></a></td>';
                            echo '<td><a onclick="deleteAdmin(\'' . htmlspecialchars($row["admin_id"]) . '\')"><img class="grant-img" src="images/del.png" alt="delete access"></a></td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="4">No data found</td></tr>';
                    }

                    $conn->close();
                    ?>
                </tr>

            </table>

            <br>
            <button class="grant-btn" onclick="showContent('addAC', 'addAC-link')" type="button">เพิ่มแอดมิน</button>
        </center>

        <script>
            function deleteAdmin(adminId) {
                if (confirm('คุณแน่ใจหรือไม่ว่าจะทำการลบแอดมิน ' + adminId + '?')) {
                    // Create AJAX request
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'crud/admin_delete.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            alert(xhr.responseText); // Optionally alert the response from the server
                            // Reload the page to see the updated data
                            location.reload();
                        }
                    };

                    // Send admin_id to delete_admin.php
                    xhr.send('admin_id=' + encodeURIComponent(adminId));
                }
            }
        </script>
    </div>
    <!-- add access -->
    <div id="addAC" style="display: none;">
        <div class="d-flex align-items-center" id="editAd">
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900; font-size: 28px;">เพิ่มผู้ดูแล</h4>
            </div>
            <a onclick="showContent('grantAC', 'grantAC-link')"><img src="images/back.png" style="width:40px;height:40px;"></a>
        </div>
        <form onsubmit="insertData(event)">
            <center>
                <table>
                    <tr>
                        <th>ตำแหน่ง</th>
                        <th>ไอดี</th>
                        <th>รหัสผ่าน</th>
                    </tr>
                    <tr>
                        <td>
                            <select name="roleAdmin" id="Adrole">
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin2">Admin2</option>
                                <option value="Admin3">Admin3</option>
                            </select>
                        </td>
                        <td><input type="text" id="ad-id" name="id" placeholder="Enter ID"></td>
                        <td><input type="text" id="ad-pass" name="password" placeholder="Enter Password"></td>
                    </tr>
                </table>

                <br>
                <button class="grant-btn" name="add-admin" type="submit">ตกลง</button>
            </center>
        </form>

        <script>
            function insertData(event) {
                event.preventDefault(); // ป้องกันไม่ให้ฟอร์มส่งแบบปกติ

                // รับข้อมูลจากฟอร์ม
                var roleAdmin = document.getElementById('Adrole').value;
                var id = document.getElementById('ad-id').value;
                var password = document.getElementById('ad-pass').value;

                // สร้างคำขอ AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'crud/admin_insert.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // แสดงข้อความตอบกลับจากเซิร์ฟเวอร์
                        alert(xhr.responseText);

                        location.reload();
                    }
                };

                // ส่งข้อมูลฟอร์ม
                var data = 'roleAdmin=' + encodeURIComponent(roleAdmin) +
                    '&id=' + encodeURIComponent(id) +
                    '&password=' + encodeURIComponent(password);
                xhr.send(data);
            }
        </script>

    </div>

    <!-- edit access -->
    <div id="editAC" style="display: none;">
        <div class="d-flex align-items-center" id="editAd">
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900; font-size: 28px;">แก้ไขข้อมูล</h4>
            </div>
            <a onclick="showContent('grantAC', 'grantAC-link')"><img src="images/back.png" style="width:40px;height:40px;"></a>
        </div>
        <form id="edit-form" onsubmit="submitEditForm(event)">
            <center>
                <table>
                    <tr>
                        <th>ตำแหน่ง</th>
                        <th>ไอดี</th>
                        <th>รหัสผ่าน</th>
                    </tr>

                    <tr>

                        <td>
                            <select name="roleAdmin" id="edit-role">
                                <option value="Super Admin">Super Admin</option>
                                <option value="Admin2">Admin2</option>
                                <option value="Admin3">Admin3</option>
                            </select>
                        </td>

                        <td>
                            <input type="text" id="edit-id" name="id" placeholder="Enter ID" value="<?php echo htmlspecialchars($row['admin_id']); ?>">
                            <input type="hidden" id="original-id" name="original_id" value="<?php echo htmlspecialchars($row['admin_id']); ?>">
                        </td>
                        <td><input type="text" id="edit-pass" name="password" placeholder="Enter Password"></td>
                    </tr>
                </table>

                <br>
                <button class="grant-btn" type="submit">ตกลง</button>
            </center>
        </form>

        <script>
            function showEdit(contentId, clickedLinkId, admin_id) {
                // Hide all content sections
                document.querySelectorAll('.col-9 > *').forEach(el => {
                    el.style.display = 'none';
                });

                // Show only the selected content section
                document.getElementById(contentId).style.display = 'block';

                // Remove 'active' class from all nav links
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });

                // Add 'active' class to the clicked nav link
                document.getElementById(clickedLinkId).classList.add('active');

                // Hide specific sections based on clicked link
                if (clickedLinkId === 'contact-link' || clickedLinkId === 'request-link' || clickedLinkId === 'approve-link' ||
                    clickedLinkId === 'not-approve-link' || clickedLinkId === 'cancle-link' || clickedLinkId === 'search-link' || clickedLinkId === 'loyalty-link' || clickedLinkId === 'grantAC-link') {
                    document.getElementById('detail_shop').style.display = 'none';
                    document.getElementById('approve_detail').style.display = 'none';
                    document.getElementById('or_detail').style.display = 'none';
                    document.getElementById('addAC').style.display = 'none';
                    document.getElementById('editAC').style.display = 'none';
                    document.querySelector('.slide-bg3').style.display = 'none';
                }

                if (clickedLinkId === 'addAC-link' || clickedLinkId === 'editAC-link') {
                    document.querySelector('.slide-bg3').style.display = 'none';
                    document.getElementById('grantAC').style.display = 'none';
                }

                // Fetch admin data and populate form
                fetch(`crud/fetch_admin_data.php?admin_id=${admin_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                        } else {
                            document.getElementById('edit-role').value = data.urole;
                            document.getElementById('edit-id').value = data.admin_id;
                            document.getElementById('original-id').value = data.admin_id; // Set the original admin_id
                            document.getElementById('edit-pass').value = data.m_password;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }



            function submitEditForm(event) {
                event.preventDefault();

                var originalAdminId = document.getElementById('original-id').value; // Store the original admin ID
                var newAdminId = document.getElementById('edit-id').value;
                var roleAdmin = document.getElementById('edit-role').value;
                var adminPass = document.getElementById('edit-pass').value;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'crud/admin_edit.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        alert(xhr.responseText);
                        location.reload();
                    }
                };

                xhr.send('original_admin_id=' + encodeURIComponent(originalAdminId) +
                    '&new_admin_id=' + encodeURIComponent(newAdminId) +
                    '&roleAdmin=' + encodeURIComponent(roleAdmin) +
                    '&adminPass=' + encodeURIComponent(adminPass));
            }
        </script>
    </div>


    <!-- end grant access -->

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
    <!-- search -->
    <div id="searchP" style="display: none;">

        <div id="search-list"></div>

    </div>

    <!-- End search -->
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

        $sql2 = "SELECT * FROM market WHERE market.status = 'approve'";
        $rs2 = mysqli_query($conn, $sql2);
        while ($data2 = mysqli_fetch_array($rs2)) {
        ?>
            <!--  -->
            <div class="card2" onclick="postApproveDetail('approve_detail', 'approve_detail-link', <?= $data2['mk_id']; ?>)">

                <div class="col-2">
                    <?= $data2['mk_name']; ?>
                </div>
                <div class="col-10">
                    <?= $data2['location']; ?>
                </div>

            </div>
        <?php } ?>

    </div>
    <!-- End approve -->
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

        $sql2 = "SELECT * FROM market WHERE market.status = 'approve'";
        $rs2 = mysqli_query($conn, $sql2);
        while ($data2 = mysqli_fetch_array($rs2)) {
        ?>
            <!--  -->
            <div class="card2" onclick="postApproveDetail('approve_detail', 'approve_detail-link', <?= $data2['mk_id']; ?>)">

                <div class="col-2">
                    <?= $data2['mk_name']; ?>
                </div>
                <div class="col-10">
                    <?= $data2['location']; ?>
                </div>

            </div>
        <?php } ?>

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

        <?php
        // เชื่อมต่อฐานข้อมูล
        $db = new ConnectDb();
        $conn = $db->getConn();

        $sql2 = "SELECT * FROM market WHERE market.status = 'not_approve'";
        $rs2 = mysqli_query($conn, $sql2);
        while ($data2 = mysqli_fetch_array($rs2)) {
        ?>
            <!--  -->
            <div class="card2" onclick="postnot_ApproveDetail('not-approve_detail', 'not-approve_detail-link', <?= $data2['mk_id']; ?>)">
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

        <?php
        // เชื่อมต่อฐานข้อมูล
        $db = new ConnectDb();
        $conn = $db->getConn();

        $sql2 = "SELECT * FROM market WHERE market.status = 'cancel'";
        $rs2 = mysqli_query($conn, $sql2);
        while ($data2 = mysqli_fetch_array($rs2)) {
        ?>
            <!--  -->
            <div class="card2" onclick="postcancleDetail('cancle_detail', 'cancle_detail-link', <?= $data2['mk_id']; ?>)">

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


</div>
<!-- End cancle -->

<!-- รายละเอียดคำขอร้าน -->
<div id="detail_shop" style="display: none;"></div>
<!--  -->

<!-- รายละเอียดคำขอร้าน approve -->
<div id="approve_detail" style="display: none;"></div>
<!--  -->

<!-- รายละเอียดคำขอร้าน not-approve -->
<div id="not-approve_detail" style="display: none;"></div>
<!--  -->

<!-- รายละเอียดยกเลิกร้าน cancle -->
<div id="cancle_detail" style="display: none;"></div>
<!--  -->

<!-- รายละเอียด search -->
<div id="search_detail" style="display: none;"></div>
<!--  -->


<!-- End ระบบพาร์ทเนอร์ -->


<!-- end col-12 -->
</div>


<!--  -->
<script>
    function submitSearchForm() {
        var form = document.getElementById("searchFormP");
        var formData = new FormData(form);

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("search-list").innerHTML = this.responseText;
                showContent('searchP');
            }
        };
        document.querySelector('.slide-bg3').style.display = 'none';

        xhttp.open("POST", "pages/admin_part_detail/search_handler.php", true); // ส่งค่าไปที่ไฟล์เดียวกัน
        xhttp.send(formData);
        return false; // ป้องกันการรีเฟรชหน้า
    }

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
            document.getElementById('search').style.display = 'none';
            document.getElementById('searchP').style.display = 'none';
            document.getElementById('search_detail').style.display = 'none';
            document.getElementById('request').style.display = 'none';
            document.getElementById('approve').style.display = 'none';
            document.getElementById('cancle').style.display = 'none';
            document.getElementById('not-approve').style.display = 'none';
            document.querySelector('.slide-bg3').style.display = 'block';
        }

        // ถ้าคลิกที่ 'contact-link' ให้ซ่อน slide-bg3
        if (clickedLinkId === 'contact-link' || clickedLinkId === 'request-link' || clickedLinkId === 'approve-link' ||
            clickedLinkId === 'not-approve-link' || clickedLinkId === 'cancle-link' || clickedLinkId === 'search-link' || clickedLinkId === 'loyalty-link' || clickedLinkId === 'grantAC-link') {
            document.getElementById('detail_shop').style.display = 'none';
            document.getElementById('approve_detail').style.display = 'none';
            document.getElementById('not-approve_detail').style.display = 'none';
            document.getElementById('searchP').style.display = 'none';
            document.getElementById('cancle_detail').style.display = 'none';
            document.getElementById('or_detail').style.display = 'none';
            document.getElementById('addAC').style.display = 'none';
            document.getElementById('editAC').style.display = 'none';
            document.getElementById('edit-mem').style.display = 'none';
            document.querySelector('.slide-bg3').style.display = 'none';

        }

        if (clickedLinkId === 'addAC-link' || clickedLinkId === 'editAC-link') {
            document.querySelector('.slide-bg3').style.display = 'none';
            document.getElementById('grantAC').style.display = 'none';
        }

    }

    let currentlyOpenAsideId = null;

    function toggleAside(asideId) {
        // Get all aside elements
        var asides = document.querySelectorAll('aside');

        // Close the currently open aside if it's not the same as the one being clicked
        if (currentlyOpenAsideId && currentlyOpenAsideId !== asideId) {
            document.getElementById(currentlyOpenAsideId).style.display = 'none';
        }

        // Get the specific aside element by ID
        var aside = document.getElementById(asideId);

        // Toggle the display of the specific aside
        if (aside) {
            var asideStyle = window.getComputedStyle(aside);
            if (asideStyle.display === "none" || asideStyle.display === "") {
                aside.style.display = "block";
                currentlyOpenAsideId = asideId;
            } else {
                aside.style.display = "none";
                currentlyOpenAsideId = null;
            }
        }
    }

    function postSearchDetail(detailId, linkId, mk_id) {
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
                document.getElementById(detailId).innerHTML = this.responseText;
                document.getElementById('request').style.display = 'none';
                document.getElementById('approve').style.display = 'none';
                document.getElementById('not-approve').style.display = 'none';
                document.getElementById('cancle').style.display = 'none';
                document.getElementById('search').style.display = 'none';
                document.getElementById('searchP').style.display = 'none';
                if (detailId === 'search_detail') {
                    document.getElementById('search_detail').style.display = 'block';
                    // document.getElementById('not-approve_detail').style.display = 'none';
                } else {
                    // คำสั่งอื่น ๆ ที่คุณต้องการทำ
                }
            }
        };
        // สร้างคำขอ POST เพื่อส่งข้อมูลไปยังไฟล์ PHP
        xhttp.open("POST", "pages/admin_part_detail/search_detail.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("mk_id=" + mk_id);
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
                document.getElementById('approve').style.display = 'none';

                if (detailId === 'detail_shop') {
                    document.getElementById('detail_shop').style.display = 'block';
                    // document.getElementById('approve_detail').style.display = 'none';
                } else {}
            }
        };
        xhttp.open("POST", "pages/admin_part_detail/admin_detail_shop.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("mk_id=" + mk_id);
    }


    // approve_detail
    function postApproveDetail(detailId, linkId, mk_id) {
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
        // สร้าง XMLHttpRequest object
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(detailId).innerHTML = this.responseText;
                document.getElementById('request').style.display = 'none';
                document.getElementById('approve').style.display = 'none';
                document.getElementById('not-approve').style.display = 'none';
                if (detailId === 'approve_detail') {
                    document.getElementById('approve_detail').style.display = 'block';
                } else {}
            }
        };
        xhttp.open("POST", "pages/admin_part_detail/admin_approve_shop.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("mk_id=" + mk_id);
    }

    function postnot_ApproveDetail(detailId, linkId, mk_id) {
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
                document.getElementById(detailId).innerHTML = this.responseText;
                document.getElementById('request').style.display = 'none';
                document.getElementById('approve').style.display = 'none';
                document.getElementById('not-approve').style.display = 'none';
                if (detailId === 'not-approve_detail') {
                    document.getElementById('not-approve_detail').style.display = 'block';
                    // document.getElementById('not-approve').style.display = 'none';
                } else {}
            }
        };
        xhttp.open("POST", "pages/admin_part_detail/admin_not-approve_shop.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("mk_id=" + mk_id);
    }

    function postcancleDetail(detailId, linkId, mk_id) {
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
                document.getElementById(detailId).innerHTML = this.responseText;
                document.getElementById('request').style.display = 'none';
                document.getElementById('approve').style.display = 'none';
                document.getElementById('not-approve').style.display = 'none';
                document.getElementById('cancle').style.display = 'none';
                if (detailId === 'cancle_detail') {
                    document.getElementById('cancle_detail').style.display = 'block';

                } else {
                    // คำสั่งอื่น ๆ ที่คุณต้องการทำ
                }
            }
        };
        xhttp.open("POST", "pages/admin_part_detail/admin_cancle_shop.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("mk_id=" + mk_id);
    }
</script>

<!-- modal -->
<script>
    function showContent2(mkId) {
        // ใช้ AJAX เพื่อดึงเนื้อหา modal
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'pages/admin_part_detail/modalEdit.php?id=myStatus_1&mk_id=' + mkId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // โหลด response ลงใน modal container
                document.getElementById('modalContainer').innerHTML = xhr.responseText;

                // แสดง modal
                var modal = document.getElementById('myStatus_1');
                if (modal) {
                    modal.style.display = 'block';
                }

                // เรียกใช้งานฟังก์ชัน setupModalEventListeners() และส่งค่า mkId มาด้วย
                setupModalEventListeners(mkId);
            }
        };
        xhr.send();
    }

    function setupModalEventListeners(mkId) {
        var modal = document.getElementById('myStatus_1');
        var statusOptions = modal.querySelectorAll('.status-option');
        var textarea = modal.querySelector('textarea[name="cause"]');
        var cancelBtn = document.getElementById('cancelBtn');
        var submitBtn = document.getElementById('ok');
        var selectedStatus = null;

        statusOptions.forEach(function(option) {
            option.addEventListener('click', function() {
                statusOptions.forEach(function(opt) {
                    opt.classList.remove('active');
                });
                option.classList.add('active');
                selectedStatus = option.getAttribute('data-status');

                if (selectedStatus === 'closed' || selectedStatus === 'cancel') {
                    textarea.style.display = 'block';
                    textarea.setAttribute('required', true);
                } else {
                    textarea.style.display = 'none';
                    textarea.removeAttribute('required');
                }
            });
        });

        submitBtn.addEventListener('click', function() {
            if (selectedStatus === null) {
                alert('กรุณาเลือกสถานะ');
                return;
            }

            if ((selectedStatus === 'closed' || selectedStatus === 'cancel') && !textarea.value) {
                alert('กรุณากรอกสาเหตุ');
                return;
            }

            // ตรวจสอบว่า mk_id ไม่เป็นค่าว่างหรือ null
            if (!mkId || mkId === '') {
                alert('ไม่พบ mk_id');
                return;
            }

            // ส่งค่าไปยัง update_status.php
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'pages/admin_part_detail/update_status.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    alert('อัพเดทสถานะเรียบร้อย');
                    modal.style.display = 'none';
                    location.reload();
                }
            };

            // ส่งข้อมูลในรูปแบบของคีย์-ค่า
            var formData = 'status=' + selectedStatus + '&cause=' + encodeURIComponent(textarea.value) + '&mk_id=' + mkId;
            xhr.send(formData);
        });

        cancelBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    }
</script>
<!-- end modal -->
<!--  -->
<style>
    .col-3 {
        flex: 0 0 auto;
        width: 25%;
        height: 100%;
    }

    .nav {
        display: flex;
        justify-content: center;
        align-items: center;
    }


    .cardy {
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
        margin-top: 8%;
        margin-bottom: -5%;
        margin-left: 10%;
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
    input[type="email"],
    input[type="password"] {
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

    .order_search {
        border-radius: 10px;
        padding: 10px;
    }

    .noti-img {
        border-radius: 50%;
        height: 60px;
        width: 60px;
        margin-right: 10px;
    }

    .depo-drop {
        width: 90%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 14px;
        box-sizing: border-box;
        border: none;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        background-color: white;
    }

    .depo-container {
        display: grid;
        row-gap: 0px;
        grid-template-columns: 1fr 1fr;
        width: 90vw;
        padding: 30px;
    }



    @media (max-width: 1024px) {
        .depo-container {
            grid-template-columns: 1fr;
        }
    }

    .card {
        width: 250px;
        border-radius: 10px;
        text-align: center;
        height: fit-content;
        margin-left: 10px;
    }

    .card-body {
        border-radius: 0 0 10px 10px;
    }

    #search-btn {
        background-image: url('images/search.png');
        background-repeat: no-repeat;
        background-size: 30px;
        background-color: white;
        width: 30%;
        background-position: 20px 5px;
        text-align: center;
    }

    #searchM-btn {
        background-image: url('images/search.png');
        background-repeat: no-repeat;
        background-size: 30px;
        background-color: white;
        width: 30%;
        background-position: 20px 5px;
        text-align: center;
    }

    table {
        width: 60%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #d9d9d9;
    }

    .grant-img {
        width: 30px;
        height: 30px;
        cursor: pointer;
    }

    .grant-btn {
        margin-top: 10px;
        background-color: #abab7e;
        border-radius: 5px;
        width: 100px;
        border: none;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    #Adrole {
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        border: none;
    }

    #ad-id {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
    }

    #ad-pass {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
    }

    #editAd {
        margin: 3%;
    }
</style>