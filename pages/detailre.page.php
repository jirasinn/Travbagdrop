<style>
    h2 {
        font-weight: bold;
        color: black;
        text-align: center;
    }

    .blue-box {
        width: 100%;
        /* เปลี่ยน width เป็น 100% เพื่อให้เต็ม container */
        height: 300px;
        background-color: #121139;
        border: 1px solid black;
        border-radius: 0px;
        padding: 10px;
    }



    .card {
        border-radius: 5px;
        background-color: #121139;
        border: 3px solid black;

    }

    .card2 {
        border-radius: 5px;
        background-color: white;
        border: 3px solid black;
        height: auto;
    }

    .black-box {
        width: 110px;
        height: 50px;
        background-color: black;
        border: 1px solid white;
        border-radius: 5px;
        padding: 10px;
        justify-content: center;
        /* จัดให้ข้อความอยู่ตรงกลางแนวนอน */
        align-items: center;
        /* จัดให้ข้อความอยู่ตรงกลางแนวตั้ง */
        text-align: center;
        color: yellow;
        /* เปลี่ยนสีตัวอักษรเป็นขาว */
        font-weight: bold;
        /* ทำให้ตัวอักษรหนา */
    }

    .yellow-box {
        width: 250px;
        height: auto;
        background-color: yellow;
        border: 1px solid black;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 20px;
        text-align: center;
    }

    .card-body>.yellow-box {
        margin-bottom: 25px;
        /* เพิ่มระยะห่างด้านล่างของแต่ละ yellow-box ที่อยู่ภายใน .card-body */

    }

    .white-box2 {
        width: 350px;
        height: 350px;
        background-color: white;
        border: 0px solid white;
        border-radius: 5px;
        padding: 10px;
    }

    .white-box3 {
        width: 250px;
        height: 200px;
        background-color: white;
        border: 2px solid black;
        border-radius: 8px;
        padding: 10px;
    }

    .blue-box {
        width: 250px;
        height: 40px;
        background-color: #121139;
        border: 1px solid black;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 20px;
        text-align: center;
        color: white;
        /* เปลี่ยนสีตัวอักษรเป็นขาว */
        font-weight: bold;
        /* ทำให้ตัวอักษรหนา */
    }

    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 999;
        text-align: center;
    }

    .popup img {
        margin-top: 10%;
        max-width: 80%;
        max-height: 80%;
        border: 4px solid #fff;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
    }

    .card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* จัดตำแหน่งตรงกลางตามแนวแกน Y */
    }
</style>

