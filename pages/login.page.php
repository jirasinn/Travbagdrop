<?php
$isSubmitted = isset($_POST["login"]);
if ($isSubmitted) {
    $db = new ConnectDb();
    $conn = $db->getConn();

    $password = $_POST['password'];
    $email = $_POST['email'];

        // ไม่พบข้อมูลในตาราง market หรือรหัสผ่านไม่ถูกต้อง
        // ทำการตรวจสอบจากตาราง register ต่อ
        $sql_register = "SELECT * FROM register WHERE m_email='$email'";
        $rs_register = mysqli_query($conn, $sql_register);
        $data_register = mysqli_fetch_assoc($rs_register);

        if ($data_register && password_verify($password, $data_register['m_password'])) {
            // เข้าสู่ระบบสำเร็จ
            $_SESSION['bagdrop_member_id'] = $data_register['m_id'];
            $_SESSION['bagdrop_member_fname'] = $data_register['m_fname'];
            $_SESSION['bagdrop_member_lname'] = $data_register['m_lname'];
            $_SESSION['bagdrop_member_id_email'] = $data_register['m_email'];
            $_SESSION['bagdrop_member_id_type'] = $data_register['urole'];

            if ($data_register['urole'] == 'admin') {
                echo "<script>window.location='?page=admin';</script>";
            } else {
                echo "<script>window.location='?page=home';</script>";
            }
            exit();
        } else {
            // ไม่สามารถเข้าสู่ระบบได้
            $_SESSION['error'] = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
            echo "<script>window.location='?page=login';</script>";
            exit();
        }
    }



?>

<div class="background">
    <div class="container">
        <div style="width: 500px; height: 10px; border-radius: 0 0 10px 10px; background-color: #f4f71b; margin-top:-20px; margin-bottom:20px;"></div>
        <h1>เข้าสู่ระบบ</h1>
        <form action="" method="post">
            <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <center>
                <a href="Social-login/facebook-oauth.php" class="social-button" id="facebook-connect"> <span>เข้าสู่ระบบด้วย Facebook</span></a>
                <a href="Social-login/google-oauth.php" class="social-button" id="google-connect"> <span>เข้าสู่ระบบด้วย Google</span></a>
                <a href="Social-login/wechat-oauth.php" class="social-button" id="wechat-connect"> <span>เข้าสู่ระบบด้วย Wechat</span></a>

                <h1>หรือ</h1>

                <input type="email" placeholder="อีเมล" name="email" required>
                <input type="password" placeholder="รหัสผ่าน" require name="password">
                <br>
                <button type="submit" name="login" required>เข้าสู่ระบบ</button>
                <br>
                <br>
             
                <p>
                <a class="forgot-password" href="?page=login_partner">เข้าสู่ระบบพาร์ทเนอร์?</a>  ,
                     <a class="forgot-password" href="?page=login_admin">เข้าสู่ระบบแอดมิน?</a>
            </p>

                <a class="forgot-password" href="?page=newpass">ลืมรหัสผ่านใช่หรือไม่?</a>
                <p class="signup" onclick="showPopup()">ยังไม่ได้เป็นสมาชิก? <a href="#">Sign up</a></p>
            </center>
        </form>
    </div>
</div>


<!--  -->

<!-- Popup แจ้งเตือน -->
<div id="popup-container" class="popup-container">
    <div class="popup">
        <h3>ข้อตกลงและเงื่อนไข</h3>
        <p>โปรดอ่านและทำความเข้าใจข้อตกลงและเงื่อนไขต่อไปนี้ก่อนที่จะทำการสมัครสมาชิก</p>
        <ul>
            <li>1. ข้อมูลส่วนตัวที่คุณกรอกจะถูกใช้เพื่อวัตถุประสงค์ในการสมัครสมาชิก</li>
            <li>2. เราจะไม่ให้ข้อมูลส่วนตัวของคุณแก่บุคคลภายนอกโดยไม่ได้รับความยินยอมของคุณ</li>
            <li>3. คุณไม่สามารถยกเลิกการสมัครสมาชิกได้</li>
        </ul>

        <br><br><br>
        <input type="checkbox" id="acceptCheckbox"> <b>ฉันได้อ่านและยอมรับข้อตกลงและเงื่อนไข</b>
        <br>

        <button onclick="hidePopup()">ไม่ยินยอม</button>
        <button onclick="acceptAndRedirect()">ยินยอมและสมัคร</button>

    </div>
</div>

<script>
    // ฟังก์ชั่นแสดง popup
    function showPopup() {
        document.getElementById('popup-container').style.display = 'flex';
    }

    // ฟังก์ชั่นซ่อน popup
    function hidePopup() {
        document.getElementById('popup-container').style.display = 'none';
    }

    // ฟังก์ชั่นทำการสมัครหลังจากการยินยอม
    function acceptAndRedirect() {
        var acceptCheckbox = document.getElementById('acceptCheckbox');

        if (acceptCheckbox.checked) {
            window.location.href = '?page=register.m';
        } else {
            alert('โปรดยอมรับข้อตกลงก่อนที่จะสมัคร');
        }
    }
</script>

