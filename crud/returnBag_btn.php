<?php
require_once('../libs/connect.class.php');
session_start();


$db = new ConnectDb();
$conn = $db->getConn();
if (isset($_POST['bag_id'])) {

    $bag_id = $_POST['bag_id'];
    $mk_name = $_SESSION['mkname'];

    $sql = "SELECT * FROM bagreserv 
    JOIN register ON register.m_id = bagreserv.m_id 
    WHERE bagreserv.bag_id = '$bag_id' 
    AND bagreserv.mk_name LIKE '$mk_name' ";
    $result = $conn->query($sql);

    // Check if there are rows returned by the query
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        $m_email = $row['m_email'];
        $b_id = $row['bag_id'];
        $mem_img = $row['usr_img'];
        $mk_name = $row['mk_name'];

        echo '<a onclick="showContent(\'return_bag\', \'return_bag-link\')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>';
        echo '<div class="container">';

        echo '<form id="send-otp"   action="crud/otpverify.php" method="post"  target="iframe_target">';


        echo '<div class="order_number">';
        echo '<div class="col-12">';

        echo '<div class="order-group">';
        echo '<img class="noti-img" src="images/usr_img/' . $mem_img . '">';
        echo '<span class="order">หมายเลข :' . $row["order_number"] . '</span>';
        echo '</div>'; //order-group

        echo '<div class="depo-drop">ชื่อผู้ฝาก : ' . '<span style="color:#808000">'  . $row["m_fname"] . ' ' . $row["m_lname"] . '</span>' . '</div>';
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
            echo '<div id="slideshow-' . $slideshowId . '" class="carousel slide" data-ride="carousel">'; // Add unique ID to slideshow
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
}
