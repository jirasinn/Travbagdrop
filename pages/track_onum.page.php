<!-- HTML และ PHP code -->
<!-- HTML code -->
<div class="container">
<form action="" method="POST">
  <h5><b><label for="order_number">Order Number</label></b></h5>
  <input type="text" id="order_number" name="order_number" placeholder="กรุณากรอก Order number">
  <p id="order_number_error" style="color: red; display: none;">ไม่มีหมายเลข order นี้ โปรดระบุให้ถูกต้อง</p>
  <p id="order_number_error2" style="color: red; display: none;">โปรดกรอกหมายเลข order ของท่าน</p>
  <button type="submit" name="search"><b><i class="bi bi-search"></i>ค้นหา</b></button>

  <p class="forgot">ลืม Order number ใช่หรือไม่? <span>กรุณาค้นหาด้วยวิธีอื่น</span></p>
  </form>
  <button class="link" onclick="window.location.href='?page=track_phone'"><b>ค้นหากระเป๋าโดยใช้เบอร์โทรศัพท์</b></button>
        <button class="link" onclick="window.location.href='?page=track_email'"><b>ค้นหากระเป๋าโดยใช้อีเมลล์</b></button>
    
</div>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Check if search button is clicked
      if (isset($_POST['search'])) {
          // Check if order number is set and not empty
          if (isset($_POST['order_number']) && !empty($_POST['order_number'])) {
              // Connect to database
              $db = new ConnectDb();
              $conn = $db->getConn();

              // Check connection
              if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
              }

              // Escape user input to prevent SQL Injection
              $order_number = $conn->real_escape_string($_POST['order_number']);

              // Check if order number exists in database
              $sql = "SELECT * FROM bagreserv WHERE order_number = '$order_number'";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                  // Order number exists, redirect to showtrack page with order_number
                  echo "<script>window.location.href = '?page=showtrack&order_number=$order_number';</script>";
                  exit();
              } else {
                  // Order number does not exist, display error message
                  echo "<script>document.getElementById('order_number_error').style.display = 'block';</script>";
              }

              // Close database connection
              $conn->close();
          } else {
              // If order number is not provided
              echo "<script>document.getElementById('order_number_error2').style.display = 'block';</script>";
          }
      }
  }
  ?>
</form>



<!-- end col-md-12 -->


<!-- css -->

<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
}

.container {
  max-width: 400px;
  margin: 50px auto;
  padding: 40px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 10px;
}

input[type="text"] {
  width: 100%;
  padding: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

button {
  width: 100%;
  padding: 10px;
  background-color: yellow;
  color: #000;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.forgot {
  display: inline-block; /* เปลี่ยนเป็น inline-block */
  text-align: center;
  color: #F8F61F;
  margin-top: 20px;
  margin-bottom: 10px;
  padding: 10px;
  background-color: black;
}

.forgot span {
  display: inline-block;
}

.link {
  width: 100%;
  padding: 10px;
  background-color: #F8F61F;
  color: #000;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 10px;
}

.link:hover {
  background-color: #45a049;
}
</style>
<!-- end css -->