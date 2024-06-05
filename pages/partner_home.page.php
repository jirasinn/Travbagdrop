<?php
$mk_id = $_SESSION['bagdrop_member_id'];
$_SESSION['mkid'] = $mk_id;
$mk_name = $_SESSION['bagdrop_member_name'];

?>

<div class="row col-12">

    <div class="col-3">

        <div class="slide-bg">
            <div class="d-flex flex-column flex-shrink-0 p-3 " style="width: 350px; background-color: #121139;">

                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();

                // สร้าง SQL query เพื่อดึงข้อมูลร้านค้าและรูปภาพ
                $sql = "SELECT * FROM market WHERE mk_id = $mk_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // หากมีข้อมูลในฐานข้อมูล
                    while ($row = $result->fetch_assoc()) {
                        // ดึงข้อมูลร้านค้าและรูปภาพ
                        $mk_name = $row['mk_name'];
                        $mk_img = $row['mk_img'];

                        // แสดงผลร้านค้าและรูปภาพ
                        echo '<div class="container  text-center ">';
                        echo '<img src="images/market/' . $mk_img . '" class="me-2" width="120" height="122">';
                        echo '<a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none text-center">';
                        echo '<span class="fs-4">ชื่อร้าน: ' . $mk_name . '</span>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    // หากไม่มีข้อมูลในฐานข้อมูล
                    echo "0 results";
                }
                $conn->close();
                ?>

                <br>
                <div style="height: 1px; background-color: white; margin: 10px 0;"></div>

                <ul class="nav nav-pills flex-column mb-auto">

                    <li class="nav-item" style="display: none;">
                        <!-- nav-link active -->
                        <a href="#" class="nav-link text-white" onclick="showContent('noti', 'noti-link')" id="noti-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                        </a>

                    </li>

                    <li class="nav-item" style="display: none;">
                        <!-- nav-link active -->
                        <a href="#" class="nav-link text-white" onclick="showContent('returnBag_btn', 'returnBag_btn-link')" id="returnBag_btn-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                        </a>

                    </li>

                    <li class="nav-item" style="display: none;">
                        <!-- nav-link active -->
                        <a href="#" class="nav-link text-white" onclick="showContent('re_online', 're_online-link')" id="re_online-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                        </a>

                    </li>

                    <li style="display: none;">
                        <a href="#" class="nav-link text-white" onclick="showContent('revieww', 'revieww-link')" id="revieww-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#table"></use>
                            </svg>

                        </a>
                    </li>

                    <li class="nav-item" style="display: none;">
                        <!-- nav-link active -->
                        <a href="#" class="nav-link text-white" onclick="searchContent('srh_order', 'srh_order-link')" id="srh_order_link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                        </a>

                    </li>


                    <li class="nav-item">
                        <!-- nav-link active -->
                        <a href="#" class="nav-link text-white" onclick="showContent('search', 'search-link')" id="search-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                            ระบบค้นหา
                        </a>
                    </li>
                    <div style="height: 1px; background-color: white; margin: 10px 0;"></div>

                    <li class="nav-item">
                        <!-- nav-link active -->
                        <a href="#" class="nav-link text-white" onclick="showContent('monitor', 'monitor-link')" id="monitor-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                            ระบบ Monitor
                        </a>
                    </li>
                    <div style="height: 1px; background-color: white; margin: 10px 0;"></div>

                    <li>
                        <a href="#" class="nav-link text-white" onclick="showContent('deposit', 'deposit-link')" id="deposit-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#table"></use>
                            </svg>
                            ฝากกระเป๋า
                        </a>
                    </li>
                    <div style="height: 1px; background-color: white; margin: 10px 0;"></div>
                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->
                    <li>
                        <a href="#" class="nav-link text-white" onclick="showContent('return_bag','return_bag-link')" id="return_bag-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#grid"></use>
                            </svg>
                            คืนกระเป๋า
                        </a>
                    </li>
                    <div style="height: 1px; background-color: white; margin: 10px 0;"></div>
                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->
                    <li>
                        <a href="#" class="nav-link text-white" onclick="showContent('report')" id="report-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#people-circle"></use>
                            </svg>
                            รายงาน
                        </a>
                    </li>
                    <div style="height: 1px; background-color: white; margin: 10px 0;"></div>
                    <!-- เพิ่ม ID ให้กับแต่ละ nav-link -->
                    <li>
                        <a href="crud/logout.php" class="nav-link text-white" onclick="showContent('logout')" id="logout-link">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#people-circle"></use>
                            </svg>
                            ออกจากระบบ
                        </a>
                    </li>
                    <div style="height: 1px; background-color: white; margin: 10px 0;"></div>
                </ul>

            </div>
        </div>

    </div>
    <!-- end col-3 -->

    <div class="row col-9">
        <div id="dashboard" class="container" style=" margin-top: 5px;">
            <?php
            $db = new ConnectDb();
            $conn = $db->getConn();
            // Count unread notifications after update
            $count_sql = "SELECT COUNT(*) AS unread_count FROM bagreserv 
              WHERE bagreserv.mk_name LIKE '$mk_name' AND noti_status = 'unread'
              AND (status = 'รอดำเนินการ' OR status = 'คืนสำเร็จ' OR status = 'ฝากสำเร็จ')";
            $result = $conn->query($count_sql);

            $unread_count = 0;
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $unread_count = $row['unread_count'];
            }

            $conn->close();
            ?>

            <button type="button" class="round" data-bs-toggle="modal" data-bs-target="#notifyModal" onclick="updateStatusAndResetBadge()">
                <span id="badge" class="badge">
                    <?php echo $unread_count; ?>
                </span>
            </button>

            <script>
                function updateStatusAndResetBadge() {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "crud/update_notiStatus.php", true);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            document.getElementById('badge').innerText = '0';
                        }
                    };
                    xhr.send();
                }
            </script>

            <div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content custom-modal-background">
                        <div class="modal-body">
                            <?php
                            $db = new ConnectDb();
                            $conn = $db->getConn();

                            $sql = "SELECT * FROM bagreserv 
        JOIN register ON register.m_id = bagreserv.m_id 
        WHERE bagreserv.mk_name LIKE '$mk_name' 
        AND (status = 'รอดำเนินการ' OR status = 'คืนสำเร็จ' OR status = 'ฝากสำเร็จ') 
        ORDER BY curr_timestamp DESC LIMIT 6";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {

                                // แสดงข้อมูลที่ค้นพบ
                                while ($row = $result->fetch_assoc()) {
                                    $mk_name = $row['mk_name'];
                                    $mem_img = $row['usr_img'];
                                    $bag_id = $row['bag_id'];
                                    $_SESSION['mkname'] = $mk_name;

                                    echo '<button  type="button" id="retr-online" name="retr-online" onclick="displayContent(\'re_online\', \'re_online-link\', \'' . $bag_id . '\')" data-bs-dismiss="modal" style="width: 100%; padding: 0; border: 0; margin-top: 5px; text-align: left;">';
                                    echo '<div style="display: flex; ">';
                                    echo '<div style="background-color: white; flex: 3; padding: 5px; ">';

                                    echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                                    echo '<span style="font-size: 18px;">'  . $row["m_fname"] . ' ' . $row["m_lname"] . '<br><span style="font-size: 13px;">เวลา ' . $row["reserv_time"] . ' วันที่ ' . $row["reserv_date"] . ' - ' . $row["retrive_time"] . ' วันที่ ' . $row["retrive_date"] .  '</span>' . '</span><br>';
                                    echo '</div>';

                                    echo '<div style="background-color: ' . ($row["status"] == "คืนสำเร็จ" ? '#7d7777' : ($row["status"] == "ฝากสำเร็จ" ? '#76c70c' : ($row["status"] == "รอดำเนินการ" ? '#faf61e' : '#f7f420'))) . '; padding: 5px; flex: 1; display: flex; justify-content: center; align-items: center">';
                                    echo '<span style="font-size: 18px; font-weight: 600;">' . $row["status"] . '</span>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</button>';
                                }
                            } else {
                                echo '<h3 style="color:white; text-align:center;">ยังไม่มีการแจ้งเตือน</h3>';
                            }
                            ?>

                        </div>
                        <div class="modal-footer">
                            <button type="button" onclick="showContent('noti', 'noti-link')" class="btn btn-secondary" data-bs-dismiss="modal">ดูทั้งหมด</button>

                        </div>
                    </div>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                function displayContent(contentId, clickedLinkId, bag_id) {
                    // Show the selected content immediately
                    $('.row.col-9 > *').hide();
                    $('#' + contentId).show();
                    // Update the active class for the clicked link
                    $('.nav-link').removeClass('active');
                    $('#' + clickedLinkId).addClass('active');

                    $.ajax({
                        type: "POST",
                        url: "crud/id_retrive.php",
                        data: {
                            bag_id: bag_id
                        },
                        success: function(response) {
                            if ($('#re_online').length) {

                                $('#re_online').html(response);
                            } else {
                                console.error('re_online div not found');
                            }
                        },
                        error: function(xhr, status, error) {

                            console.error(xhr.responseText);
                        }
                    });
                }
            </script>

            <?php
            $db = new ConnectDb();
            $conn = $db->getConn();
            $storeCode = $_SESSION['mkid'];
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

            $sql4 = "SELECT COUNT(bag_id) AS reserv_amount FROM bagreserv WHERE mk_name LIKE '$mk_name'";
            $rs4 = mysqli_query($conn, $sql4);
            $data4 = mysqli_fetch_array($rs4);

            $bag_amount = $data4['reserv_amount'];
            ?>



            <div class="d-flex justify-content-center" style="padding: 10px;">
                <button type="button" onclick="showContent('revieww', 'revieww-link')" class="d-flex align-items-center justify-content-center" style="background-color: #121138; width:20vw; border-radius: 10px; color: white; padding: 10px; border:none;">
                    <img src="images/star.png" alt="" style="width: 70px; height: 70px;">
                    <div style="padding: 10px; text-align:center; ">
                        <span style="color: #f7f419; font-size:30px; font-weight:500;"><?= number_format($average_rating, 1); ?></span><br>
                        <span style="color: #c4b9bd; "><?= $total_reviews; ?>(ความคิดเห็น)</span>
                        <h5>ความพึงพอใจ</h5>
                    </div>

                </button>
                <div style="background-color: #f7f419; display:block; color: black; border-radius: 10px; padding: 10px; margin: 0 10px 0 10px">
                    <div class="d-flex">
                        <img src="images/pages.png" alt="" style="width: 50px; height: 50px;">
                        <h4><b>รายการฝากทั้งหมด</b></h4>
                    </div>
                    <div class="d-flex align-items-center justify-content-center" style="color: red; display:block; font-size:30px; font-weight:700;">
                        <?= $bag_amount; ?> รายการ
                    </div>
                </div>
                <div style="background-color: #121138; border-radius: 10px; width:20vw; color: white; padding: 10px; text-align:center;">
                    <h4 style="margin-bottom: 25px;;"><b>จำนวนพื้นที่เก็บ</b></h4>
                    <?php
                    // Connect to database (assuming you have already established a database connection)
                    $db = new ConnectDb();
                    $conn = $db->getConn();
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to get all tracked items
                    $sql = "SELECT tracking FROM bagreserv 
                    WHERE mk_id = '$storeCode' AND status != 'คืนสำเร็จ'";
                    $result = $conn->query($sql);

                    // Initialize variables to store counts for each category
                    $spaceA = 0;
                    $spaceB = 0;
                    $spaceC = 0;

                    // If there are tracked items in the result
                    if ($result->num_rows > 0) {
                        // Iterate through each tracked item
                        while ($row = $result->fetch_assoc()) {
                            // Extract the tracking IDs
                            $trackingIDs = explode(", ", $row['tracking']);

                            // Iterate through each tracking ID
                            foreach ($trackingIDs as $trackingID) {
                                // Determine the category (A, B, or C) based on the first letter of the tracking ID
                                $category = substr($trackingID, 0, 1);

                                // Extract the number from the tracking ID
                                $number = intval(substr($trackingID, 1));

                                // Update the available space for the corresponding category
                                switch ($category) {
                                    case 'A':
                                        if ($spaceA < 21) {
                                            $spaceA++;
                                        } else {
                                            $spaceA = 21; // Set to maximum value
                                        }
                                        break;
                                    case 'B':
                                        if ($spaceB < 21) {
                                            $spaceB++;
                                        } else {
                                            $spaceB = 21; // Set to maximum value
                                        }
                                        break;
                                    case 'C':
                                        if ($spaceC < 21) {
                                            $spaceC++;
                                        } else {
                                            $spaceC = 21; // Set to maximum value
                                        }
                                        break;
                                    default:
                                        // Invalid category
                                        break;
                                }
                            }
                        }
                    }

                    // Close the database connection
                    $conn->close();

                    // Function to echo a colored category name and apply the style to the entire row
                    function echoColoredCategory($category, $space)
                    {
                        $sizeLabel = "";
                        switch ($category) {
                            case 'A':
                                $sizeLabel = "ขนาดของกระเป๋า  16-21 นิ้ว";
                                break;
                            case 'B':
                                $sizeLabel = "ขนาดของกระเป๋า  24-26 นิ้ว";
                                break;
                            case 'C':
                                $sizeLabel = "ขนาดของกระเป๋า  29-32 นิ้ว";
                                break;
                            default:
                                $sizeLabel = "Unknown Size";
                                break;
                        }

                        if ($space == 21) {
                            return "<p style='color:red; text-decoration: line-through; margin-bottom: -8px; font-size: 20px;'>
                                                $sizeLabel <span style=' \margin-left: 70px;'>
                                                $space/21
                                                </span></p>";
                        } else {
                            return "<p style='color: #f7f419; margin-bottom: -20px; font-size: 20px;' >$sizeLabel 
                                                <span style=' \margin-left: 80px;'>
                                                $space/21
                                                </span></p>";
                        }
                    }

                    // Output the available space for each category
                    echo "" . echoColoredCategory('A', $spaceA) . "<br>";
                    echo "" . echoColoredCategory('B', $spaceB) . "<br>";
                    echo "" . echoColoredCategory('C', $spaceC) . "<br>";
                    ?>

                </div>
            </div>
        </div>

        <!-- reserv online -->
        <div id="re_online" style="display: none;"></div>
        <!--end reserv online -->

        <!-- noti -->
        <div id="noti" style="display: none; background-color:#d9d9d9; ">
            <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
                <div class="d-flex align-items-center" style="margin:10px 0 10px 0;">
                    <a href=""><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                    <div class="flex-grow-1 text-center">
                        <h4 style="font-weight:900; ">แจ้งเตือนทั้งหมด</h4>
                    </div>
                </div>

            </div>
            <?php
            $db = new ConnectDb();
            $conn = $db->getConn();

            $sql = "SELECT * FROM bagreserv 
                            JOIN register ON register.m_id = bagreserv.m_id 
                            WHERE bagreserv.mk_name LIKE '$mk_name' 
                            AND (status = 'รอดำเนินการ' OR status = 'คืนสำเร็จ' OR status = 'ฝากสำเร็จ') 
                            ORDER BY curr_timestamp DESC LIMIT 6";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // แสดงข้อมูลที่ค้นพบ
                while ($row = $result->fetch_assoc()) {
                    $mk_name = $row['mk_name'];
                    $mem_img = $row['usr_img'];
                    $bag_id = $row['bag_id'];
                    $checkDate = findNotifDate($row["curr_timestamp"],  7 * 60 * 60);

                    echo '<button type="button" id="retr-online" name="retr-online" onclick="displayContent(\'re_online\', \'re_online-link\', \'' . $bag_id . '\')" data-bs-dismiss="modal" style="width: 100%; padding: 0px; border: 0px; margin-top: 5px; text-align:left;">';
                    echo '<div style="display: flex; ">';
                    echo '<div style="background-color: white; flex: 3; padding: 5px;">';
                    echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                    echo '<span style="font-size: 15px; font-weight: 600;">'  . $row["m_fname"] . ' ' . $row["m_lname"] . ' ' . '</span>';
                    echo '<span style="font-size: 15px;">เวลา' . ' ' . $row["reserv_time"] . ' ' . 'วันที่' . ' ' . $row["reserv_date"] . ' ' . '-' . ' ' . $row["retrive_time"] . ' ' . 'วันที่' . ' ' . $row["retrive_date"] . '<span style="font-weight: 600; margin-left: 13px;">' . $checkDate . '</span>' .  '</span><br>';
                    echo '</div>';

                    echo '<div style="background-color: ' . ($row["status"] == "คืนสำเร็จ" ? '#7d7777' : ($row["status"] == "ฝากสำเร็จ" ? '#76c70c' : ($row["status"] == "รอดำเนินการ" ? '#faf61e' : '#f7f420'))) . '; padding: 5px; flex: 1; display: flex; justify-content: center; align-items: center">';
                    echo '<span style="font-size: 18px; font-weight: 600;">' . $row["status"] . '</span><br>';
                    echo '</div>';

                    echo '</div>';
                    echo '</button>';
                }
            } else {
                echo '<h3 style="text-align:center; margin-top:10px;">ยังไม่มีการแจ้งเตือน</h3>';
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
            $conn->close();
            ?>
        </div>
        <!-- end noti -->

        <!-- search -->
        <div id="search" style="display: none;">
            <a href=""><img src="images/leftarrow.png" style="width:40px;height:40px; margin-bottom:10px;"></a>
            <form id="searchForm" onsubmit="event.preventDefault(); searchContent('searchForm', 'srh_order', 'srh_order_link')" action="crud/search_order.php" method="POST">
                <div class="d-flex">

                    <div style="flex:1; padding: 10px;">

                        <label style="font-weight: 600; font-size: 18px;" for="order_num">ค้นหาจากหมายเลขออเดอร์ *</label><br>
                        <input type="text" class="text1" id="order_num" name="order_num" placeholder="เลือกหมายเลขออเดอร์">
                        <button type="submit"  id="all-order" name="all-order" value="all-order" onclick="setButtonName('all-order')" class="card-search col-2 text-center p-3" style="margin-left: 100%; margin-top: -10%; display: flex;">
                            <b>ดูรายการฝากทั้งหมด</b>
                        </button>
                        <label style="font-weight: 600; font-size: 18px;" for="email">ค้นหาจาก E-mail</label><br>
                        <input type="email" class="email1" id="email" name="email" placeholder="กรอก E-mail"><br>
                        <label style="font-weight: 600; font-size: 18px;" for="fullName">ค้นหาจาก ชื่อ-นามสกุล</label><br>
                        <input type="text" class="text1" id="m_fname" name="m_fname" placeholder="กรอกชื่อ">
                        <input type="text" class="text1" id="m_lname" name="m_lname" placeholder="กรอกนามสกุล"><br>
                        <input type="hidden" name="button_clicked" id="button_clicked" value="">
                        <center>
                            <button name="search" type="submit" class="submit1" onclick="setButtonName('search')">ค้นหา</button>
                        </center>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function setButtonName(buttonName) {
                document.getElementById("button_clicked").value = buttonName;
                document.getElementById("return_clicked").value = buttonName;
            }

            function searchContent(formId, contentId, clickedLinkId) {
                var formData = new FormData(document.getElementById(formId));

                // Send form data via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', document.getElementById(formId).action, true);
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // ซ่อนทุกส่วนของข้อมูลยกเว้น div id srh_order
                        document.querySelectorAll('.row.col-9 > *').forEach(el => {
                            if (el.id !== 'srh_order') {
                                el.style.display = 'none';
                            }
                        });
                        // แสดง div id srh_order
                        document.getElementById(contentId).style.display = 'block';
                        document.getElementById(contentId).innerHTML = xhr.responseText;

                        // ลบคลาส 'active' ออกจากทุก nav-link
                        document.querySelectorAll('.nav-link').forEach(link => {
                            link.classList.remove('active');
                        });
                        // เพิ่มคลาส 'active' ใน nav-link ที่ถูกคลิก
                        document.getElementById(clickedLinkId).classList.add('active');
                        console.log('clickedLinkId:', clickedLinkId, formId);
                    } else {
                        console.error('Request failed with status:', xhr.status);
                    }
                };
                xhr.onerror = function() {
                    console.error('Request failed');
                };
                xhr.send(formData);
            }
        </script>
        <!--  -->
        <div id="srh_order" style="display:none; height: 800px; overflow-y: auto; overflow-x: hidden; ">
            <script>
                function toggleAside(asideId) {
                    var aside = document.getElementById(asideId);
                    var asideStyle = window.getComputedStyle(aside);
                    if (asideStyle.display === "none" || asideStyle.display === "") {
                        aside.style.display = "block";
                    } else {
                        aside.style.display = "none";
                    }
                }
            </script>
        </div>

        <!--  -->
        <!-- end search -->

        <!-- ลงทะเบียนฝากกระเป๋า -->
        <div id="deposit" style="display: none;">

            <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
                <div class="d-flex align-items-center" style="margin:10px 0 10px 0;">
                    <a href=""><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
                    <div class="flex-grow-1 text-center">
                        <h4 style="font-weight:900; ">ลงทะเบียนฝากกระเป๋า</h4>
                    </div>
                </div>
            </div>

            <form action="crud/partner_deposit.php" method="POST" enctype="multipart/form-data">
                <div class="depo-container">
                    <div>
                        <input type="text" class="depo-input" name="m_name" placeholder="ชื่อผู้ฝาก :">

                        <input type="email" class="depo-input" name="m_email" placeholder="E-mail :">

                        <input type="number" class="depo-input" name="m_passport" maxlength="20" placeholder="เลขบัตรประชาชน/หนังสือเดินทาง :"><br>

                        <select name="m_ctry" id="m_ctry" class="depo-drop" required>
                            <option value="">country/ประเทศ</option>
                            <?php
                            $db = new ConnectDb();
                            $conn = $db->getConn();

                            $sql = "SELECT * FROM tbl_country";
                            $result = mysqli_query($conn, $sql);

                            // วนลูปแสดงตัวเลือกคณะ
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['ct_code'] . "'>" . $row['ct_nameTHA'] . "</option>";
                            }
                            // ปิดการเชื่อมต่อฐานข้อมูล
                            mysqli_close($conn);
                            ?>
                        </select>

                        <input type="text" class="depo-input" name="m_lname" placeholder="เบอร์โทรศัพท์ :">

                        <?php
                        $db = new ConnectDb();
                        $conn = $db->getConn();
                        $mk_id = $_SESSION['bagdrop_member_id'];
                        // สร้าง SQL query เพื่อดึงข้อมูลร้านค้าและรูปภาพ
                        $sql = "SELECT * FROM market WHERE mk_id = $mk_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // หากมีข้อมูลในฐานข้อมูล
                            while ($row = $result->fetch_assoc()) {

                                $mk_name = $row['mk_name'];

                                echo '<div class="depo-input">สถานที่ฝาก : ' . $mk_name . '</div>';
                            }
                        }
                        $conn->close();
                        ?>

                        <input type="text" class="depo-drop" id="event_reserv" placeholder="วันที่ฝาก :" onfocus="(this.type='datetime-local')">
                        <input type="text" class="depo-drop" id="event_retrieve" placeholder="วันที่มารับ :" onfocus="(this.type='datetime-local')">

                        <select name="cate" id="cateSelect" class="depo-drop">
                            <option value="option">ประเภทของกระเป๋า :</option>
                            <?php
                            $db = new ConnectDb();
                            $conn = $db->getConn();

                            $sql2 = "SELECT * FROM cate";
                            $rs2 = mysqli_query($conn, $sql2);


                            while ($data2 = mysqli_fetch_array($rs2)) {
                            ?>
                                <option value="cate">
                                    <?= $data2['cate_name']; ?>
                                </option>
                            <?php } ?>
                        </select>

                        <input type="text" id="quantity" min="1" value="1" class="depo-drop" placeholder="จำนวนกระเป๋า :" onfocus="(this.type='number')">

                        <select name="p_place" class="depo-drop">
                            <option value="">ช่องทางการชำระ :</option>
                        </select>

                    </div>

                    <div style="display: grid; grid-template-columns: auto; ">
                        <div style="display: flex;  ">
                            <div class="card" style="background-color: #d9d9d9; margin-right: 5px ">
                                <img class="depo-img" src="images/กล่อง.png" style="width: 100px; padding: 10px; ">
                                <div class="card-body" style="background-color: white;">
                                    <div class="upload-btn-wrapper">
                                        <button class="file-btn">เลือกช่องเก็บกระเป๋า</button>
                                        <input type="file" name="file" accept="image/gif, image/jpeg, image/png">
                                    </div>
                                </div>
                            </div>
                            <div class="card" style="background-color: #d9d9d9; ">
                                <img class="depo-img" src="images/กล้อง.png" style="width: 100px; padding: 10px; ">
                                <div class="card-body" style="background-color: white;">
                                    <div class="upload-btn-wrapper">
                                        <button class="file-btn">เพิ่มรูปภาพกระเป๋า</button>
                                        <input type="file" name="file" accept="image/gif, image/jpeg, image/png">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card" style="background-color: #d9d9d9; justify-self:center ">
                            <img class="depo-img" src="images/บัตร.png" style="width: 100px; padding: 10px;">
                            <div class="card-body" style="background-color: white; height:fit-content;">
                                <div class="upload-btn-wrapper">
                                    <button class="file-btn">เพิ่มรูปภาพบัตรประชาชนหรือหนังสือเดินทาง</button>
                                    <input type="file" name="file" accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>
                        </div>

                        <div style="display: flex; justify-self: center; ">
                            <input type="submit" name="Submit" class="depo-btn" value="ยืนยัน"><br>
                            <input type="submit" class="depo-ccl" value="ยกเลิก">
                        </div>
                    </div>


                </div>

            </form>

        </div>

        <!-- End ลงทะเบียนฝากกระเป๋า -->

        <!-- คืนกระเป๋า -->
        <div id="return_bag" style="display: none;">
            <form id="retnForm" class="container-fluid" style="margin-top: 10px;" onsubmit="event.preventDefault(); searchContent('retnForm', 'srh_order', 'srh_order_link')" action="crud/search_order.php" method="POST">

                <div class="d-flex" style="text-align: center;">
                    <div>
                        <label style="font-weight: 600; font-size: 18px;" for="order_number">ค้นหาจากหมายเลขออเดอร์ *</label>
                        <input type="text" class="retn-btn" id="order_number" name="order_number">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 18px;" for="fullName">ค้นหาจาก ชื่อ-นามสกุล</label>
                        <input type="text" class="retn-btn" id="m_name" name="m_name">
                    </div>
                    <div>
                        <label style="font-weight: 600; font-size: 18px;" for="email">ค้นหาจาก E-mail</label>
                        <input type="email" class="retn-btn" id="email" name="email">
                    </div>
                    <input type="hidden" name="return_clicked" id="return_clicked" value="">
                </div>


                <div style="background-color: #d9d9d9; height:500px; padding: 0;  overflow-y: auto; overflow-x: hidden; ">
                    <?php
                    $db = new ConnectDb();
                    $conn = $db->getConn();

                    $sql = "SELECT * FROM bagreserv 
                            JOIN register ON register.m_id = bagreserv.m_id 
                            WHERE bagreserv.mk_name LIKE '$mk_name' 
                            AND (status = 'รอดำเนินการ' OR status = 'คืนสำเร็จ' OR status = 'ฝากสำเร็จ') 
                            ORDER BY curr_timestamp DESC LIMIT 6";

                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // แสดงข้อมูลที่ค้นพบ
                        while ($row = $result->fetch_assoc()) {
                            $mk_name = $row['mk_name'];
                            $mem_img = $row['usr_img'];
                            $bag_id = $row['bag_id'];

                            echo '<button type="button" id="retrBag-btn" name="returnBag-btn" onclick="displayReturn(\'returnBag_btn\', \'returnBag_btn\', \'' . $bag_id . '\')"  style="width: 100%; padding: 0; border: 0px; margin-bottom: 5px; text-align:left;">';
                            echo '<div style="background-color: #706565; display:flex;  padding: 5px;">';
                            echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                            echo '<div style="margin-right:20px;">';
                            echo '<label style="color:white;">OrderID</label><br>';
                            echo '<h5 style="color:white; font-weight: 600;">' . $row["order_number"] . ' ' . '</h5>';
                            echo '</div>';
                            echo '<div style="margin-right:20px; width:200px;">';
                            echo '<label style="color:white;">Name</label><br>';
                            echo '<h5 style="color:white;  font-weight: 600;">'  . $row["m_fname"] . ' ' . $row["m_lname"] . ' ' . '</h5>';
                            echo '</div>';
                            echo '<div style="margin-right:20px;  width:300px;">';
                            echo '<label style="color:white;">Email</label><br>';
                            echo '<h5 style="color:white; font-weight: 600;">' . $row["m_email"] . '</h5>';
                            echo '</div>';
                            echo '<div style="width:200px;">';
                            echo '<label style="color:white;">Remaining Time</label><br>';
                            echo '<h5 style="color:white; font-weight: 600;">' . '2 day 5 hour' . ' ' . '</h5>';
                            echo '</div>';
                            echo '</div>';
                            echo '</button>';
                        }
                    }

                    $conn->close();
                    ?>

                </div>
                <center> <button name="return" type="submit" class="submit1" onclick="setButtonName('return')">ค้นหา</button></center>
            </form>
        </div>
        <script>
            function displayReturn(contentId, clickedLinkId, bag_id) {
                // Show the selected content immediately
                $('.row.col-9 > *').hide();
                $('#' + contentId).show();
                // Update the active class for the clicked link
                $('.nav-link').removeClass('active');
                $('#' + clickedLinkId).addClass('active');

                $.ajax({
                    type: "POST",
                    url: "crud/returnBag_btn.php",
                    data: {
                        bag_id: bag_id
                    },
                    success: function(response) {
                        if ($('#returnBag_btn').length) {

                            $('#returnBag_btn').html(response);
                        } else {
                            console.error('returnBag_btn div not found');
                        }
                    },
                    error: function(xhr, status, error) {

                        console.error(xhr.responseText);
                    }
                });
            }
        </script>

        <!-- Returnbag for each button -->
        <div id="returnBag_btn" style="display: none;"></div>
        <!--end Returnbag for each button -->

       <!-- report -->
       <?php
