<!-- HTML และ PHP code -->
<!-- HTML code -->
<div class="container">
    <form action="" method="POST">
        <h5><b><label for="m_email">อีเมลล์</label></b></h5>
        <input type="text" id="m_email" name="m_email" placeholder="กรุณากรอกอีเมลล์">
        <p id="m_email_error" style="color: red; display: none;">ไม่มีการรับฝากจาก อีเมลล์ นี้โปรดระบุให้ถูกต้อง</p>
        <p id="m_email_error2" style="color: red; display: none;">โปรดกรอก อีเมลล์ ของท่าน</p>
        <button type="submit" name="search"><b><i class="bi bi-search"></i>ค้นหา</b></button>

        <p class="forgot">ลืม อีเมลล์ ใช่หรือไม่? <span>กรุณาค้นหาด้วยวิธีอื่น</span></p>
    </form>
    <button class="link" onclick="location.href='?page=track_phone'"><b>ค้นหากระเป๋าโดยใช้เบอร์โทรศัพท์</b></button>
    <button class="link" onclick="location.href='?page=track_onum'"><b>ค้นหากระเป๋าโดยใช้หมายเลขออเดอร์</b></button>

</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if search button is clicked
    if (isset($_POST['search'])) {
        // Check if order number is set and not empty
        if (isset($_POST['m_email']) && !empty($_POST['m_email'])) {
            // Connect to database
            $db = new ConnectDb();
            $conn = $db->getConn();

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Escape user input to prevent SQL Injection
            $m_email = $conn->real_escape_string($_POST['m_email']);

            // Check if order number exists in database
            $sql = "SELECT * FROM bagreserv 
              JOIN register on register.m_id = bagreserv.m_id 
              WHERE register.m_email = '$m_email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Order number exists, redirect to showtrack page with m_email
                echo "<script>window.location.href = '?page=showtrack&m_email=$m_email';</script>";
                exit();
            } else {
                // Order number does not exist, display error message
                echo "<script>document.getElementById('m_email_error').style.display = 'block';</script>";
            }

            // Close database connection
            $conn->close();
        } else {
            // If order number is not provided
            echo "<script>document.getElementById('m_email_error2').style.display = 'block';</script>";
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
    display: block;
    /* เปลี่ยนเป็น block */
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