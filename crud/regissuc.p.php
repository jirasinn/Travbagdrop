<?php
session_start();
require_once("../libs/connect.class.php");
$db = new ConnectDb();
$conn = $db->getConn();

if (isset($_POST["submit"])) {


    $mk_email = $_POST['mk_email'];

    $mk_name = $_POST['mk_name'];
    $mk_code = $_POST['mk_code'];
    $location = $_POST['location'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $mk_phone = $_POST['mk_phone'];
    $mk_fname1 = $_POST['mk_fname1'];
    $mk_lname1 = $_POST['mk_lname1'];
    $mk_phone1 = $_POST['mk_phone1'];
    $mk_fname2 = $_POST['mk_fname2'];
    $mk_lname2 = $_POST['mk_lname2'];
    $mk_phone2 = $_POST['mk_phone2'];
    // $mk_email = $_POST['mk_email'];
    $mk_password1 = $_POST['mk_password1'];
    $mk_password2 = $_POST['mk_password2'];
    $urole = "partner";
    $status = "request";
    $errorMsg = '';

    // Check if email already exists
    $checkEmailQuery = "SELECT * FROM market WHERE mk_email = '$mk_email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if ($checkEmailResult) {
        if (mysqli_num_rows($checkEmailResult) > 0) {
            $errorMsg .= 'อีเมลนี้มีการใช้งานแล้ว<br>';
        }
    } else {
        // จัดการกรณีที่เกิดข้อผิดพลาดในการทำคิวรี
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการตรวจสอบอีเมล';
        header("location: ../?page=register.p");
        exit;
    }

    // Validate input fields   
    if (empty($mk_name)) {
        $errorMsg .= 'กรุณาระบุชื่อร้านค้า<br>';
    }
    if (empty($mk_code)) {
        $errorMsg .= 'กรุณากรอกหมายเลขสถานประกอบการ<br>';
    }
    if (empty($location)) {
        $errorMsg .= 'กรุณากรอกที่อยู่สถานประกอบการ<br>';
    }
    if (empty($latitude) || empty($longitude)) {
        $errorMsg .= 'ยังไม่ได้เลือกตำแหน่งร้านค้า<br>';
    }
    if (empty($mk_phone)) {
        $errorMsg .= 'กรุณากรอกเบอร์โทร<br>';
    }
    if (empty($mk_fname1) || empty($mk_lname1) || empty($mk_phone1)) {
        $errorMsg .= 'กรุณากรอกข้อมูลผู้มีอำนาจให้ครบ<br>';
    }

    if (empty($mk_email)) {
        $errorMsg .= 'กรุณากรอกอีเมล<br>';
    }

    if (empty($mk_password1)) {
        $errorMsg .= 'กรุณากรอกรหัสผ่าน';
    } elseif (strlen($mk_password1) < 6 || strlen($mk_password1) > 10) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษรและไม่เกิน 10 ตัวอักษร';
    }

    if (empty($mk_password2)) {
        $errorMsg .= 'กรุณากรอกรหัสผ่านอีกครั้ง<br>';
    } elseif (strlen($mk_password2) < 6 || strlen($mk_password2) > 10) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร';
    }

    if (!empty($errorMsg)) {
        $_SESSION['error'] = $errorMsg;
        header("location: ../?page=register.p");
        exit;
    } elseif (!filter_var($mk_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
        header("location: ../?page=register.p");
        exit;
    } elseif ($mk_password1 !== $mk_password2) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่านให้ตรงกัน';
        header("location: ../?page=register.p");
        exit;
    }

    // ส่งอีเมล OTP
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;

    require "../Mail/phpmailer/PHPMailerAutoload.php";
    $mail = new PHPMailer;

    // ตั้งค่า SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = '63010912564@msu.ac.th';
    $mail->Password = 'aaaa094276';

    $mail->setFrom('63010912564@msu.ac.th', 'OTP Verification');
    $mail->addAddress($_POST["mk_email"]);

    $mail->isHTML(true);
    $mail->Subject = "Your OTP code";
    $mail->Body = "<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
    <br><br>
    <p>With regards,</p>";
    // 
    if (!$mail->send()) {
        // จัดการกรณีที่ส่งอีเมลไม่สำเร็จ
        echo "<script>alert('Failed to send OTP email');</script>";
    } else {



        // Upload and validate images
        $fileD = "";
        $fileS = "";
        $fileM = "";

        if (!empty($_FILES["fileD"]["name"]) && !empty($_FILES["fileS"]["name"]) && !empty($_FILES["fileM"]["name"])) {
            $targetDir = "../images/market/";

            $fileD = basename($_FILES["fileD"]["name"]);
            $fileS = basename($_FILES["fileS"]["name"]);
            $fileM = basename($_FILES["fileM"]["name"]);

            $targetFilePathD = $targetDir . "documents/" . $fileD;
            $targetFilePathS = $targetDir . "store/" . $fileS;
            $targetFilePathM = $targetDir . $fileM;

            $fileTypeD = strtolower(pathinfo($targetFilePathD, PATHINFO_EXTENSION));
            $fileTypeS = strtolower(pathinfo($targetFilePathS, PATHINFO_EXTENSION));
            $fileTypeM = strtolower(pathinfo($targetFilePathM, PATHINFO_EXTENSION));

            $allowTypes = array('jpg', 'jpeg', 'png', 'gif');



            // 
            if (!in_array($fileTypeD, $allowTypes) || !in_array($fileTypeS, $allowTypes) || !in_array($fileTypeM, $allowTypes)) {
                $_SESSION['error'] = 'เฉพาะไฟล์รูปภาพประเภท JPEG, PNG, GIF เท่านั้น';
                header("location: ../?page=register.p");
            } else {
                if (move_uploaded_file($_FILES["fileD"]["tmp_name"], $targetFilePathD) && move_uploaded_file($_FILES["fileS"]["tmp_name"], $targetFilePathS) && move_uploaded_file($_FILES["fileM"]["tmp_name"], $targetFilePathM)) {
                    $hashed_password = password_hash($mk_password1, PASSWORD_DEFAULT);

                    $sqlInsertMarket = "INSERT INTO market (mk_name, mk_code, location, latitude, longitude, mk_phone, mk_fname1, mk_lname1, mk_phone1, mk_fname2, mk_lname2, mk_phone2, mk_email, mk_password, doc_img, store_img, mk_img , `urole`, status) 
                                    VALUES ('$mk_name','$mk_code','$location','$latitude', '$longitude', '$mk_phone', '$mk_fname1', '$mk_lname1', '$mk_phone1', '$mk_fname2', '$mk_lname2', '$mk_phone2', '$mk_email', '$hashed_password', '$fileD', '$fileS', '$fileM', '$urole', '$status')";
                }
                if (mysqli_query($conn, $sqlInsertMarket)) {
                    // echo "<script>";
                    // echo "alert('สมัครเป็นร้านค้าสำเร็จ');";
                    // echo "window.location='../?page=login';";
                    // echo "</script>";
                } else {
                    // กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
                    $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล';
                    header("location: ../?page=register.p");
                    exit;
                }
            }
        }
    }
}
