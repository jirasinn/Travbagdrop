<?php
if (!isset($_SESSION['bagdrop_member_id_type'])) {
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
  <a href="?page=reserv_new2&store=<?= $storeCode; ?>"><img src="images/กลับ.png" width="4%" style="margin-left: 15%;  margin-top: 0%; "></a>

</div>

<div class="circle-bar col-md-12">

  <div class="circle">
    1
    <div class="circle-description">ข้อมูลสัมภาระ</div>
  </div>
  <div class="circle">
    2
    <div class="circle-description">ข้อมูลลูกค้า</div>
  </div>
  <div class="circle active">
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

      <div class="row col-md-12" style="margin-top: 1.5%; font-size: 24px; margin-left: 2px;">

      <div class="row col-md-7" >
        <p><label for="payCha"><b>ช่องทางชำระเงิน</b> </label></p>
        <select name="payCha" id="payCha" class="rounded-button" style="border-radius: 5px; width: 87%; border: 2px solid #000;">
          <option value="debit_credit">ชำระด้วยบัตรเดบิต/เครดิต</option>
          <option value="qr_code">ชำระด้วยคิวอาร์โค๊ด</option>
        </select>
        </div>

        <div class="container col-md-12">
          <div class="row col-md-6">
            <p><label for="m_lname"><b>ชื่อบนบัตร/name on card</b></p>
            <input type="text" name="card_name" placeholder="ชื่อบนบัตร/name on card" style="border-radius: 5px;">

            <p><label for="m_lname"><b>หมายเลขบัตรเดบิต/เครดิต</b></p>
            <input type="text" name="card_number" placeholder="หมายเลขบัตรเดบิต/เครดิต" style="border-radius: 5px;">

          </div>
          <!--  -->
          <div class="row col-md-6">
            <!--  -->
            <p><label for="m_lname"><b>วันหมดอายุ/Expiration date</b></p>
            <input type="text" name="expiration_date" placeholder="วันหมดอายุ/Expiration date" style="border-radius: 5px;">

            <p><label for="m_lname"><b>รหัส CVC/CVV</b></p>
            <input type="text" name="cvc" placeholder="รหัส CVC/CVV" style="border-radius: 5px;">
            <!--  -->
          </div>

          <!-- end 12 -->
        </div>


      </div>
      <!--  -->

      <?php
      $db = new ConnectDb();
      $conn = $db->getConn();

      // เตรียม SQL query

      $sql = "SELECT cart.*,  market.mk_name
         FROM cart 
        JOIN market on market.mk_id = cart.mk_id
        WHERE cart.m_id = '$m_id'";

      $rs = mysqli_query($conn, $sql);

      if ($rs && mysqli_num_rows($rs) > 0) {
        // เรียก mysqli_fetch_assoc() เพื่อดึงแถวแรก
        $data = mysqli_fetch_assoc($rs);
        $mk_name = $data['mk_name'];
        $mk_id = $data['mk_id'];

      ?>
        <!--  -->

        <?php
        $db = new ConnectDb();
        $conn = $db->getConn();

        // เตรียม SQL query
        $sql6 = "SELECT * FROM cart WHERE cart.m_id = $m_id AND cart.mk_id = '$mk_id'";

        $rs6 = mysqli_query($conn, $sql6);

        $already_shown_idcards = [];

        // แสดงข้อมูล idcard และรูปภาพที่ไม่ซ้ำ
        while ($data6 = mysqli_fetch_assoc($rs6)) {
          $idcard = $data6['idcard'];

          if (!empty($idcard) && !in_array($idcard, $already_shown_idcards)) {
        ?>
            <div class="col-md-2">
              <img hidden src="images/idcard/<?= $idcard; ?>" class="img-fluid" style="width: 50%; height: 55%;" alt="<?= $idcard; ?>">
            </div>
        <?php
            // เพิ่ม idcard เข้าไปในตัวแปรเพื่อระบุว่าได้แสดงไว้แล้ว
            $already_shown_idcards[] = $idcard;
          }
        }
        ?>

        <!--  -->
        <input type="hidden" name="idcard_files" value="<?= $idcard; ?>">
        <input type="hidden" name="mk_id" value="<?= $data['mk_id']; ?>">
        <input type="hidden" name="mk_name" value="<?= $data['mk_name']; ?>">
        <input type="hidden" name="reserv_date" value="<?= $data['reserv_date']; ?>">
        <input type="hidden" name="reserv_time" value="<?= $data['reserv_time']; ?>">
        <input type="hidden" name="retrive_date" value="<?= $data['retrive_date']; ?>">
        <input type="hidden" name="retrive_time" value="<?= $data['retrive_time']; ?>">
        <!--  -->
        <?php
        mysqli_data_seek($rs, 0);
        $category_names = array();
        $total_quantity = 0;
        $total_price = 0;
        // $pictures = array();

        // วนลูปเพื่อดึงข้อมูลรูปภาพ
        while ($cartData = mysqli_fetch_assoc($rs)) {

          $category_name = trim($cartData['category_name']);

          // เก็บชื่อของสินค้าลงในอาเรย์ และบวกจำนวนและราคารวม
          if (!in_array($category_name, $category_names)) {
            $category_names[] = $category_name;
          }

          $total_quantity += $cartData['quantity'];
          $total_price += $cartData['price'];
          // $pictures[] = $cartData['picture'];
        }

        // สร้าง string ที่มีรายการของชื่อสินค้า
        $category_str = implode(", ", $category_names);

        ?>
        <!--  -->

        <?php

        $db = new ConnectDb();
        $conn = $db->getConn();

        // เตรียม SQL query
        $sql8 = "SELECT * FROM cart WHERE cart.m_id = $m_id AND cart.mk_id = '$storeCode'";

        $rs8 = mysqli_query($conn, $sql8);

        while ($data8 = mysqli_fetch_assoc($rs8)) {
          $idcard = $data8['idcard'];

          $pictures = preg_split('/,\s*"/', $data8['picture']);
          foreach ($pictures as $picture) {
            // ตัดเครื่องหมาย " ออกจากชื่อไฟล์
            $picture = trim($picture, '"');
        ?>

            <div class="col-md-2">
              <!-- <img src="images/<?php echo $picture; ?>" class="img-fluid " style="width: 20%; height: 25%;"
                alt="<?php echo $picture; ?>"> -->
              <input type="hidden" name="pictures[]" value="<?= $picture; ?>">
            </div>

        <?php
          }
        }
        ?>

        <!--  -->
        <!-- <input type="hidden" name="pictures[]" value="<?= $picture; ?>"> -->
        <input type="hidden" name="category_str" value="<?= $category_str; ?>">
        <input type="hidden" name="total_price" value="<?= $total_price; ?>">
        <input type="hidden" name="total_quantity" value="<?= $total_quantity; ?>">

        <!-- ปุ่ม Submit -->

        <div class="card-submit" align="center" style="margin-top: 2%;">
          <!-- เปลี่ยน <a> tag เป็น <button> tag -->
          <button type="submit" name="submit_payment" class="yellow-button">ชำระเงิน</button>
        </div>

  </form>

<?php } else {
        echo "ไม่พบข้อมูลที่ตรงกับเงื่อนไข โปรดตรวจสอบว่าท่านได้ทำรายการไปแล้วหรือไม่";
      } ?>

</div>
<!--  -->

<!-- End col-md-12 -->
</div>
<div class="container col-12">
  <form class="third-form">

    <br>
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
        <div class="reservation-info green-text">เวลาในการฝาก <?= $reserv_date; ?> <span class="time">เวลา
            <?= $reserv_time; ?></div>
        <div class="reservation-info red-text">เวลาในการรับคืน <?= $retrive_date; ?> <span class="time2">เวลา
            <?= $retrive_time; ?></div>
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
    <!--  -->

    <!--  -->
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
        <label class="card-text2">
          <h3>
            <div id="total-price-display" name="total_price"><b>ราคารวมทั้งสิ้น <?php echo $sumprice; ?>
                บาท</b></div>
            <input type="hidden" id="total_price_input" name="total_price" value="<?php echo $sumprice; ?>">
          </h3>
        </label>
        <br>

        <!--  -->

        <!--  -->
      </div>
    </div>
  </form>


  <!--  -->

  <?php

  // ฟังก์ชันสำหรับสร้าง Order Number อัตโนมัติโดยไม่ซ้ำกัน  
  function generateUniqueOrderNumber($conn)
  {
    $row = ['count' => 0]; // กำหนดค่าเริ่มต้นให้ $row เป็น array ที่มี key 'count' และมีค่าเป็น 0

    do {
      // สร้าง Order Number แบบสุ่ม
      $order_number = generateOrderNumber();

      // ตรวจสอบว่า Order Number นี้ซ้ำกับที่มีในฐานข้อมูลหรือไม่
      $sqlCheck = "SELECT COUNT(*) AS count FROM bagreserv WHERE order_number = '$order_number'";
      $result = mysqli_query($conn, $sqlCheck);
      $row = mysqli_fetch_assoc($result);

      // ถ้า Order Number นี้ไม่ซ้ำกับที่มีในฐานข้อมูลให้ออกจากลูป
    } while ($row['count'] > 0);

    return $order_number;
  }

  // ฟังก์ชันสำหรับสร้าง Order Number อัตโนมัติ
  function generateOrderNumber()
  {
    // สร้าง timestamp
    $timestamp = microtime(true) * 10000; // หรือแปลงเป็นช่วงที่ต้องการ
    $timestamp = substr($timestamp, 0, 10); // ให้ timestamp มีความยาว 10 หลัก

    // สร้างเลขสุ่ม 4 หลัก
    $random_number = random_int(0, 9999);
    $random_number = str_pad($random_number, 4, '0', STR_PAD_LEFT); // ให้ random_number มีความยาว 4 หลัก

    // รวม timestamp กับเลขสุ่ม
    $order_number = $timestamp . $random_number;

    // ตรวจสอบความยาวของ order_number
    if (strlen($order_number) > 10) {
      // ถ้ามีความยาวมากกว่า 10 หลัก ให้ตัดเอาเฉพาะ 10 หลักแรก
      $order_number = substr($order_number, 0, 10);
    }

    return $order_number;
  }

  // ตรวจสอบว่ามีการส่งค่า POST หรือไม่
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_payment'])) {
    // ให้ทำการป้องกัน SQL injection attacks โดยใช้ mysqli_real_escape_string() หรือ Prepared Statements
    $mk_id = mysqli_real_escape_string($conn, $_POST['mk_id']);
    $mk_name = mysqli_real_escape_string($conn, $_POST['mk_name']);
    $reserv_date = mysqli_real_escape_string($conn, $_POST['reserv_date']);
    $reserv_time = mysqli_real_escape_string($conn, $_POST['reserv_time']);
    $retrive_date = mysqli_real_escape_string($conn, $_POST['retrive_date']);
    $retrive_time = mysqli_real_escape_string($conn, $_POST['retrive_time']);
    $category_str = mysqli_real_escape_string($conn, $_POST['category_str']);
    $total_quantity = mysqli_real_escape_string($conn, $_POST['total_quantity']);
    $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);

    $pictures = $_POST['pictures'];
    $pictures_json = json_encode($pictures);
    // สร้าง Order Number อัตโนมัติโดยไม่ซ้ำกัน
    $order_number = generateUniqueOrderNumber($conn);

    // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพหรือไม่
    if (!empty($_FILES['pictures']['name'][0])) {
      // ทำการตรวจสอบไฟล์รูปภาพที่อัปโหลด
      $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
      $targetDir = "images/";

      foreach ($_FILES['pictures']['tmp_name'] as $key => $tmp_name) {
        $file_type = $_FILES['pictures']['type'][$key];
        $file_size = $_FILES['pictures']['size'][$key];

        // ตรวจสอบประเภทของไฟล์และขนาดของไฟล์
        if (in_array($file_type, $allowed_types) && $file_size > 0) {
          $file_name = $_FILES['pictures']['name'][$key];
          $targetFilePath = $targetDir . $file_name;
          // ย้ายไฟล์ไปยังตำแหน่งเก็บข้อมูล
          if (move_uploaded_file($_FILES['pictures']['tmp_name'][$key], $targetFilePath)) {
            $pictures[] = $file_name;
          }
        }
      }
    }

    // ตรวจสอบว่ามีรูปถูกอัปโหลดหรือไม่
    if (!empty($pictures)) {
      // ตรวจสอบว่ามีไฟล์ idcard ถูกส่งมาหรือไม่
      if (isset($_POST['idcard_files'])) {
        // รับค่า 'idcard_files' จาก input hidden
        $idcard_file_name = $_POST['idcard_files'];

        $db = new ConnectDb();
        $conn = $db->getConn();
        // หากย้ายไฟล์ไปยังตำแหน่งที่ต้องการสำเร็จแล้ว
        $pictures_json = json_encode($pictures);
        $sqlInsert = "INSERT INTO bagreserv (mk_id, order_number, m_id, mk_name, reserv_date, reserv_time, retrive_date, retrive_time, category_name, quantity, total_price, picture, idcard, status,noti_status) 
                                VALUES ('$mk_id', '$order_number', '$m_id', '$mk_name', '$reserv_date', '$reserv_time', '$retrive_date', '$retrive_time', '$category_str', '$total_quantity', '$total_price', '$pictures_json', '$idcard_file_name', 'รอดำเนินการ', 'unread')";


        if (mysqli_query($conn, $sqlInsert)) {

          echo "
        <script>
        // สร้าง modal
        const modal = document.createElement('div');
        modal.classList.add('modal', 'fade');
        modal.id = 'confirmationModal';
        modal.setAttribute('data-bs-backdrop', 'static'); // ป้องกันการปิด modal ด้วยการคลิก backdrop
        modal.setAttribute('data-bs-keyboard', 'false'); // ป้องกันการปิด modal ด้วยการกดปุ่ม ESC
        modal.innerHTML = `
          <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
                <div class='modal-body' style='text-align: center;'>
                    <h2><p style='color: green;'>Success</p></h2>
                    <img src='images/success.png' alt='รายละเอียดรูปภาพ' style='width: 50%; height: auto;'>
                    <br><br>
        
                    <button type='button' class='btn btn-warning' id='ratingBtn' style='border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); border: 1px solid black;'>ให้คะแนนความพึงพอใจ</button><br><br>
                    <button type='button' class='btn btn-white' id='confirmPaymentBtn' style='border-radius: 10px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); border: 1px solid black;'>ขอเส้นทางไปร้านค้า</button>
                    
                </div>
            </div>
          </div>
        `;
        document.body.appendChild(modal);
        
        // เรียกใช้งาน modal ที่สร้างขึ้น
        const myModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {backdrop: 'static', keyboard: false});
        // เมื่อ modal ปรากฏขึ้น
        myModal.show();
        
        // เพิ่มการทำงานเมื่อปุ่ม 'ขอเส้นทางไปร้านค้า' ถูกคลิก
        document.getElementById('confirmPaymentBtn').addEventListener('click', function() {
            window.location.href = '?page=map';
        });
        
        // เพิ่มการทำงานเมื่อปุ่ม 'ให้คะแนนความพึงพอใจ' ถูกคลิก
        document.getElementById('ratingBtn').addEventListener('click', function() {
            const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'), {backdrop: 'static', keyboard: false});
            ratingModal.show();
        });
        
        // เพิ่มการตรวจสอบว่าคลิกเกิดขึ้นที่ modal หรือไม่
        modal.addEventListener('click', function(event) {
            if (!event.target.closest('.modal-content')) {
                event.stopPropagation(); // ป้องกันการกระจุก event ไปยัง element ที่ไม่เกี่ยวข้องกับ modal
            }
        });

        // เพิ่มการทำงานเมื่อปุ่ม 'ให้คะแนนความพึงพอใจ' ถูกคลิก
        document.getElementById('ratingBtn').addEventListener('click', function() {
            // ปิด Modal แรก
            myModal.hide(); // ปิด Modal แรก
        
            // เรียกใช้ Modal ที่มี id เป็น 'ratingModal'
            const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'), {backdrop: 'static', keyboard: false});
            ratingModal.show();
        });
        

        </script>
        ";

          // ให้คะแนนความพึงพอใจ
          echo "
                            <div class='modal fade' id='ratingModal' tabindex='-1' aria-labelledby='ratingModalLabel' aria-hidden='true'>
                            <div class='modal-dialog modal-dialog-centered'>

                                <div class='modal-content'>
                                    <div class='modal-body'>
                                        <form2 id='ratingForm'>
                                    <div class='mb-3'>
                                        <b><h4 class='modal-title' id='ratingModalLabel'>ให้<span style='font-size: bold;'>คะแนน</span>ความพึงพอใจกับ $mk_name</h4></b>
                                        <br>
                                    <div id='stars'>
                                        <i class='fa fa-star' data-index='1'></i>
                                        <i class='fa fa-star' data-index='2'></i>
                                        <i class='fa fa-star' data-index='3'></i>
                                        <i class='fa fa-star' data-index='4'></i>
                                        <i class='fa fa-star' data-index='5'></i> <span style='font-size: smaller;'>คะแนน</span>
                                    </div> 
                                    </div>
                                    
                                            <div class='mb-3'>
                                                <label for='suggestion' class='form-label' style='font-size: bold;'>ข้อเสนอแนะ</label>
                                                <textarea class='form-control' id='suggestion' name='suggestion' rows='3'></textarea>
                                            </div>

                                            <input type='hidden' id='mk_id' name='mk_id' value='$mk_id'>
                                            <input type='hidden' id='m_id' name='m_id' value='$m_id'>
                                            <button type='button' class='btn btn-primary' id='submitRatingBtn'>ตกลง</button>
                                        </form2>

                                    </div>
                                </div>
                                
                            </div>
                        </div>";

          // เรียกใช้งาน modal ที่สร้างขึ้น
          echo "
        <script>
        const ratingModal = new bootstrap.Modal(document.getElementById('ratingModal'), { backdrop: 'static', keyboard: false });
ratingModal.show();

const stars = document.querySelectorAll('#stars i');

stars.forEach(function (star) {
    star.addEventListener('click', function () {
        const index = parseInt(this.getAttribute('data-index'));

        stars.forEach(function (innerStar, i) {
            if (i < index) {
                innerStar.classList.add('rated');
            } else {
                innerStar.classList.remove('rated');
            }
        });

        document.getElementById('rating').value = index;
    });
});

document.getElementById('submitRatingBtn').addEventListener('click', function() {
  const rating = document.querySelectorAll('#stars .rated').length; 
  const suggestion = document.getElementById('suggestion').value;
  const mk_id = document.getElementById('mk_id').value;
  const m_id = document.getElementById('m_id').value;
  
  const formData = new FormData();
  formData.append('rating', rating);
  formData.append('suggestion', suggestion);
  formData.append('mk_id', mk_id);
  formData.append('m_id', m_id);
  
  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'crud/feedback.php', true);
  xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
              console.log('Feedback saved successfully:', xhr.responseText);
              // แสดง Alert แจ้งว่า Feedback สำเร็จ
              alert('Feedback สำเร็จ ขอบคุณที่ให้ความร่วมมือ!');
              // เปลี่ยนเส้นทาง URL ไปยังหน้า home
              window.location.href = '?page=home';
          } else {
              console.error('There was an error saving feedback:', xhr.status);
              alert('มีข้อผิดพลาดเกิดขึ้น!');
              window.location.href = '?page=home';
              
          }
      }
  };
  xhr.send(formData);
});

    </script>

    <style>
        #stars {
            font-size: 36px;
        }
    
        #stars i {
            color: #ccc;
            cursor: pointer;
        }
    
        #stars i.rated {
            color: yellow;
        }
    </style>
    ";

          // ลบข้อมูลในตาราง cart ที่มี m_id เท่ากับ $m_id
          $sqlDeleteCart = "DELETE FROM cart WHERE m_id = '$m_id'";
          if (mysqli_query($conn, $sqlDeleteCart)) {
            // ทำสิ่งที่ต้องการหลังจากลบข้อมูลในตาราง cart สำเร็จ
          } else {
            // กรณีเกิดข้อผิดพลาดในการลบข้อมูลในตาราง cart
            echo "Error deleting record: " . mysqli_error($conn);
          }
        } else {
          // กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
          echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
          echo "Error: " . $sqlInsert . "<br>" . mysqli_error($conn);
        }
      } else {
        // กรณีเกิดข้อผิดพลาดในการย้ายไฟล์ไปยังตำแหน่งที่ต้องการ
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดไฟล์ idcard');</script>";
      }
    }
  }
  ?>

  <!--  -->
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
    content: "ชำระเงิน";
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

  .card-text2 {
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

  /* modal */
  .card-text {
    background-color: gray;
    padding: 5px 10px;
    /* เพิ่มการเติมระยะขอบ */
    border-radius: 5px;
    /* เพิ่มการกำหนดรูปร่าง */
  }

  .modal-content {
    border-radius: 40px;
    /* ปรับขอบมนเรียบ */
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    /* เพิ่มเงา */
  }

  /*  */
</style>