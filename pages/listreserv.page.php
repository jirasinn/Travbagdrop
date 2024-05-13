<?php
if (!isset($_SESSION['bagdrop_member_id'])) {
    echo '<script>alert("กรุณาเข้าสู่ระบบก่อน");</script>';
    echo '<script>window.location.href = "?page=login";</script>';
    exit(); // Stop further execution of the current script
}
?>


<style>
    h2 {
        font-weight: bold;
        color: black;
        text-align: center;
    }

    /* เพิ่ม CSS เพื่อใช้ flexbox */
    .card {
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 0px;
        /* เพิ่มค่า margin-bottom เพื่อลดระยะห่างระหว่างการ์ด */
        border: 1px solid black;
    }

    /* เพิ่ม CSS เพื่อกำหนดรูปแบบของกล่องสีเหลี่ยมสีเหลือง */
    .yellow-box {
        /* position: absolute;*/
        top: 20px;
        left: 50px;
        width: 120px;
        height: auto;
        background-color: yellow;
        border: 1px solid black;
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: left;
        border-radius: 5px;
        padding: 10px;

    }

    .yellow-box p {
        margin: 0;
        /* ลบ margin */
    }



    .divider {
        width: 100%;
        height: 2px;
        margin-top: 20px;
        /* เพิ่มระยะห่างด้านบนของเส้นแบ่ง */
        margin-bottom: 20px;
        /* เพิ่มระยะห่างด้านล่างของเส้นแบ่ง */
        border: 2px solid black;
        /* เพิ่ม border สีดำ */

    }

    .white-box3 {
        width: 250px;
        height: auto;
        background-color: white;
        border: 2px solid black;
        border-radius: 8px;
        padding: 10px;
        margin-top: 15px;
    }

    .card2 {
        border-radius: 8px;
        background-color: yellow;
        /* ใช้ชื่อสี yellow โดยตรง */
        border: 1px solid black;
        height: 160px;
        /* เพิ่มหน่วย px */
        /* margin-left: px; */

    }
</style>

<h2>รายการฝากของคุณ</h2>
<hr class="divider">

<?php
// เชื่อมต่อฐานข้อมูล
$db = new ConnectDb();
$conn = $db->getConn();

$m_id = $_SESSION['bagdrop_member_id'];
// เตรียม SQL query โดยใช้ INNER JOIN เพื่อเชื่อมตาราง bagreserv กับ market โดยใช้ mk_id เป็นตัวเชื่อม
$sql = "SELECT bagreserv.*, market.mk_name, 
    TIMESTAMPDIFF(SECOND, NOW(), CONCAT(bagreserv.retrive_date, ' ', bagreserv.retrive_time)) AS time_left_seconds 
               FROM bagreserv 
               JOIN market ON bagreserv.mk_id = market.mk_id
             where bagreserv.m_id = $m_id";
$rs = mysqli_query($conn, $sql);

// วนลูปเพื่อแสดงข้อมูลที่ได้จากฐานข้อมูล
while ($data = mysqli_fetch_assoc($rs)) {
    $reserv = $data['reserv_time'];
    $reserv2 = $data['reserv_date'];
    $test = $data['retrive_time'];
    $test2 = $data['retrive_date'];
    $time_left_seconds = $data['time_left_seconds'];
    // คำนวณจำนวนวัน ชั่วโมง นาที และวินาที
    $time_left_seconds = max($time_left_seconds, 0); // ให้แน่ใจว่าเวลาไม่ติดลบ
    $days = floor($time_left_seconds / (60 * 60 * 24));
    $hours = floor(($time_left_seconds % (60 * 60 * 24)) / (60 * 60));
    $minutes = floor(($time_left_seconds % (60 * 60)) / 60);
    $seconds = $time_left_seconds % 60;
    // กำหนดค่าตัวแปรที่เก็บข้อมูลของเวลาที่เหลือ
    $time_left_string = '';
    // เพิ่มข้อมูลของวันที่เหลือ (หากมี)
    if ($days > 0) {
        $time_left_string .= $days . ' วัน ';
    }
    // เพิ่มข้อมูลของชั่วโมง นาที และวินาที
    $time_left_string .= sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    $bagid = $data['bag_id'];
?>

    <div class="container">
        <!-- -->
        <div class="row">
            <!-- แสดงรูปภาพโดยใช้ข้อมูลจากฐานข้อมูล -->

            <!--  -->
            <div class="row col-md-12">

                <div class="container">
                    <!-- -->
                    <div class="row">
                        <!-- pic -->
                        <div class="col-md-3">
                            <div class="white-box3">
                                <a href="?page=detailre&id=<?php echo $data['bag_id']; ?>">
                                    <?php
                                    $db = new ConnectDb();
                                    $conn = $db->getConn();
                                    $sql2 = "SELECT * FROM bagreserv 
        JOIN register ON register.m_id = bagreserv.m_id 
        WHERE bagreserv.m_id LIKE '$m_id' AND bagreserv.bag_id = '$bagid'";
                                    $result = $conn->query($sql2);
                                    if ($result->num_rows > 0) {

                                        // แสดงข้อมูลที่ค้นพบ
                                        $row = $result->fetch_assoc(); {

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
                                                echo '<span class="visually-hidden">Previous</span>';
                                                echo '</a>';
                                                echo '<a class="carousel-control-next" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="next" id="nextBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
                                                echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                                                echo '<span class="visually-hidden">Next</span>';
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
                                                        echo '<img  src="' . htmlspecialchars($imageUrl) . '" height="230" width="230"/>'; // Sanitize imageUrl
                                                        // Display only the first image
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <!--  -->
                            <div class="row">

                                <div class="yellow-box">
                                    <strong><?= $data['status']; ?></strong>
                                </div>
                                หมายเลขออเดอร์ : <?= $data['order_number']; ?>

                            </div>

                            <br>
                            <div class="row col-md-12">
                                <div class="card col-md-9">
                                    <p><strong>สถานที่รับฝาก : <?php echo $data['mk_name']; ?></strong></p>
                                    <p><strong>เวลาที่ฝาก :</strong> <?= $reserv; ?> <?= $reserv2; ?></p>
                                    <p><strong>เวลาในการรับคืน :</strong> <?= $test; ?> <?= $test2; ?></p>
                                </div>

                                <div class="card2 col-md-3">
                                    <div class="yellow-box2">
                                        <p><strong>เวลาที่เหลือ :<br></strong> <?= $time_left_string; ?><br></p>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                        </div>
                    </div>
                    <!-- end pic -->

                </div>
            </div>

            <!--  -->
        </div>
    </div>
    </div>
    <hr class="divider">
<?php } ?>

<br><br>
<br><br>