<div class="background">
    <div class="container">
        <h1>เปลี่ยนรหัสผ่านใหม่</h1>

        <form action="#" method="POST" name="resetpass">

            <input type="password" id="password" name="new_password" class="rounded-button" placeholder="รหัสผ่านใหม่"
                required autofocus>

            <i class="bi bi-eye-slash" id="togglePassword"></i>
            <br>

            <input type="password" id="confirm_password" name="confirm_password" class="rounded-button"
                placeholder="ยืนยันรหัสผ่านใหม่" required>
            <i class="bi bi-eye-slash" id="togglePassword"></i>
            <br>

            <small class="text-danger"><span class="note">หมายเหตุ: รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10
                    ตัวอักษร</span></small>
            <br>
            <div class="col-md-6 offset-md-4">
                <button type="submit" name="reset" require>ยืนยัน</button>
                </div>

        </form>


    </div>
</div>


<?php
if (isset($_POST["reset"])) {
    $db = new ConnectDb();
    $conn = $db->getConn();
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    $errorMsg = ""; 
    
    if (strlen($new_password) < 6 || strlen($new_password) > 10) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร';
    }

    if ($new_password !== $confirm_password) {
        $errorMsg .= 'รหัสผ่านและการยืนยันรหัสผ่านไม่ตรงกัน';
    }

    if (empty($errorMsg)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    
        $email = $_SESSION['m_email'];
    
        $sql_market = "SELECT * FROM market WHERE mk_email='$email'";
        $result_market = mysqli_query($conn, $sql_market);
        $row_market = mysqli_fetch_assoc($result_market);
    
        $sql_register = "SELECT * FROM register WHERE m_email='$email'";
        $result_register = mysqli_query($conn, $sql_register);
        $row_register = mysqli_fetch_assoc($result_register);
    
        if ($row_market) {
            $update_query = "UPDATE market SET mk_password='$hashed_password' WHERE mk_email='$email'";
            mysqli_query($conn, $update_query);
            ?>
            <script>
                alert("<?php echo "เปลี่ยนรหัสผ่านสำเร็จ" ?>");
                window.location.replace("?page=login");
            </script>
            <?php
        } elseif ($row_register) {
            $update_query = "UPDATE register SET m_password='$hashed_password' WHERE m_email='$email'";
            mysqli_query($conn, $update_query);
            ?>
            <script>
                alert("<?php echo "เปลี่ยนรหัสผ่านสำเร็จ" ?>");
                window.location.replace("?page=login");
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("<?php echo "โปรดลองใหม่อีกครั้ง" ?>");
                window.location.replace("?page=newpass");
            </script>
            <?php
        }
    }}


?>

<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function () {
        if (password.type === "password") {
            password.type = 'text';
        } else {
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>

<style>
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
        padding: 90px;
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

    input[type="text"],
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
</style>