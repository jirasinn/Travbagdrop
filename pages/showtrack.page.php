<div class="container col-md-12">
  <!--  -->
  <?php
  // showtrack.php
  

  // Check if any of the expected data is passed in the URL
  if (isset($_GET['order_number'])) {
    $order_number = $_GET['order_number'];
  } elseif (isset($_GET['m_email'])) {
    $m_email = $_GET['m_email'];
  } elseif (isset($_GET['m_phone'])) {
    $m_phone = $_GET['m_phone'];
  } else {
    // If none of the expected data is provided
    echo "กรุณากรอกข้อมู,การค้นหาให้ถูกต้อง";
    exit; // Stop further execution of the script
  }

  ?>

  <div class="container col-md-6">
    <!--  -->
    <div class="form-row">
      <div class="container text-left">
        <div class="name">
          <i class="bi bi-buildings-fill"></i> ร้านค้า

          <div class="value">
            <select name="mk">
              <?php
              $db = new ConnectDb();
              $conn = $db->getConn();

              $sql2 = "SELECT * FROM market";

              $rs2 = mysqli_query($conn, $sql2);
              while ($data2 = mysqli_fetch_array($rs2)) {
                ?>
                <option value="<?= $data2['mk_id']; ?>">
                  <?= $data2['mk_name']; ?>
                </option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <!--  -->
      <div style="width: 100%; height: 350px;">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15502.638045931446!2d100.53719877480333!3d13.736717500708313!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30e29ecbeaa17cb5%3A0x9c9e7e9516616586!2sWat%20Pho!5e0!3m2!1sen!2sth!4v1644159719795!5m2!1sen!2sth"
          width="500" height="200" style="border: 30px;;" allowfullscreen="" loading="lazy"></iframe>
      </div>
      <!--  -->

      <?php
 $db = new ConnectDb();
 $conn = $db->getConn();
 
 $sql = "SELECT * FROM bagreserv ";
 if (!empty($order_number)) {
   $sql .= "LEFT JOIN market ON bagreserv.mk_id = market.mk_id
     WHERE order_number = '$order_number'";
 } elseif (!empty($m_email)) {
   $sql .= "JOIN register ON bagreserv.m_id = register.m_id 
   LEFT JOIN market ON bagreserv.mk_id = market.mk_id
           WHERE register.m_email = '$m_email'";
 } elseif (!empty($m_phone)) {
   $sql .= "JOIN register ON bagreserv.m_id = register.m_id 
   LEFT JOIN market ON bagreserv.mk_id = market.mk_id
           WHERE register.m_phone = '$m_phone'";
 }

 $rs = mysqli_query($conn, $sql);

 if ($rs && mysqli_num_rows($rs) > 0) {
  $data = mysqli_fetch_assoc($rs);
  // 
  $pictures = json_decode($data['picture'], true);
  ?>

  <!-- แสดงรูปภาพโดยใช้ข้อมูลจากฐานข้อมูล -->
  <div style="width: 90%; height: 350px;">
    <?php foreach ($pictures as $picture) : ?>
      <img src="images/<?php echo $picture; ?>" height="200" class="d-block w-50" alt="">
    <?php endforeach; ?>
  </div>

      <!--  -->
    </div>
  </div>
  <br><br><br><br>
  <!--  -->

    <!--  -->
    <div class="container col-md-6">
      <form method="post"> <!-- เพิ่ม method="post" เพื่อระบุว่าจะใช้วิธีการส่งข้อมูลแบบ POST -->
        <label for="text" align='center'>
          <h4><b>Order: #
              <?= $data['order_number'] ?>
            </b></h4>
        </label>
        <hr><br>
        <!--  -->
        <b><label for="status">สถานะกระเป๋า: </label></b>
        <input type="text" id="status" name="status" value="<?= $data['status'] ?>" readonly>

        <b><label for="mk_name">สถานที่รับฝาก: </label></b>
        <input type="text" id="mk_name" name="mk_name" value="<?= $data['mk_name'] ?>" readonly>

        <b><label for="reserv_date">วันที่ฝาก: </label></b>
        <input type="text" id="reserv_date" name="reserv_date" value="<?= $data['reserv_date'] ?>" readonly>

        <b><label for="retrive_date">วันที่มารับ: </label></b>
        <input type="text" id="retrive_date" name="retrive_date" value="<?= $data['retrive_date'] ?>" readonly>

        <b><label for="category_name">ประเภทของกระเป๋า: </label></b>
        <input type="text" id="category_name" name="category_name" value="<?= $data['category_name'] ?>" readonly
          style="text-align: left ;">

        <b><label for="quantity">จำนวนกระเป๋า: </label></b>
        <input type="text" id="quantity" name="quantity" value="<?= $data['quantity'] ?>" readonly>


        <!--  -->
        <!-- ปุ่ม Submit -->
        <!-- <input type="submit" name="submit_payment" value="ชำระเงิน"> -->
    </div>
    </form>
  <?php } ?>
</div>

<!-- end col-md-12 -->
</div>


<!-- css -->

<style>
  .container {
    display: flex;
    padding: 15px;
    justify-content: space-between;
    /* จัดฟอร์มและสถานที่รับฝากอยู่ด้านขวาและซ้ายของพื้นที่ flex */
  }

  .container form {
    width: 100%;
    /* กำหนดความกว้างของฟอร์ม */
  }

  form {
    width: 400px;
    margin: 0;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-top: 5px solid #ffcc00;
    /* เพิ่มสีเหลืองๆที่ขอบบนของการ์ด */
    margin-right: 20px;
    /* เพิ่มระยะห่างด้านขวาของฟอร์ม */
  }

  label {
    display: block;
    margin-bottom: 5px;
  }

  input[type="text"],
  input[type="email"],
  input[type="tel"],
  textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }

  input[type="submit"] {
    background-color: #ffcc00;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  input[type="submit"]:hover {
    background-color: #ffc200;
  }
</style>
<!-- end css -->