<style>
    /* สไตล์สำหรับ popup */
    .popup-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .popup {
        background: #fff;
        padding: 20px;
        border-radius: 20px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        max-width: 600px;
        margin: 0 auto;
    }

    .popup button {
        padding: 10px 30px;
        margin: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
    }

    .popup button.accept {
        background-color: #4CAF50;
        color: #fff;
    }

    .popup button.close {
        background-color: #f44336;
        color: #fff;
    }

    .popup input[type="checkbox"] {
        margin-right: 5px;
    }

    li {
        display: inline-block;
        position: relative;
        transition: 0.4s all ease;
    }

    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 500px;
        padding: 20px;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 50px auto;
    }

    .background {
        position: relative;
        overflow: hidden;
    }

    .background::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 100%;
        top: 40%;
        left: 10%;
        z-index: -1;
        background: url('https://s3-alpha-sig.figma.com/img/a2e3/59ad/c8e3e7ac163a3e1d4298219605114df0?Expires=1709510400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=Mwqa11pFmXUR6vEvQgFGuYkDqzZgITN0nNUCz0C-T42q2blNAUMK37HfQYpCrtuI4hZ58adKflDCTv2xpjUc7Dq5fJ8x0vmyZ2nmgqJgSScqFJWFNqcz6OIbwu8WaLpzUeIIyrz5AS-3zLYKBe2-QLXEmEXroOBGGeOnlwgenHnoxtOP3wgBFwo8rMFeGhRQQk50VbrrkZ-QtG5eK2n9fHfW25xLL2UtmOrWAxhY-gQYBelFkkYUgxwebM061cy7K8HBS3mSihfQpgT0blB~DCloz9tjLCUnXYPMkq3oGldybwRC3H87Zii08rwJIKLiQHFMDPaZaUDl-yX9l1JDCQ__') 0 0 repeat;
        background-repeat: no-repeat;
        transform: rotate(-25deg);
    }

    h1 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    label {
        display: block;
        margin-top: 10px;
        font-size: 14px;
        color: #555;
    }

    input[type="email"],
    input[type="password"] {
        width: 80%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        margin: 10px auto;
    }

    button[type="submit"] {
        background-color: #0fc20c;
        color: white;
        border: none;
        padding: 10px 20px;
        margin-top: 15px;
        cursor: pointer;
        font-weight: 900;
        width: 200px;
    }

    button[type="submit"]:hover {
        background-color: #45a049;
    }

    .options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-top: 15px;
    }

    .options a {
        background-color: #ddd;
        padding: 5px 10px;
        border-radius: 4px;
        text-decoration: none;
        color: #333;
    }

    .options a:hover {
        background-color: #eee;
    }

    .forgot-password {
        font-size: 14px;
        color: #555;
        margin-top: 15px;
        text-align: center;
    }

    .forgot-password:hover {
        text-decoration: underline;
    }

    .signup {
        font-size: 14px;
        color: #555;
        margin-top: 20px;
        text-align: center;
    }

    .signup a {
        color: #4CAF50;
        text-decoration: none;
    }

    .social-button {
        background-position: 25px 0px;
        cursor: pointer;
        display: inline-block;
        height: 50px;
        line-height: 50px;
        text-align: left;
        text-decoration: none;
        vertical-align: middle;
        width: 100%;
        border-radius: 3px;
        margin: 10px auto;
        outline: rgb(255, 255, 255) none 0px;
        padding-left: 20%;

    }

    #facebook-connect {
        background: url('https://upload.wikimedia.org/wikipedia/commons/archive/1/1b/20140221023021%21Facebook_icon.svg') no-repeat scroll 15px 5px / 40px 40px padding-box border-box;
        border: solid 1px #b3b3b3;
        border-radius: 3px;
        width: 80%;
        ;
    }

    #facebook-connect span {
        box-sizing: border-box;
        color: #808080;
        cursor: pointer;
        font-weight: bold;
        font-size: 18px;
        font-family: 'Roboto', sans-serif;
        text-align: center;

    }

    #google-connect {
        background: url('https://upload.wikimedia.org/wikipedia/commons/archive/c/c1/20210618182605%21Google_%22G%22_logo.svg') no-repeat scroll 15px 5px / 40px 40px padding-box border-box;
        border: solid 1px #b3b3b3;
        border-radius: 3px;
        width: 80%;
        ;
    }

    #google-connect span {
        box-sizing: border-box;
        color: #808080;
        cursor: pointer;
        font-weight: bold;
        font-size: 18px;
        font-family: 'Roboto', sans-serif;
        text-align: center;

    }

    #wechat-connect {
        background: url('https://seeklogo.com/images/W/wechat-logo-24CA7667E7-seeklogo.com.png') no-repeat scroll 15px 5px / 40px 40px padding-box border-box;
        border: solid 1px #b3b3b3;
        border-radius: 3px;
        width: 80%;
    }

    #wechat-connect span {
        box-sizing: border-box;
        color: #808080;
        cursor: pointer;
        font-weight: bold;
        font-size: 18px;
        font-family: 'Roboto', sans-serif;
        text-align: right;

    }
</style>