<?php
$isSubmitted = isset($_POST["login"]);
if ($isSubmitted) {
    $db = new ConnectDb();
    $conn = $db->getConn();
    $password = $_POST['password'];
    $email = $_POST['email'];

    // เพิ่มการเข้าสู่ระบบโดยอิงข้อมูลจากตาราง market
    $sql_market = "SELECT * FROM market 
    WHERE mk_email='$email' and status = 'approve'";
    $result_market = mysqli_query($conn, $sql_market);
    $fetch_market = mysqli_fetch_assoc($result_market); // รับค่าจากการเช็คในตาราง market

    if ($fetch_market && password_verify($password, $fetch_market['mk_password'])) {
        // เข้าสู่ระบบสำเร็จ
        $_SESSION['bagdrop_member_id'] = $fetch_market['mk_id'];
        $_SESSION['bagdrop_member_name'] = $fetch_market['mk_name'];

        $_SESSION['bagdrop_member_fname1'] = $fetch_market['mk_fname1'];
        $_SESSION['bagdrop_member_lname1'] = $fetch_market['mk_lname1'];
        $_SESSION['bagdrop_member_phone1'] = $fetch_market['mk_phone1'];

        $_SESSION['bagdrop_member_fname2'] = $fetch_market['mk_fname2'];
        $_SESSION['bagdrop_member_lname2'] = $fetch_market['mk_lname2'];
        $_SESSION['bagdrop_member_phone2'] = $fetch_market['mk_phone2'];

        $_SESSION['bagdrop_member_id_email'] = $fetch_market['mk_email'];

        $_SESSION['bagdrop_member_id_type'] = $fetch_market['urole'];

        // ส่งไปยังหน้า partner_home หากเข้าสู่ระบบสำเร็จ
        echo "<script>window.location='?page=partner_home';</script>";
        exit();
    } else {
        // ไม่สามารถเข้าสู่ระบบได้
        $_SESSION['error'] = "อีเมลหรือรหัสผ่านไม่ถูกต้อง";
        echo "<script>window.location='?page=login_partner';</script>";
        exit();
    }
    } else {
        // ไม่พบข้อมูลในตาราง market หรือรหัสผ่านไม่ถูกต้อง
   
}
?>



            <form action="" method="post">
<center>
    <div style=" height:100vh;  background: linear-gradient(to bottom right, #121138, #424870);">
    <br><br>
        <img src="images/loginbg.png" style="width:550px; height:200px; padding: 10px;" alt="">
        <br><br><br>
        <h3 style="color: white;">Partner Login</h3><br>

        <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" style="width: 30%;" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>

        <input class="admin-input" type="email" name="email" autofocus placeholder="อีเมล"><br>
        <input class="admin-input" type="password" name="password" placeholder="รหัสผ่าน"><br><br>
        <button class="admin-btn" type="submit" name="login">เข้าสู่ระบบ</button>
    </div>
</center>
            </form>
<style>
    .admin-input {
        width: 30%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 10px;
        box-sizing: border-box;
        border: none;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        background-color: white;
    }

    .admin-btn {
        display: inline-block;
        height: 50px;
        width: 150px;
        background-color: #ff0000;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;

    }



    .admin-btn:hover {
        background-color: #419ba3;
    }
</style>