<body>
    <h2 style="font-weight: bold; color: black;">รายละเอียด</h2>
    <?php
    // เชื่อมต่อฐานข้อมูล
    $db = new ConnectDb();
    $conn = $db->getConn();


    // เตรียม SQL query โดยใช้ INNER JOIN เพื่อเชื่อมตาราง bagreserv กับ market โดยใช้ mk_id เป็นตัวเชื่อม
    $sql = "SELECT bagreserv.*, market.mk_name, market.mk_img, market.mk_id,
    TIMESTAMPDIFF(SECOND, NOW(), CONCAT(bagreserv.retrive_date, ' ', bagreserv.retrive_time)) AS time_left_seconds 
               FROM bagreserv 
               INNER JOIN market ON bagreserv.mk_id = market.mk_id
             where `bag_id`='{$_GET['id']}' ";
    $rs = mysqli_query($conn, $sql);

    // วนลูปเพื่อแสดงข้อมูลที่ได้จากฐานข้อมูล
    while ($data = mysqli_fetch_assoc($rs)) {
        $reserv = $data['reserv_time'];
        $reserv2 = $data['reserv_date'];
        $test = $data['retrive_time'];
        $test2 = $data['retrive_date'];
        $time_left_seconds = $data['time_left_seconds'];
        $mk_img = $data['mk_img'];
        $mk_id = $data['mk_id'];
        // คำนวณจำนวนวัน ชั่วโมง นาที และวินาที
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
        $bagid = $_GET['id'];

    ?>

        <div class="container">
            <div class="row justify-content-center">
                <!-- เพิ่มคลาส justify-content-center เพื่อจัดวาง blue-box และ white-box กลางแนวนอน -->
                <div class="col-md-10">
                    <!-- เปลี่ยน col-md-30 เป็น col-md-12 เพื่อให้ blue-box และ white-box เต็ม container -->
                    <div class="card">
                        <div class="d-flex w-100">
                            <div class="col-md-4">
                                <div class="card-body">
                                    <!-- <div class="d-flex justify-content-center"> -->
                                    <p style="font-size: 30px; font-weight: bold; color: white; margin-left: px;">
                                        จำนวนกระเป๋า</p>
                                    <div class="black-box" style="margin-left: px;">
                                        <h4><?php echo $data['quantity']; ?></h4>
                                    </div>
                                    <p style="font-size: 30px; font-weight: bold; color: white; margin-left: px;">
                                        เวลาฝากที่เหลือ</p>
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="black-box"><?= $days; ?> วัน</div>
                                            <div class="black-box"><?= $minutes; ?> นาที</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="black-box"><?= $hours; ?> ชั่วโมง</div>
                                            <div class="black-box"><?= $seconds; ?> วินาที</div>
                                        </div>
                                        <!-- </div>  -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-8" style="background-color: white; padding: 10px; border:3px solid; border-radius: 8px;">
                                <center>
                                    <?php
                                    $db = new ConnectDb();
                                    $conn = $db->getConn();
                                    $sql2 = "SELECT * FROM bagreserv 
        JOIN register ON register.m_id = bagreserv.m_id 
        WHERE  bagreserv.bag_id = '$bagid'";
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
                                                    echo '<img class="d-block w-50" src="' . htmlspecialchars($imageUrl) . '"  alt="Slide">'; // Sanitize imageUrl
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
                                </center>
                                <img src="images/cam.png" style="position: absolute; top: 0; left: 0; width: 5%; margin-top: 10px; margin-left: 370px;" alt="can">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup">
            <img src="" alt="Popup Image">
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var popupTrigger = document.querySelector('.popup-trigger');
                var popupImage = document.querySelector('.popup img');
                var popup = document.querySelector('.popup');

                popupTrigger.addEventListener('click', function() {
                    popupImage.src = this.src;
                    popup.style.display = 'block';
                });

                popup.addEventListener('click', function() {
                    popup.style.display = 'none';
                });
            });
        </script>
        <br>
        <div class="container">
            <div class="row justify-content-center">
                <!-- เพิ่มคลาส justify-content-center เพื่อจัดวาง blue-box และ white-box กลางแนวนอน -->
                <div class="col-md-30">
                    <!-- เปลี่ยน col-md-30 เป็น col-md-12 เพื่อให้ blue-box และ white-box เต็ม container -->
                    <div class="card2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-body" style=" margin-top: 40px;">

                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px; margin-bottom: 43px;">
                                        สถานะกระเป๋า :</p>
                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px; margin-bottom: 43px;">
                                        สถานที่รับฝาก :</p>
                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px; margin-bottom: 43px;">
                                        วันที่ฝาก :</p>
                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px; margin-bottom: 43px;">
                                        วันที่มารับ :</p>
                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px; margin-bottom: 43px;">
                                        ประเภทกระเป๋า :</p>
                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px; margin-bottom: 80px;">
                                        จำนวนกระเป๋า :</p>

                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="card-body">
                                    <h5 style="font-weight: bold; color: black;">หมายเลขออเดอร์ :
                                        <?php echo $data['order_number']; ?></h5>
                                    <div class="yellow-box"><?php echo $data['status']; ?> </div>

                                    <div class="yellow-box"><?php echo $data['mk_name']; ?> </div>

                                    <div class="yellow-box"></strong> <?= $reserv2; ?> </div>

                                    <div class="yellow-box"></strong> <?= $test2; ?></div>

                                    <div class="yellow-box"><?php echo $data['category_name']; ?></div>

                                    <div class="yellow-box"><?php echo $data['quantity']; ?> </div>

                                    <div class="blue-box">ชำระเเล้ว <span style="color: yellow;"><?php echo $data['total_price']; ?></span> บาท </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card-body">
                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px;">
                                        สถานที่ฝากกระเป๋า</p>

                                    <div class="white-box3" style="margin-left: 50px;">
                                        <img src="images/market/<?php echo $mk_img; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="">;
                                    </div>

                                    <br>

                                    <p style="font-size: 20px; font-weight: bold; color: black; margin-left: 50px;">เเผนที่
                                    </p>
                                    <a href="?page=map&id=<?php echo $mk_id; ?> ">
                                        <div class="white-box3" style="margin-left: 50px;"> <img src="images/รูปแมพ.jpg" style="width: 100%; height: 100%; object-fit: cover;" alt="">; </div>
                                    </a>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <?php } ?>
</body>