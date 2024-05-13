<form action="" method="post">
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php } ?>

    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card" style="background-color: #12132B; color: white; border-radius: 1rem;">

                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase text-white">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="อีเมล" name="m_email"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="รหัสผ่าน" require
                                        name="m_password">
                                </div>
                                <button type="submit" name="login" class="btn btn-warning text-white"
                                    require>login</button>
                                <a href='javascript:window.history.back()' class="btn btn-danger">back</a>
</form>
<div class="d-flex justify-content-center text-center mt-4 pt-1">
    <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
    <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg mx-4 px-2"></i></a>
    <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
</div>

</div>

<!-- data-bs-toggle="modal" data-bs-target="#register" -->
<div>
    <p class="mb-0">ยังไม่มีบัญชีใช่ไหม?
        <a class="text-white-50 fw-bold" onclick="showPopup()" href="#">สมัครที่นี่</a>
    </p>

</div>

</div>
</div>
</div>
</div>
</div>
</section>

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
</style>