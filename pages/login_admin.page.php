<?php
$isSubmitted = isset($_POST["login"]);
if ($isSubmitted) {
    $db = new ConnectDb();
    $conn = $db->getConn();
    $password = $_POST['password'];
    $admin_id = $_POST['admin_id'];
    $Ad_rank = $_POST['rank'];
    echo "ค่า rank ที่ส่งไปคือ: " ;
    // เพิ่มการเข้าสู่ระบบโดยอิงข้อมูลจากตาราง market
    $sql_register = "SELECT * FROM register WHERE admin_id = '$admin_id' And urole = 'admin' And Ad_rank = '$Ad_rank'";

    $rs_register = mysqli_query($conn, $sql_register);
    $data_register = mysqli_fetch_assoc($rs_register);

    if ($data_register && password_verify($password, $data_register['m_password'])) {
        // เข้าสู่ระบบสำเร็จ
        $_SESSION['bagdrop_member_id'] = $data_register['m_id'];
        $_SESSION['bagdrop_member_fname'] = $data_register['m_fname'];
        $_SESSION['bagdrop_member_lname'] = $data_register['m_lname'];
        $_SESSION['bagdrop_member_admin_id'] = $data_register['admin_id'];
        $_SESSION['bagdrop_member_id_type'] = $data_register['urole'];
        $_SESSION['bagdrop_member_Ad_rank'] = $data_register['Ad_rank'];

        echo "<script>window.location='?page=admin';</script>";
        exit();

    } else {
        // ไม่สามารถเข้าสู่ระบบได้
        $_SESSION['error'] = "อีเมลหรือรหัสผ่านไม่ถูกต้อง" . $Ad_rank;
        echo "<script>window.location='?page=login_admin';</script>";
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
        <h3 style="color: white;">Admin Login</h3><br>

        <?php if (isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" style="width: 30%;" role="alert">
                    <?php
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
   
            <select class="admin-input" name="rank">
                <option value="Super Admin">Super Admin</option>
                <option value="Admin2">Admin2</option>
                <option value="Admin3">Admin3</option>
            </select>
        <br>

        <input class="admin-input" type="admin_id" name="admin_id" autofocus placeholder="ไอดีแอดมิน"><br>
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