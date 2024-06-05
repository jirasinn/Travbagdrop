<?php
require_once('../libs/connect.class.php');
session_start();
// เชื่อมต่อกับฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();
$mk_name = $_SESSION['mkname'];

if (isset($_POST['button_clicked'])) {
    $button_clicked = $_POST['button_clicked'];
    // รับค่าจากฟอร์ม
    if ($button_clicked === 'search') {

        $order_num = $_POST['order_num'];
        $email = $_POST['email'];
        $m_fname = $_POST['m_fname'];
        $m_lname = $_POST['m_lname'];

        // สร้างคำสั่ง SQL เพื่อค้นหาข้อมูล
        $sql = "SELECT * FROM bagreserv 
        JOIN register ON register.m_id = bagreserv.m_id
        WHERE bagreserv.order_number = '$order_num' 
        OR (register.m_email = '$email' AND register.m_email IS NOT NULL AND register.m_email != '')
        OR (register.m_fname = '$m_fname' AND register.m_fname IS NOT NULL AND register.m_fname != '')
        OR (register.m_lname = '$m_lname' AND register.m_lname IS NOT NULL AND register.m_lname != '')";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo '<a href="#"></a><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>';
            echo '<center><h3><b>รายการฝาก</b></h3></center>';
            while ($row = $result->fetch_assoc()) {
                $mem_img = $row['usr_img'];
                $bag_id = $row['bag_id'];
                // แสดงผลลัพธ์ที่ค้นพบในรูปแบบ HTML

                echo '<div class="d-flex">';
                echo '<div class="col-6">';

                echo '<div class="order_search">';
                echo '<button type="button" onclick="toggleAside(\'aside_' . $row["order_number"] . '\')" style="width: 100%; padding: 0; border: 0px; margin-bottom: 5px; text-align:left;">';
                echo '<div class="d-flex">';
                echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                echo '<div>';
                echo '<label style="font-size:20px; font-weight:500;">Order ' . $row["order_number"] . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">'  . $row["m_fname"] . ' ' . $row["m_lname"] . '</label>';
                echo '</div>';
                echo '</div>';
                echo '</button>';
                echo '</div>';
                echo '</div>';

                echo '<div class="container">';
                echo '<aside id="aside_' . $row["order_number"] . '" style="display: none;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding:10px;">';
                echo '<div class="d-flex justify-content-center">';
                echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                echo '<div style="margin-left: 10px;">';
                echo '<label style="font-size:20px; font-weight:500;">Order ' . $row["order_number"] . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">' . $row["m_fname"] . ' ' . $row["m_lname"] . '</label>';
                echo '</div>';
                echo '</div>';
                echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                echo '<div>';
                echo '<label style="font-size:20px; font-weight:500;">วันที่ฝาก : ' .  '<span style="color:#808000">' . $row["reserv_date"] . ' ' .  $row["reserv_time"] . '</span>' . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">วันที่มารับ : ' .  '<span style="color:#808000">' . $row["retrive_date"] . ' ' .  $row["retrive_time"] . '</span>' . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">จำนวนกระเป๋า : ' .  '<span style="color:#808000">' . $row["quantity"] . '</span>' . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">สถานะกระเป๋า : ' .  '<span style="color:#808000">' . $row["status"] . '</span>' . '</label>';
                echo '</div>';
                echo '</div>';
                echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                echo '<button  type="button" id="viewOrder" name="viewOrder" onclick="displayContent(\'re_online\', \'re_online-link\', \'' . $bag_id . '\')"  style="display: inline-block; height: 50px; width: 150px; background-color: #faf61e; color: black; border: 1px solid black; border-radius: 14px; cursor: pointer; font-weight: bold;">แสดงรายละเอียด</button><br>';
                echo '<input type="submit" value="แก้ไขข้อมูล" style="display: inline-block; height: 50px; width: 150px; background-color: #ebebdd; color: black; border: 1px solid black; border-radius: 14px; cursor: pointer; font-weight: bold; margin-left: 50px;">';
                echo '</div>';
                echo '</aside>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="d-flex justify-content-center " style="height: 500px;">';
            echo '<div style="width:80%;  margin:auto; height:300px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color:#d45759;">';
            echo '<div style="text-align:center; height: 100px; padding:10px;">';
            echo '<h3 style="color:white;"><b>การแจ้งเตือน</b></h3>';
            echo '<hr style="color:#f56469">';

            echo '</div>';
            echo '<div style="height: 100px; padding:10px;">';
            echo '<h4 style="color:white;">ไม่พบข้อมูลที่ตรงกับคำค้นหา</h4>';
            echo '</div>';

            echo '<div class="d-flex justify-content-end" style="height: 100px; background-color:white; padding:10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">';
            echo '<button type="button" style="margin-top:20px; color:white; background-color:#d45759; width:20%; height:50%; border:none; border-radius: 10px;" onclick="showContent(\'search\', \'search-link\');">ปิด</button>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
    }

    if ($button_clicked === 'all-order') {

        // สร้างคำสั่ง SQL เพื่อค้นหาข้อมูล
        $sql = "SELECT * FROM bagreserv join register on register.m_id = bagreserv.m_id 
        WHERE bagreserv.mk_name like '$mk_name'  ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            echo '<a href="#"></a><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>';
            echo '<h3 style="margin-left:120px;"><b>รายการฝากทั้งหมด</b></h3>';

            while ($row = $result->fetch_assoc()) {
                $mem_img = $row['usr_img'];
                $bag_id = $row['bag_id'];
                // แสดงผลลัพธ์ที่ค้นพบในรูปแบบ HTML

                echo '<div class="d-flex">';
                echo '<div class="col-6">';

                echo '<div style="background-color: #f2f2f2; border: 10px solid #121139;  padding: 0.5rem;">';

                echo '<button type="button" onclick="toggleAside(\'aside_' . $row["order_number"] . '\')" style="width: 100%; padding: 0; border: 0px;  text-align:left;">';
                echo '<div class="d-flex">';
                echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                echo '<div>';
                echo '<label style="font-size:20px; font-weight:500;">Order ' . $row["order_number"] . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">' .  $row["m_fname"] . ' ' . $row["m_lname"] . '</label>';
                echo '</div>';
                echo '</div>';
                echo '</button>';
                echo '</div>';
                echo '</div>';

                echo '<div class="container">';
                echo '<aside id="aside_' . $row["order_number"] . '" style="display: none;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding:10px;">';
                echo '<div class="d-flex justify-content-center">';
                echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                echo '<div style="margin-left: 10px;">';
                echo '<label style="font-size:20px; font-weight:500;">Order ' . $row["order_number"] . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">' . $row["m_fname"] . ' ' . $row["m_lname"] . '</label>';
                echo '</div>';
                echo '</div>';
                echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                echo '<div>';
                echo '<label style="font-size:20px; font-weight:500;">วันที่ฝาก : ' .  '<span style="color:#808000">' . $row["reserv_date"] . ' ' .  $row["reserv_time"] . '</span>' . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">วันที่มารับ : ' .  '<span style="color:#808000">' . $row["retrive_date"] . ' ' .  $row["retrive_time"] . '</span>' . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">จำนวนกระเป๋า : ' .  '<span style="color:#808000">' . $row["quantity"] . '</span>' . '</label><br>';
                echo '<label style="font-size:20px; font-weight:500;">สถานะกระเป๋า : ' .  '<span style="color:#808000">' . $row["status"] . '</span>' . '</label>';
                echo '</div>';
                echo '</div>';
                echo '<div class="d-flex justify-content-center" style="padding: 10px;">';
                echo '<button  type="button" id="viewOrder" name="viewOrder" onclick="displayContent(\'re_online\', \'re_online-link\', \'' . $bag_id . '\')"  style="display: inline-block; height: 50px; width: 150px; background-color: #faf61e; color: black; border: 1px solid black; border-radius: 14px; cursor: pointer; font-weight: bold;">แสดงรายละเอียด</button><br>';
                echo '<input type="submit" value="แก้ไขข้อมูล" style="display: inline-block; height: 50px; width: 150px; background-color: #ebebdd; color: black; border: 1px solid black; border-radius: 14px; cursor: pointer; font-weight: bold; margin-left: 50px;">';
                echo '</div>';
                echo '</aside>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
}

if (isset($_POST['return_clicked'])) {
    $return_clicked = $_POST['return_clicked'];
    if ($return_clicked === 'return') {
        // รับค่าจากฟอร์ม
        $order_number = $_POST["order_number"];
        $email = $_POST["email"];
        $m_name = $_POST["m_name"];

        // สร้างคำสั่ง SQL เพื่อค้นหาข้อมูล
        $sql = "SELECT * FROM bagreserv
    join register on register.m_id = bagreserv.m_id
    WHERE bagreserv.order_number like '$order_number' AND bagreserv.mk_name like '$mk_name'
         OR (register.m_email like '$email' AND register.m_email IS NOT NULL AND register.m_email != '') AND bagreserv.mk_name like '$mk_name'
         OR (register.name like '$m_name' AND register.name IS NOT NULL AND register.name != '') AND bagreserv.mk_name like '$mk_name'  
         OR (register.m_fname like '$m_name' AND register.m_fname IS NOT NULL AND register.m_fname != '') AND bagreserv.mk_name like '$mk_name' 
         OR  (register.m_lname like '$m_name' AND register.m_lname IS NOT NULL AND register.m_lname != '') AND bagreserv.mk_name like '$mk_name' 
         OR  CONCAT(register.m_fname, ' ', register.m_lname) like '$m_name' AND bagreserv.mk_name like '$mk_name' ";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // แสดงข้อมูลที่ค้นพบ
            echo '<a onclick="showContent(\'return_bag\', \'return_bag-link\')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>';
            while ($row = $result->fetch_assoc()) {
                // แสดงผลลัพธ์ที่ค้นพบในรูปแบบ HTML
                $m_email = $row['m_email'];
                $b_id = $row['bag_id'];
                $mem_img = $row['usr_img'];
                $mk_name = $row['mk_name'];

                echo '<div class="container">';
                echo '<form id="send-otp"   action="crud/otpverify.php" method="post"  target="iframe_target">';
                echo '<h4 class="order-btn col-2 text-center p-3"><b>ออเดอร์</b></h4>';

                echo '<div class="order_number">';
                echo '<div class="col-12">';

                echo '<div class="order-group">';
                echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
                echo '<span class="order">หมายเลข :' . $row["order_number"] . '</span>';
                echo '</div>'; //order-group

                echo '<div class="depo-drop">ชื่อผู้ฝาก : ' . '<span style="color:#808000">'   . $row["m_fname"] . ' ' . $row["m_lname"] . '</span>' . '</div>';
                echo '<div class="depo-drop">Email : ' . '<span style="color:#808000">' . $row["m_email"] . '</span>' . '</div>';
                echo '<div class="depo-drop">ประเทศ : ' . '<span style="color:#808000">' .  $row["m_ctry"] . '</span>' . '</div>';
                echo '<div class="depo-drop">เบอร์โทรศัพท์ : ' . '<span style="color:#808000">' .  $row["m_phone"] . '</span>' . '</div>';
                echo '<div class="depo-drop">สถานะกระเป๋า : ' .  '<span style="color:#808000">' . $row["status"] . '</span>' . '</div>';
                echo '<div class="depo-drop">สถานที่รับฝาก : ' .  '<span style="color:#808000">' . $row["mk_name"] . '</span>' . '</div>';
                echo '<div class="depo-drop">ประเภทกระเป๋า : ' . '<span style="color:#808000">' .  $row["category_name"] . '</span>' . '</div>';
                echo '<div class="depo-drop">จำนวนกระเป๋า : ' . '<span style="color:#808000">' .  $row["quantity"] . '</span>' . '</div>';
                echo '</div>'; //col-12

                echo '<div class="col mx-auto my-auto">';
                echo '<h6 class="bag_count d-flex align-items-center justify-content-center"><b>' . 'เหลือเวลาอีก' . '<br>' . '<span style="color:#f20000; font-size: 18px;">' . '0น.' . '</span>' . '</b></h6>';
                echo '<div class="card" style="background-color: #d9d9d9;">';
                $baseUrl = 'http://localhost/Travbagdrop/images/';
                $filenameFromDB = isset($row['picture']) ? $row['picture'] : ''; // Check if $row['picture'] is set
                $filenames = json_decode($filenameFromDB, true); // Ensure associative array
                if ($filenames && is_array($filenames) && count($filenames) >= 2) { // Check if $filenames is an array and has 2 or more elements
                    $slideshowId = uniqid(); // Generate a unique ID for the slideshow
                    echo '<div id="slideshow-' . $slideshowId . '" class="carousel slide" data-bs-ride="carousel">'; // Add unique ID to slideshow
                    echo '<div class="carousel-inner">';
                    $first = true;
                    foreach ($filenames as $index => $filename) {
                        // Replace plus signs with spaces
                        $filename = str_replace('+', ' ', $filename);
                        // Decode URL encoding
                        $filename = urldecode($filename);
                        // Encode filename for URL
                        $encodedFilename = rawurlencode($filename);
                        // Construct the full image URL
                        $imageUrl = $baseUrl . $encodedFilename;

                        if ($first) {
                            echo '<div class="carousel-item active"  id="slide-' . $index . '">'; // Change id to slide-
                            $first = false;
                        } else {
                            echo '<div class="carousel-item"  id="slide-' . $index . '">'; // Change id to slide-
                        }
                        echo '<img class="d-block w-100" src="' . htmlspecialchars($imageUrl) . '" alt="Slide">'; // Sanitize imageUrl
                        echo '</div>';
                    }
                    echo '</div>';
                    echo '<a class="carousel-control-prev" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="prev" id="prevBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
                    echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Previous</span>';
                    echo '</a>';
                    echo '<a class="carousel-control-next" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="next" id="nextBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
                    echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Next</span>';
                    echo '</a>';
                    echo '</div>';
                } else {
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
                            echo '<img class="depo-img" src="' . htmlspecialchars($imageUrl) . '" height="250" width="250"/>'; // Sanitize imageUrl
                            // Display only the first image
                            break;
                        }
                    }
                }
                echo '<div class="card-body" style="background-color: white;"> </div>';
                echo '</div>'; //card

                echo '<input type="hidden" name="m_email" value="' . $m_email . '">';
                echo '<input type="hidden" name="b_id" value="' . $b_id . '">';
                echo '<button type="submit" id="submitBtn"  name="return_bag" class="depo-btn" style="margin-top:20px;" data-bs-toggle="modal" data-bs-target="#otp-modal">คืนกระเป๋า</button>';
                echo '<iframe id="iframe_target" name="iframe_target" src="#" style="display: none; visibility: hidden;"></iframe>';
                echo '</form>';

                echo '</div>'; //col7
                echo '</div>'; //order
                echo '</div>'; //container

                //OTP Modal 
                echo '<div class="modal fade" id="otp-modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">';
                echo  '<div class="modal-dialog">';
                echo  '<div class="modal-content">';
                echo   '<div class="modal-header">';
                echo     '<h5 class="modal-title text-center" id="staticBackdropLabel">เราได้ส่งรหัสยืนยันไปที่ Email : ' . $row["m_email"] . ' ' . 'แล้ว กรุณากรอก OTP ที่ได้รับ</h5>';
                echo      '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                echo    '</div>';
                echo     '<div class="modal-body">';
                echo '<form class="otp-form" id="check-otp" action="crud/checkotp.php" method="post" target="otp_target" >';
                echo '<input type="text" id="otp" name="otp_code" class="otp-btn" placeholder="กรอกรหัส OTP ที่ได้รับ" required autofocus>';
                echo '<center><input type="submit" id="otpVerify" name="verify" class="otp-submit" value="ยืนยัน"></center>';
                echo '</form>';
                echo '<iframe id="otp_target" name="otp_target" src="#" style="display: none; visibility: hidden;"></iframe>';
                echo   '</div>';
                echo  '</div>'; //modal content
                echo  '</div>'; //modal dialog
                echo '</div>'; //modal fade

            }
        } else {

            echo '<div class="d-flex justify-content-center " style="height: 500px;">';
            echo '<div style="width:80%;  margin:auto; height:300px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); background-color:#d45759;">';
            echo '<div style="text-align:center; height: 100px; padding:10px;">';
            echo '<h3 style="color:white;"><b>การแจ้งเตือน</b></h3>';
            echo '<hr style="height:2px; background-color:#f56469; color:#f56469;">';

            echo '</div>';
            echo '<div style="height: 100px; padding:10px;">';
            echo '<h4 style="color:white;">ไม่พบข้อมูลที่ตรงกับคำค้นหา</h4>';
            echo '</div>';

            echo '<div class="d-flex justify-content-end" style="height: 100px; background-color:white; padding:10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">';
            echo '<button type="button" style="margin-top:20px; color:white; background-color:#d45759; width:20%; height:50%; border:none; border-radius: 10px;" onclick="showContent(\'return_bag\', \'return_bag-link\');">ปิด</button>';
            echo '</div>';

            echo '</div>';
            echo '</div>';
        }
    }
}
