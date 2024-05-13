<!-- nav -->
<div class="col-md-12">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #121139;">
        <div class="container-fluid">


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNavDarkDropdown" aria-expanded="true" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>



            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">

                    <div class="navbar-brand mb-0 h1" href="?page=home"><img alt="logo" src="images/newlogobd.png" width="8%"></div>

                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['bagdrop_member_id'])) : ?>
                            <button type="button" class="notify-btn" data-bs-toggle="modal" data-bs-target="#notificationModal">
                                <img src="images/notifybell.png" style="height: 20px; width:20px; padding: 2px;"><span>การแจ้งเตือน</span>
                            </button>
                        <?php endif; ?>
                    </li>
                </ul>


                <!-- Modal -->
                <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content custom-modal-background">
                            <div class="modal-header custom-header-background text-center">
                                <h3 class="modal-title w-100">แจ้งเตือนรายการที่เพิ่งได้รับ</h3>
                            </div>

                            <div class="modal-body" style="padding: 0;">

                                <?php
                                $db = new ConnectDb();
                                $conn = $db->getConn();
                                $mem_id = $_SESSION['bagdrop_member_id'];

                                $bagsql = "SELECT bag_id FROM bagreserv 
           JOIN register ON register.m_id = bagreserv.m_id 
           WHERE bagreserv.m_id LIKE '$mem_id'";

                                $rs = mysqli_query($conn, $bagsql);
                                $bag_ids = array(); // Initialize an empty array to store bag_ids

                                while ($data = mysqli_fetch_assoc($rs)) {
                                    $bag_ids[] = $data['bag_id']; // Store each bag_id in the array
                                }

                                if ($bag_ids) {
                                    foreach ($bag_ids as $bagid) {
                                        $sql1 = "SELECT * FROM bagreserv 
                                             JOIN register ON register.m_id = bagreserv.m_id 
                                             WHERE bagreserv.m_id LIKE '$mem_id' 
                                             AND bagreserv.bag_id = '$bagid' 
                                             AND status = 'ฝากสำเร็จ'";

                                        $result = $conn->query($sql1);

                                        if ($result->num_rows > 0) {
                                            // Display information for each bag reservation with successful deposit
                                            while ($row = $result->fetch_assoc()) {
                                                $checkDate = findNotifDate($row["curr_timestamp"],  7 * 60 * 60);
                                                echo '<a href="?page=listreserv" style="text-decoration: none;">';
                                                echo '<button  type="button" id="retr-online" name="retr-online"  data-bs-dismiss="modal" style="width: 100%; padding: 0;  border:1px solid; text-align: left;">';
                                                echo '<div style="display: flex; ">';
                                                $baseUrl = 'http://localhost/Travbagdrop/images/';
                                                $filenameFromDB = isset($row['picture']) ? $row['picture'] : ''; // Check if $row['picture'] is set
                                                $filenames = json_decode($filenameFromDB, true); // Ensure associative array

                                                if ($filenames) {
                                                    foreach ($filenames as $filename) {
                                                        // Replace plus signs with spaces
                                                        $filename = str_replace('+', ' ', $filename);
                                                        // Decode URL encoding
                                                        $filename = urldecode($filename);
                                                        // Encode filename for URL
                                                        $encodedFilename = rawurlencode($filename);
                                                        // Construct the full image URL
                                                        $imageUrl = $baseUrl . $encodedFilename;
                                                        echo '<img  src="' . htmlspecialchars($imageUrl) . '"  height="100" width="100"/>'; // Sanitize imageUrl
                                                        // Display only the first image
                                                        break;
                                                    }
                                                }

                                                echo '<div style="background-color: #ffffff; padding: 5px; flex: 1; border-left: 1px solid;">';
                                                echo '<span style="font-size: 20px; font-weight: 600;">ฝากสัมภาระสำเร็จ</span><br>';
                                                echo '<span style="font-size: 18px; font-weight: 600;">หมายเลขออเดอร์ ' . '<span style="color:green;">' . $row["order_number"] . '</span>' . '</span>';
                                                echo '<div style="text-align:end; padding:5px;">';
                                                echo '<small>' . $checkDate . '</small>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</button>';
                                                echo '</a>';
                                            }
                                        }

                                        $sql2 = "SELECT * FROM bagreserv 
                                JOIN register ON register.m_id = bagreserv.m_id 
                                WHERE bagreserv.m_id LIKE '$mem_id' AND bagreserv.bag_id = '$bagid' 
                                AND status = 'คืนสำเร็จ' ";

                                        $result = $conn->query($sql2);

                                        if ($result->num_rows > 0) {

                                            // แสดงข้อมูลที่ค้นพบ
                                            while ($row = $result->fetch_assoc()) {
                                                $checkDate = findNotifDate($row["curr_timestamp"],  7 * 60 * 60);
                                                echo '<a href="?page=listreserv" style="text-decoration: none;">';
                                                echo '<button  type="button" id="retr-online" name="retr-online"  data-bs-dismiss="modal" style="width: 100%; padding: 0;   border:1px solid; text-align: left;">';
                                                echo '<div style="display: flex; ">';
                                                $baseUrl = 'http://localhost/Travbagdrop/images/';
                                                $filenameFromDB = isset($row['picture']) ? $row['picture'] : ''; // Check if $row['picture'] is set
                                                $filenames = json_decode($filenameFromDB, true); // Ensure associative array

                                                if ($filenames) {
                                                    foreach ($filenames as $filename) {
                                                        // Replace plus signs with spaces
                                                        $filename = str_replace('+', ' ', $filename);
                                                        // Decode URL encoding
                                                        $filename = urldecode($filename);
                                                        // Encode filename for URL
                                                        $encodedFilename = rawurlencode($filename);
                                                        // Construct the full image URL
                                                        $imageUrl = $baseUrl . $encodedFilename;
                                                        echo '<img  src="' . htmlspecialchars($imageUrl) . '"  height="100" width="100"/>'; // Sanitize imageUrl
                                                        // Display only the first image
                                                        break;
                                                    }
                                                }



                                                echo '<div style="background-color: #b3afaf; padding: 5px; flex: 1; border-left: 1px solid;">';
                                                echo '<span style="font-size: 20px; font-weight: 600;">คืนสัมภาระสำเร็จ</span><br>';
                                                echo '<span style="font-size: 18px; font-weight: 600;">หมายเลขออเดอร์ ' .  '<span style="color:red;">' . $row["order_number"] . '</span>'  . '</span>';
                                                echo '<div style="text-align:end; padding:5px;">';
                                                echo '<small>' . $checkDate . '</small>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</button>';
                                                echo '</a>';
                                            }
                                        }
                                    }
                                } else {
                                    echo '<h3 style="color:white; text-align:center; margin-top:10px;">ยังไม่มีการแจ้งเตือน</h3>';
                                }



                                function findNotifDate($notif_date, $timezoneOffset)
                                {

                                    $sent_date = (strpos($notif_date, ' ') !== FALSE) ? strtotime($notif_date) : $notif_date;
                                    $localTime = gmdate("Y-m-d H:i:s", time() + $timezoneOffset);

                                    $today = strtotime($localTime);

                                    $calc = $today - $sent_date;
                                    $calcDate = gmdate("d-m-y", $calc);
                                    $calcTime = gmdate("H:i:s", $calc); //Will always be correct

                                    //Get How many days, months and years that has passed
                                    $date_passed = explode("-", $calcDate);
                                    $time_passed = explode(":", $calcTime);

                                    $days_passed = ($date_passed[0] != '01') ? intval($date_passed[0]) - 1 : NULL;
                                    $months_passed = ($date_passed[1] != '01') ? intval($date_passed[1]) - 1 : NULL;
                                    $years_passed = ($date_passed[2] != '70') ? intval($date_passed[2]) - 70 : NULL;

                                    $hours_passed = ($time_passed[0] != '00') ? intval($time_passed[0]) : NULL;
                                    $mins_passed = ($time_passed[1] != '00') ? intval($time_passed[1]) : NULL;
                                    $secs_passed = intval($time_passed[2]);

                                    //Set up your Custom Text output here
                                    $s = ["วินาที", "วินาทีที่แล้ว"];
                                    $m = ["นาที", "วินาทีที่แล้ว", "นาที", "วินาทีที่แล้ว"];
                                    $h = ["ชั่วโมง", "นาทีที่แล้ว", "ชั่วโมง", "นาทีที่แล้ว"];
                                    $d = ["วัน", "ชั่วโมงที่แล้ว", "วัน", "ชั่วโมงที่แล้ว"];
                                    $M = ["เดือน", "วันที่แล้ว", "เดือน", "วันที่แล้ว"];
                                    $y = ["ปี", "เดือนที่แล้ว", "ปี", "ปีที่แล้ว"];

                                    if (
                                        !($days_passed) && !($months_passed) && !($years_passed)
                                        && !($hours_passed) && !($mins_passed)
                                    ) {

                                        $ret = ($secs_passed == 1) ? $secs_passed . ' ' . $s[0] : $secs_passed . ' ' . $s[1];
                                    } else if (
                                        !($days_passed) && !($months_passed) && !($years_passed)
                                        && !($hours_passed)
                                    ) {

                                        $retA = ($mins_passed == 1) ? $mins_passed . ' ' . $m[0] : $mins_passed . ' ' . $m[2];
                                        $retB = ($secs_passed == 1) ?  $secs_passed . ' ' . $m[1] : $secs_passed . ' ' . $m[3];

                                        $ret = $retA . ' ' . $retB;
                                    } else if (!($days_passed) && !($months_passed) && !($years_passed)) {

                                        $retA = ($hours_passed == 1) ? $hours_passed . ' ' . $h[0] : $hours_passed . ' ' . $h[2];
                                        $retB = ($mins_passed == 1) ?  $mins_passed . ' ' . $h[1] : $mins_passed . ' ' . $h[3];

                                        $ret = $retA . ' ' . $retB;
                                    } else if (!($years_passed) && !($months_passed)) {
                                        $retA = ($days_passed == 1) ? $days_passed . ' ' . $d[0] :  $days_passed . ' ' . $d[2];
                                        $retB = ($hours_passed == 1) ? $hours_passed . ' ' . $d[1] : $hours_passed . ' ' . $d[3];

                                        $ret = $retA . ' ' . $retB;
                                    } else if (!($years_passed)) {

                                        $retA = ($months_passed == 1) ? $months_passed . ' ' . $M[0] : $months_passed . ' ' . $M[2];
                                        $retB = ($days_passed == 1) ? $days_passed . ' ' . $M[1] : $days_passed . ' ' . $M[3];

                                        $ret = $retA . ' ' . $retB;
                                    } else {
                                        $retA = ($years_passed == 1) ? $years_passed . ' ' . $y[0] : $years_passed . ' ' . $y[2];
                                        $retB = ($months_passed == 1) ? $months_passed . ' ' . $y[1] : $months_passed . ' ' . $y[3];

                                        $ret = $retA . ' ' . $retB;
                                    }

                                    if (strpos($ret, '-') !== FALSE) {
                                        $ret .= " ( TIME ERROR )-> Invalid Date Provided!";
                                    }

                                    return $ret;
                                }


                                ?>

                            </div>

                        </div>
                    </div>
                </div>


                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php
                        if (!isset($_SESSION['bagdrop_member_id_type']) || $_SESSION['bagdrop_member_id_type'] !== 'partner') {
                            echo '<a class="btn btn-dark custom-button" href="?page=register.p"><b><span class="text-light">สมัครเป็นร้านค้า</span></b></a>';
                        } else {
                            echo '<a class="btn btn-dark custom-button" href="?page=partner_home"><b><span class="text-light">ไปหน้าร้านค้า</span></b></a>';
                        }
                        ?>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-dark custom-button" href="?page=listreserv">
                            <i class="bi bi-person-up"></i> <span class="text-light">รายการฝาก</span>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav" style="margin-right: 20px;">
                    <li class="nav-item">
                        <?php if (isset($_SESSION['bagdrop_member_id']) || (isset($_SESSION['facebook_loggedin'])) || (isset($_SESSION['google_loggedin']))) : ?>
                            <a class="btn btn-dark custom-button" href="crud/logout.php">
                                <i class="bi bi-person-up"></i> <span class="text-light">ออกจากระบบ</span>
                            </a>
                        <?php else : ?>
                            <a class="btn btn-dark custom-button" href="?page=login">
                                <i class="bi bi-person-up"></i> <span class="text-light">เข้าสู่ระบบ</span>
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>

                <!-- <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="btn btn-dark dropdown-toggle custom-button" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="text-light">ติดตาม</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="?page=track_email">ติดตามจากอีเมลล์</a>
                            <hr>
                            <a class="dropdown-item" href="?page=track_onum">ติดตามจากหมายเลขออเดอร์</a>
                            <hr>
                            <a class="dropdown-item" href="?page=track_phone">ติดตามจากเบอร์โทรศัพท์</a>
                        </div>
                    </li>
                </ul> -->

                <div class="dropdown1 text-end">
                    <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Language
                    </a>
                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href=""><span>ไทย</span></a></li>
                        <li><a class="dropdown-item" href=""><span>อังกฤษ</span></a></li>
                        <li><a class="dropdown-item" href=""><span>จีน</span></a></li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>