// ตรวจสอบว่ามีการส่งคำร้องข้อมูลหรือไม่
if (isset($_GET['report'])) {
    // รับค่าเริ่มต้นและสิ้นสุดจากฟอร์ม
    $startDate = $_GET['start_date'];
    $endDate = $_GET['end_date'];

    $db = new ConnectDb();
    $conn = $db->getConn();
    
    // ตรวจสอบรูปแบบวันที่
    $startDate = date('Y-m-d', strtotime($startDate));
    $endDate = date('Y-m-d', strtotime($endDate));
    
    $sql = "SELECT COUNT(bag_id) AS total_orders, SUM(total_price) AS total_price
            FROM bagreserv
            WHERE mk_id = '$mk_id'
            AND status != 'รอดำเนินการ'
            AND curr_timestamp BETWEEN '$startDate' AND '$endDate'";

    // ดำเนินการ query กับฐานข้อมูล
    $result = mysqli_query($conn, $sql);

    // ตรวจสอบว่า query สำเร็จหรือไม่
    if ($result) {
        // ดึงข้อมูลจากผลลัพธ์ query
        $row = mysqli_fetch_assoc($result);
        $sumorder = $row['total_orders'];
        $sumprice = $row['total_price'];
    } else {
        // หาก query ไม่สำเร็จ
        // สามารถแสดงข้อความผิดพลาดได้ตามต้องการ
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!--  -->
<div id="report" style="display: none;">
    <a href=""><img src="images/leftarrow.png" style="width:40px;height:40px; margin-bottom:10px; margin-left : -5%; margin-top: 3%;"></a>

    <form action="" method="GET" id="reportForm">
        <div class="d-flex">
            <div style="flex:1; padding: 10px; margin-left: -25%;">
                <label style="font-weight: 600; font-size: 32px; margin-left: 55%;">ตรวจสอบข้อมูล</label><br><br>
                <label style="font-weight: 600; font-size: 24px; margin-left: 61%;">ช่วงเวลา</label><br>

                <!--  -->
                <div class="col-12" style=" margin-top: 3%;">
                    <div class="row">
                        <!--  -->
                       
                        <!--  -->
                        <div class="col-6" style="margin-left: 40%;">
                        <input type="date" id="start_date" name="start_date" style="margin-bottom: 1%; width: 150px; height:40px; margin-left: 2%;">
                            
                            <!--  -->

                            <div class="message-box1">
                                <p>จำนวนออเดอร์ทั้งหมด</p>
                                <?php if (isset($sumorder)) : ?>
                                    <p><b>จำนวน <?= $sumorder; ?> ออเดอร์</b></p>
                                <?php else : ?>
                                    <p><b>ไม่พบข้อมูล</b></p>
                                <?php endif; ?>
                            </div>
                            <!--  -->
                        </div>
                        <!--  -->

                        <div class="col-6" style="margin-left: 73%; margin-top: -19.8%;">
                            <!--  -->
                            <input type="date" id="end_date" name="end_date" style="width: 150px; height:40px;">
                            <div class="message-box2" style="margin-left: 0%;">
                                <p>รายได้ทั้งหมด</p>
                                <?php if (isset($sumprice)) : ?>
                                    <p><b>จำนวน <?= $sumprice; ?> บาท</b></p>
                                <?php else : ?>
                                    <p><b>ไม่พบข้อมูล</b></p>
                                <?php endif; ?>
                            </div>
                            <!--  -->
                        </div>
                        <!--  -->
                    </div>
                    <!--  -->
                    <script>
                        document.getElementById("reportForm").addEventListener("submit", function(event) {
                            // ยกเลิกการดำเนินการของฟอร์ม
                            event.preventDefault();
                            // ดำเนินการส่งข้อมูลฟอร์มไปยัง URL ที่ต้องการ
                            // ในที่นี้คือ URL ของหน้า partner_home
                            window.location.href = "?page=partner_home&" + this.serialize();
                        });

                        // เพิ่ม method serialize() ใน Object prototype ของ HTMLFormElement
                        HTMLFormElement.prototype.serialize = function() {
                            // สร้าง Array สำหรับเก็บค่าของ input elements
                            var fields = [];
                            // วนลูปผ่าน input elements ทั้งหมดในฟอร์ม
                            for (var i = 0; i < this.elements.length; i++) {
                                var field = this.elements[i];
                                // ตรวจสอบว่า input element เป็น input ที่มีชื่อและค่า (ไม่ใช่ button)
                                if (field.name && !field.disabled && field.type !== 'button') {
                                    // ใส่ข้อมูลในรูปแบบ key-value pair ใน Array
                                    fields.push(field.name + '=' + encodeURIComponent(field.value));
                                }
                            }
                            // รวมข้อมูลใน Array ให้เป็นข้อความแบบ query string
                            return fields.join('&');
                        };
                    </script>
                    <!--  -->
                    <button type="submit" class="submit2" name="report" style="margin-left: 58%; margin-top: 4%; margin-bottom: 6%;">ค้นหา</button>
                </div>

            </div>
        </div>
    </form>

    <!--  -->
</div>

        <!-- end report -->
        <style>
            /* เพิ่มความโค้งของขอบ */
            .report-select {
                border-radius: 15px;
                padding: 5px;
                /* เพิ่มระยะห่างของข้อความภายใน select */
                font-size: 20px;
                /* เพิ่มขนาดของลูกษร */
                width: 30%;
            }

            .message-box1 {
                text-align: center;
                /* จัดให้ข้อความอยู่ตรงกลาง */
                font-size: 20px;
                /* เพิ่มขนาดข้อความ */
                border: 2px solid black;
                /* ขอบสีดำ */
                padding: 15px;
                /* ระยะห่างของข้อความภายในกล่อง */
                border-radius: 15px;
                /* เพิ่มความโค้งของขอบ */
                width: 220px;
                /* กำหนดความกว้างของกล่อง */
                margin-left: -10%;
                margin-top: 10%;
            }

            .message-box2 {
                text-align: center;
                /* จัดให้ข้อความอยู่ตรงกลาง */
                font-size: 20px;
                /* เพิ่มขนาดข้อความ */
                border: 2px solid black;
                /* ขอบสีดำ */
                padding: 15px;
                /* ระยะห่างของข้อความภายในกล่อง */
                border-radius: 15px;
                /* เพิ่มความโค้งของขอบ */
                width: 220px;
                /* กำหนดความกว้างของกล่อง */
                margin-left: -10%;
                margin-top: 10%;
            }

            .submit2 {
                width: 15%;
                padding: 10px;
                background-color: #F91D1D;
                color: white;
                border: none;
                border-radius: 14px;
                cursor: pointer;
                display: block;
                margin: auto;
                margin-top: 2%;
                margin-left: 30%;
            }

            .submit2:hover {
                background-color: #419ba3;
            }
        </style>

        <div id="revieww" style="display: none;">

            <?php
            // เชื่อมต่อฐานข้อมูล
            $db = new ConnectDb();
            $conn = $db->getConn();
            $mk_id = $_SESSION['bagdrop_member_id'];
            // เตรียม SQL query โดยใช้ INNER JOIN เพื่อเชื่อมตาราง bagreserv กับ market โดยใช้ mk_id เป็นตัวเชื่อม
            $sql = "SELECT feedback.*, register.m_fname, register.m_lname, register.usr_img
        FROM feedback 
        INNER JOIN register ON feedback.m_id = register.m_id 
        INNER JOIN market ON feedback.mk_id = market.mk_id
        WHERE market.mk_id = $mk_id";



            $rs = mysqli_query($conn, $sql);
            $total_reviews = mysqli_num_rows($rs); // นับจำนวนแถวทั้งหมดที่ได้จากการ query
            $data = mysqli_fetch_array($rs);
            $usr_img = $data['usr_img'];
            ?>

            <h3 style="text-align: center;">รีวิวทั้งหมด (<?php echo $total_reviews; ?>)</h3>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="card2" style="height: 800px; overflow-y: auto; overflow-x: hidden; ">
                        <?php
                        // สำหรับแสดงรีวิวแต่ละรายการ
                        while ($data = mysqli_fetch_assoc($rs)) {
                            $pictures = json_decode($data['usr_img'], true);

                        ?>
                            <div style="display: flex; align-items: center;">
                                <img src="images/usr_img/<?php echo $usr_img; ?>" style="width: 40px; height: 40px; display: inline-block;" alt="">
                                <h5 style="font-weight: bold; display: inline-block; margin-right: 10px;"><?php echo $data['m_fname']; ?> <?php echo $data['m_lname']; ?></h5>
                                <p style="display: inline-block; margin-right: 10px;"><?php echo $data['time_stamp']; ?></p> <!-- เพิ่มส่วนแสดงวันที่ -->
                                <?php
                                // แสดงคะแนน rating ด้วยรูปภาพดาว
                                $rating = $data['rating'];
                                echo '<div class="rating" style="display: inline-block;">';
                                for ($i = 1; $i <= 5; $i++) {
                                    // ตรวจสอบว่า $i น้อยกว่าหรือเท่ากับคะแนน rating หรือไม่
                                    if ($i <= $rating) {
                                        // แสดงดาวที่ได้รับคะแนน
                                        echo '<img src="images/daw2.png" alt="Star" class="star" style="width: 25px; height: 25px;">';
                                    } else {
                                        // ไม่แสดงดาวสามเหลี่ยมหรือดาวเริ่มต้น
                                        echo '';
                                    }
                                }
                                echo '</div>';
                                ?>
                                <span style="color: yellow; font-weight: bold; font-Size: 35px; margin-left: 20px;"><?php echo $data['rating']; ?>.0</span>
                            </div>
                            <div class="card3">
                                <?php echo $data['suggestion']; ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- end col-9  -->

    <script>
        function showContent(contentId, clickedLinkId) {
            // ซ่อนทุกส่วนของข้อมูล
            document.querySelectorAll('.row.col-9 > *').forEach(el => {
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
        }
    </script>


    <!--  -->
</div>
<!-- end col-12 -->

<!-- css -->
<style>
    /* search */
    #search{
        margin-top: 2%;
    }
    /* #all-order{
        margin-right: -20%;
    } */
    /* nav left */

    /*  */
    .col-5 {
        width: 130px;
        /* ขนาดกล่อง */
        float: right;
        /* ชิดขวา */
        margin-top: -22px;
        /* ขยับขึ้นมา */
        margin-left: auto;
        /* ชิดขวาสุด */
        padding: 5px;
        /* ระยะห่างขอบ */
        box-sizing: border-box;
        /* รวมขอบและ padding ในการคำนวณขนาด */
    }

    .status1 {
        background-color: #F7F41F;
        /* สีพื้นหลัง */
        font-weight: bold;
        text-align: center;
        color: black;
        /* สีตัวอักษร */
        padding: 10px;
        /* ระยะห่างขอบ */
        display: block;
        /* แสดงเป็นกล่องของตัวเอง */
        border-radius: 10px;
        /* ทำเส้นขอบโค้ง */
    }

    /*  */
    /* search */
    .card-search {
        background-color: #121138;
        color: white;
        border-radius: 10px 0 0 10px;
        margin-left: 10vw;
    }



    form {
        width: 900px;
        margin: 0 auto;
        background-color: transparent;
        padding: 0;
        border: none;
        border-radius: 4px;
        margin-left: 45px;
    }

    .retn-form {
        width: 900px;
        margin: 0 auto;
        background-color: transparent;
        padding: 0;
        border: none;
        border-radius: 4px;
        margin-left: 45px;
    }

    .otp-form {
        width: 60%;
        line-height: normal;
        margin: 0 auto;
        padding: 0;
        border: none;

    }

    .otp-btn {
        display: inline-block;
        height: 50px;
        width: 100%;
        padding: 10px;
        background-color: #f7f420;
        color: black;
        border: 1px solid black;
        border-radius: 14px;
        cursor: pointer;
        font-weight: bold;
    }

    .otp-submit {
        display: inline-block;
        height: 50px;
        margin-top: 10px;
        width: 50%;
        padding: 10px;
        background-color: #f7f420;
        color: black;
        border: 1px solid black;
        border-radius: 14px;
        cursor: pointer;
        font-weight: bold;
    }

    .label {
        display: block;
        margin-bottom: 10px;
        margin-top: 10px;
        font-weight: 900;
    }

    .text1 {
        width: 60%;
        padding: 10px;
        margin-bottom: 45px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #d9d9d9;
    }

    .email1 {
        width: 60%;
        padding: 10px;
        margin-bottom: 45px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #d9d9d9;
    }

    .retn-btn {
        width: 80%;
        padding: 10px;
        margin-bottom: 45px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #d9d9d9;
    }


    .submit1 {
        width: 15%;
        padding: 10px;
        background-color: #F91D1D;
        color: white;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        display: block;
        margin-top: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .submit1:hover {
        background-color: #419ba3;
    }





    /* show search */
    .order_search {
        background-color: #f2f2f2;
        border: 10px solid #121139;
        border-radius: 4px;
        padding: 0.5rem;
        /* ขยับขึ้นมา */
        margin-bottom: 0.5rem;
    }

    .order_number {
        border: 5px solid #121139;
        border-radius: 4px;
        padding: 1rem;
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }



    .card_all {
        background-color: #121139;
        color: #F7F41F;
        border-radius: 10px 0 0 10px;
        height: 50px;
        width: 200px;
        text-align: center;
        background-size: 80px;
        background-position: left;
        background-repeat: no-repeat;
        background-image: url('https://s3-alpha-sig.figma.com/img/a2e3/59ad/c8e3e7ac163a3e1d4298219605114df0?Expires=1712534400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=ZnDFKtredIy3k9hI7Tx97nl3U7F~zaOQ6rmT3AkfP20fhr2hN5VtFb2FV1IujRRwcCZWxRg4Qbj4d3UrobIRs3YzmPtCa-DzWRQOFOYHZZBEgR4cr2T~AcgWpmgR80lPIBDnycA-sI2WimHMp9HI21wyPbN9NH9X9gLNWduwDD4s29SspD4hVMUi5Nya2px-C5Ms3tkPOSjtXnrf-nRvb8OxyywGbZHVdkjMIwbQ4rSH6O1GON3T-VQU6hD8QGvbTh34VzB6wUZaDnWwwXzKWtP-GPtxV0XDXCWrrHqTDE3yBbCaopjk1x8upoaE8yfLuT20XIdfwem1T9DKNyfQ1Q__');
    }

    .bag_count {
        background-color: #121139;
        color: #F7F41F;
        border-radius: 10px 10px 10px 10px;
        height: 50px;
        width: 200px;
        margin-left: 2vw;
        text-align: center;
        background-size: 80px;
        background-position: left;
        background-repeat: no-repeat;
    }

    .all-btn {
        width: 50%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 14px;
        box-sizing: border-box;
        box-shadow: 5px 5px 5px #c4c4c4;
        background-color: white;
    }

    .all-group {
        padding: 10px;

    }




    .order_number .order {
        font-size: 1.3rem;
        font-weight: bold;
        color: #121139;
        margin-bottom: 0.2rem;
    }

    .order-btn {
        background-color: #121139;
        color: #F7F41F;
        border-radius: 10px;
        margin: 1rem 0rem;
    }


    .order-group {
        margin-bottom: 1rem;
        margin-left: 2rem;
    }

    .order_number .name {
        font-size: 1.1rem;
        font-weight: 700px;
    }

    /* ฝากกระเป๋า  */
    .depo-input {
        width: 90%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 14px;
        box-sizing: border-box;
        border: none;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        background-color: white;
        background-position: right;
        background-repeat: no-repeat;
        background-size: 30px;
        background-image: url('https://s3-alpha-sig.figma.com/img/e042/6701/17968406c97cce2b585cfd88b62a531b?Expires=1714348800&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=ZT4eccn7mzEyXcYzwIUBfOPdW5ycTpYbFOeXb0-D6luezoxHHHF6gznsfx0S6JkSckSTKs68sU~2la6EhdNQFNPvG4iNER4Hq1rl-3U1gN9iCk2QN3ebq9I7pdHdFzDrdRnbkSGABhgde4-TmmX~Be4hxFkc7obOz5gnLIjmzgn9lsBwZ16wAY09U-NOUg3KXJm1QYHxWUAQCe2BZmt9ZUVPQTS4zobxf41Q4WP71rJu4zOVOyLnSL5hurPXEgJ6kXpgrKGbqAU6sT5LBy-tWUzSMP5Em2AoSn~6mFvYFxmxpUg4FBNOs-Wfey20wjYRwxUr620Ci2AzJu0hd-F~Cg__');
    }

    .depo-input:focus {
        outline: none;
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

    .depo-drop:focus {
        outline: none;
    }

    .depo-container {
        display: grid;
        row-gap: 0px;
        grid-template-columns: 500px 500px;
        width: 80vw;
    }



    @media (max-width: 1024px) {
        .depo-container {
            grid-template-columns: 1fr;
        }
    }

    .upload-btn-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }

    .file-btn {
        border: 1px solid black;
        color: black;
        background-color: white;
        padding: 5px 5px;
        border-radius: 15px;
        font-size: 15px;
    }

    .upload-btn-wrapper input[type=file] {
        font-size: 100px;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }


    .depo-btn {
        display: inline-block;
        height: 50px;
        width: 150px;
        background-color: #f7f420;
        color: black;
        border: 1px solid black;
        border-radius: 14px;
        cursor: pointer;
        font-weight: bold;

    }



    .depo-btn:hover {
        background-color: #419ba3;
    }

    .depo-ccl {
        display: inline-block;
        height: 50px;
        width: 150px;
        background-color: #ebebdd;
        color: black;
        border: 1px solid black;
        border-radius: 14px;
        cursor: pointer;
        font-weight: bold;
        margin-left: 10vw;

    }

    .depo-ccl:hover {
        background-color: #419ba3;
    }



    .card {
        width: 250px;
        border-radius: 10px;
        text-align: center;
        height: fit-content;
        margin-left: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border: none;
    }


    .card-body {
        border-radius: 0 0 10px 10px;
    }


    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);

    }



    .depo-img {
        padding: 0.2rem 1rem 0 1rem;
        margin: auto;
        border-radius: 5px 5px 0 0;
    }

    .noti-img {
        border-radius: 50%;
        height: 60px;
        width: 60px;
        margin-right: 10px;
    }

    .round {
        background-image: url('images/notify.png');
        background-repeat: no-repeat;
        background-position: center;
        background-color: #faf61e;
        padding: 5px;
        height: 50px;
        width: 50px;
        box-shadow: 0 2px 4px darkslategray;
        border-radius: 50%;
        position: relative;
    }


    .round .badge {
        position: absolute;
        font-size: 15px;
        top: -15px;
        right: -15px;
        padding: 5px 10px;
        border-radius: 50%;
        background: red;
        color: white;
    }

    .custom-modal-background {
        background-color: #121138;
    }



    .clicked {
        background-color: #1e43fa;
    }

    .card {
        width: 250px;
        border-radius: 10px;
        text-align: center;
        height: fit-content;
        margin-left: 10px;
    }

    .card2 {
        width: 100%;
        border-radius: 10px;
        text-align: center;
        height: fit-content;
        margin-left: 10px;
        background-color: #D3D3D3;
    }

    .card3 {
        width: 90%;
        border-radius: 8px;
        text-align: left;
        height: 250px;
        margin-left: 10px;
        background-color: white;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid black;
        margin-left: 50px;
        margin-right: 50px;
    }
</style>
<!-- end css -->