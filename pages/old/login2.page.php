<?php
require_once('line/LineLogin.php');
?>

 <div class="background">  
<div class="container">
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
    <a href="#" class="social-button" id="facebook-connect"> <span>เข้าสู่ระบบด้วย Facebook</span></a>
    <a href="#" class="social-button" id="google-connect"> <span>เข้าสู่ระบบด้วย Google</span></a>
     
     <?php 
            if (!isset($_SESSION['profile'])) {
                $line = new LineLogin();
                $link = $line->getLink();
                $profile = $_SESSION['profile'];
                
        ?>
    <a href="<?php echo $link; ?>" class="social-button" id="line-connect"> <span>เข้าสู่ระบบด้วย Line</span></a>
    <?php }  ?> 
    
    <a href="#" class="social-button" id="wechat-connect"> <span>เข้าสู่ระบบด้วย Wechat</span></a>

    
    <h1>หรือ</h1>   
                                                             
    <input type="email"  placeholder="อีเมล" name="m_email" required>
    <input type="password"  placeholder="รหัสผ่าน" require name="m_password">
        <p class="forgot-password">ลืมรหัสผ่านใช่หรือไม่?</p>
                                <button type="submit" name="login" 
                                    require>เข้าสู่ระบบ</button>
                    <p class="signup" onclick="showPopup()" >ยังไม่ได้เป็นสมาชิก? <a href="#">Sign up</a></p>                   

                </form>
    </center>
    
</div>
</div>  

<!-- data-bs-toggle="modal" data-bs-target="#register" -->




<?php
if (isset($_POST['login'])) {
    $db = new ConnectDb();
    $conn = $db->getConn();

    $m_password = $_POST['m_password'];

    $email = $_POST['m_email'];

    $sql = "SELECT * FROM register WHERE m_email='$email' AND m_password='" . md5($m_password) . "'";

    $rs = mysqli_query($conn, $sql);
    $data = mysqli_num_rows($rs);

    if ($data = mysqli_fetch_array($rs)) {
        // print_r($data);

        $_SESSION['bagdrop_member_id'] = $data['m_id'];
        $_SESSION['bagdrop_member_fname'] = $data['m_fname'];
        $_SESSION['bagdrop_member_lname'] = $data['m_lname'];
        $_SESSION['bagdrop_member_id_email'] = $data['m_email'];
        $_SESSION['bagdrop_member_id_type'] = $data['urole'];

        echo '<script>window.location.href="?page=home";</script>';

    } else {
        $_SESSION['error'] = "กรุณากรอกข้อมูลผู้ใช้ให้ถูกต้อง";
        echo '<script>window.location.href="?page=login";</script>';
    }
}
?>
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
        color: black;


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
background-color: #f4f71bff;
width: 80%;
padding: 10px;
margin-top: 5px;
border: 1px solid #ccc;
border-radius: 15px;
margin: 10px auto;
}

button[type="submit"] {
background-color: #f4f71bff;
color: black;
border: none;
padding: 10px 20px;
margin-top: 15px;
border-radius: 15px;
cursor: pointer;
font-weight: bold;
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
    box-sizing: border-box;
    color: rgb(255, 255, 255);
    cursor: pointer;
    display: inline-block;
    height: 50px;
	  line-height: 50px;
    text-align: left;
    text-decoration: none;
    text-transform: uppercase;
    vertical-align: middle;
    width: 100%;
	  border-radius: 3px;
    margin: 10px auto;
    outline: rgb(255, 255, 255) none 0px;
    padding-left: 20%;

}

#facebook-connect {
    background: rgb(244, 247, 27) url('https://upload.wikimedia.org/wikipedia/commons/archive/1/1b/20140221023021%21Facebook_icon.svg') no-repeat scroll 15px 5px / 40px 40px padding-box border-box;
    border-radius: 15px;
    width: 80%;
    ;
}




#facebook-connect span {
	  box-sizing: border-box;
    color: black;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
}



#google-connect {
    background: rgb(244, 247, 27) url('https://upload.wikimedia.org/wikipedia/commons/archive/c/c1/20210618182605%21Google_%22G%22_logo.svg') no-repeat scroll 15px 5px / 40px 40px padding-box border-box;
    border-radius: 15px;
    width: 80%;
    ;
}



#google-connect span {
	  box-sizing: border-box;
    color: black;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
}

#line-connect {
    background: rgb(244, 247, 27) url('https://upload.wikimedia.org/wikipedia/commons/4/41/LINE_logo.svg') no-repeat scroll 15px 5px / 40px 40px padding-box border-box;
    border-radius: 15px;
    width: 80%;
}



#line-connect span {
    box-sizing: border-box;
    color: black;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
}

#wechat-connect {
    background: rgb(244, 247, 27) url('https://seeklogo.com/images/W/wechat-logo-24CA7667E7-seeklogo.com.png') no-repeat scroll 15px 5px / 40px 40px padding-box border-box;
    border-radius: 15px;
    width: 80%;
}



#wechat-connect span {
    box-sizing: border-box;
    color: black;
    cursor: pointer;
    font-weight: bold;
    text-align: center;
    text-transform: uppercase;
}