</div>
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        var dropdownToggles = document.querySelectorAll('.dropdown1 .dropdown-toggle');
        var dropdownMenus = document.querySelectorAll('.dropdown1 .dropdown-menu');

        dropdownToggles.forEach(function (dropdownToggle) {
            dropdownToggle.addEventListener('click', function (event) {
                var dropdownMenu = this.nextElementSibling;
                dropdownMenu.classList.toggle('show');
            });
        });

        document.addEventListener('click', function (event) {
            dropdownMenus.forEach(function (dropdownMenu) {
                if (!event.target.closest('.dropdown1') && dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    });
</script> -->

<!-- css -->
<style>
    .custom-button,
    .dropdown-menu a {
        cursor: pointer;
        background-color: #121139;
        /* สีพื้นหลัง */
        color: white;
        /* สีตัวหนังสือ */

    }

    /* ตั้งค่าให้ dropdown menu มีพื้นหลังเดียวกันกับปุ่มและสีตัวหนังสือ */
    .dropdown-menu {
        background-color: #121139;
    }

    /* ปรับปรุงสีตัวหนังสือของรายการใน dropdown menu เมื่อไม่ถูก hover */
    .dropdown-menu a {
        color: white !important;
        /* ใช้ !important เพื่อให้มีความสำคัญมากกว่า CSS ของ Bootstrap */
    }

    /* ปรับปรุงสีตัวหนังสือเมื่อถูก hover */
    .dropdown-menu a:hover {
        background-color: #0a0a23 !important;
        /* ให้พื้นหลังเป็นสีเข้มขึ้นเล็กน้อยเมื่อ hover */
        color: white;
    }
</style>
<!-- 

 -->
<!-- end nav -->
<div class="pb-3 mb-4 border-bottom" align='center'>
    <div class="header-section">

        <b>
            <h1 style="font-size: 45px;">ไว้วางใจเราให้ดูแลกระเป๋าของคุณแล้วเที่ยวอย่างสบายใจ</h1><b>
                <h2 style="font-size: 35px; margin-bottom: 2vh;">ค้นหาสถานที่รับฝากสัมภาระเลย!!</h2>
                <div style="margin-bottom: 5vh;">
                    <input class="search_input" type="text" id="search-input">
                    <button class="search_button" onclick="searchLocation()"><i class="bi bi-search"></i> ค้นหา</button>
                </div>

    </div>
</div>

<br><br>
<!--  -->
<div class="container pb-3 mb-4  border-bottom" align='center'>

    <br><br><br>

    <!-- Map -->
    <a href="?page=map"><img alt="formap" src="images/รูปแมพ.jpg" width="100%" height="20%" style="margin-top: -8%;"></a>
    <!-- <div style="height: 60vh;" id='map'></div> -->

    <div id='show_latlng'></div>

    <!--  -->
    <input type="hidden" id="latitude">
    <input type="hidden" id="longitude">
    <br>

    <?php
    $db = new ConnectDb();
    $conn = $db->getConn();

    $marketLocations = $db->getMarketLocations();

    ?>
    <!-- End Map -->

    <!--  -->
</div><br>


<!--  -->
<?php
$db = new ConnectDb(); // สมมติว่ามีคลาส ConnectDb สำหรับการเชื่อมต่อกับฐานข้อมูล
$conn = $db->getConn(); // สมมติว่ามีเมทอด getConn() สำหรับการเชื่อมต่อกับฐานข้อมูล

// เริ่มต้นโค้ด HTML สำหรับแสดงรายการ Top Rating
echo '<div class="row">';
echo '<div class="top_rating">';

echo '<div class="text2">จุดหมายปลายทางยอดนิยม</div>';
// สร้างคำสั่ง SQL เพื่อดึงข้อมูลที่ต้องการ
$sql = "SELECT AVG(rating) AS avg_rating, market.mk_img, market.mk_name, market.mk_id
        FROM feedback
        INNER JOIN market ON feedback.mk_id = market.mk_id
        GROUP BY feedback.mk_id
        ORDER BY avg_rating DESC
        LIMIT 3"; // เลือกเฉพาะ 3 ร้านที่มีคะแนนเฉลี่ยสูงสุด

$result = $conn->query($sql);

// เพิ่ม div container สำหรับการแสดงผลร้าน
echo '<div class="card-container">';

// วนลูปเพื่อแสดงข้อมูลในรูปแบบของ card
while ($row = $result->fetch_assoc()) {
    $mk_img = $row['mk_img'];
    echo '<div class="card2">';
    echo '<a href="?page=map&id=' . $row['mk_id'] . '">';
    echo '<img src="images/market/' . $mk_img . '" alt="' . $row['mk_name'] . '" width="290" height="292">';
    echo '<div class="card_name">' . $row['mk_name'] . '</div>';
    echo '</a>';
    echo '</div>';
}

echo '</div>'; // ปิด <div class="card-container">
echo '</div>'; // ปิด <div class="row">
echo '</div>'; // ปิด <div class="top_rating">
?>
<br><br><br>
<!-- End class container  -->


<!-- css -->
<style>
    .search_input {
        padding: 10px;
        font-size: 17px;
        border: 2px solid #ccc;
        /* เปลี่ยนเป็นเส้นขอบ */
        border-radius: 5px;
        /* เพิ่มขอบมนเข้าไป */
        width: 530px;
        /* เพิ่มความยาว */
    }

    .search_button {
        padding: 13px;
        margin-top: 8px;
        margin-left: -2px;
        /* ปรับขนาดเพื่อให้ปุ่มค้นหาตรงกลางกับ input */
        background: #E20101;
        /* เปลี่ยนสีเป็นสีแดง */
        color: white;
        /* เปลี่ยนสีตัวอักษรให้เป็นสีขาว */
        font-size: 17px;
        border: 0px solid #ff6666;
        /* เปลี่ยนสีขอบเป็นสีแดง */
        border-radius: 5px;
        /* เพิ่มขอบมนเข้าไป */
        cursor: pointer;
    }

    /* เมื่อปุ่มถูกกด */
    .search_button:hover {
        background: #ff4d4d;
        /* เปลี่ยนสีเมื่อเมาส์วางทับ */
        border-color: #ff4d4d;
        /* เปลี่ยนสีขอบเมื่อเมาส์วางทับ */
    }

    /* top_rating */
    .top_rating {
        background: linear-gradient(301.94deg, rgba(64, 42, 120, 0.91) 26.67%, #192364 57.95%, #141B4B 87.56%);
        padding-top: 15%;
        /* ความยาวที่คุณต้องการ */
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        /* จัดให้อยู่กึ่งกลางตามแนวนอน */
        width: 100%;
        /* ทำให้ขยายตามความกว้างของหน้าจอ */
        position: relative;
        color: white;
        /* ตั้งสีข้อความเป็นสีขาว */
        text-align: center;
        /* จัดตำแหน่งข้อความกึ่งกลาง */

    }

    .text2 {
        font-size: 34px;
        /* เพิ่มขนาดตัวอักษรเป็น 24px */
        display: flex;
        /* flex-direction: column; */
        justify-content: center;
        align-items: center;
        position: absolute; /* เพิ่มบรรทัดนี้ */
        /* จัดให้อยู่กึ่งกลางตามแนวนอน */
        width: 100%;
        /* ทำให้ขยายตามความกว้างของหน้าจอ */
        position: relative;
        color: white;
        /* ตั้งสีข้อความเป็นสีขาว */
        text-align: center;
        /* จัดตำแหน่งข้อความกึ่งกลาง */
        margin-top: -15%;
        margin-bottom: 15%;
    }

    .card-container {
        width: 100vw; /* ให้ความกว้างเท่ากับ 80% ของความกว้างของหน้าจอ */
        display: flex;
        justify-content: center;
        /* จัดให้ตรงกลางในแนวนอน */
        align-items: center;
        /* จัดให้ตรงกลางในแนวตั้ง */
        scrollbar-width: none;
        /* ซ่อน scrollbar สำหรับ Firefox */
        -ms-overflow-style: none;
        /* ซ่อน scrollbar สำหรับ Internet Explorer/Edge */
        margin-left: -3%;
        /* จัดตำแหน่งให้ตรงกลาง */
        margin-top: -12%;
        /* กำหนดการขยับด้านบน */
    }


    .card-container::-webkit-scrollbar {
        display: none;
        /* ซ่อน scrollbar สำหรับ Chrome, Safari, Opera */
    }

    /* CSS for card */
    .card2 {
        
        flex: 0 0 auto;
        /* กำหนดให้ card ไม่ยืดหรือย่อ */
        margin-bottom: 7%;
        margin-right: 7%;
        /* ระยะห่างระหว่าง card */
        margin-left: 7%;
        /* margin: 5%; */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* เพิ่มสไตล์อื่นๆ ตามต้องการ */
    }

    .card2:last-child {
        margin-right: 0;
        /* ไม่มีระยะห่างของ card ที่เป็นลำดับสุดท้าย */
    }

    .card2 img {
        order: 1;
        border-radius: 10px 10px 0 0;
        /* เพิ่ม border-radius เฉพาะด้านบน */
    }

    .card2 .card_name {
        background-color: #FAF9F6;
        /* สีของการ์ด */
        color: #000;
        /* สีข้อความ */
        padding: 10px;
        /* ขอบเขตของข้อความ */
        text-align: center;
        /* การจัดวางข้อความ */
        margin-top: auto;
        order: 2;
        width: 100%;
        border-radius: 0 0 10px 10px;
        /* เพิ่ม border-radius เฉพาะด้านล่าง */
    }

    a {
        text-decoration: none;
        /* เอาลงขีดใต้ข้อความที่อยู่ในแท็ก <a> ออก */
        color: inherit;
        /* ใช้สีเดียวกับข้อความปกติ */
    }

    .header-section {
        position: relative;
        width: 100%;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: url('images/header.jpg');
        background-color: rgba(71, 31, 173, 0.6);
        background-blend-mode: overlay;
        background-size: cover;
        background-position: right;
        color: white;
        /* Set background color with opacity */
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
    }

    .notify-btn {
        background-color: #fbff00;
        color: #000;
        width: 150px;
        font-size: 16px;
        font-weight: 800;
        border-radius: 5px;
        border: none;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 2px;
    }

    .custom-modal-background {
        background-color: #121138;
    }

    .custom-header-background {
        background-color: #fbff00;
    }
</style>