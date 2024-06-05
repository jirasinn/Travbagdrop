<?php
session_start();
require_once("../libs/connect.class.php");
$db = new ConnectDb();
$conn = $db->getConn();

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $m_email = $_POST['m_email'];
    $m_fname = $_POST['m_fname'];
    $m_lname = $_POST['m_lname'];
    $m_password1 = $_POST['m_password1'];
    $m_password2 = $_POST['m_password2'];
    $m_phone = $_POST['m_phone'];
    $m_ctry = $_POST['m_ctry'];
    $current_date = date('Y-m-d H:i:s');

    $urole = "member";

    $errorMsg = '';

    // Check if email already exists in the database
    $checkEmailQuery = "SELECT * FROM register WHERE m_email = '$m_email'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $_SESSION['error'] = 'อีเมลนี้ถูกใช้งานแล้ว';
        echo "<script>";
        echo "alert('" . $_SESSION['error'] . "');";
        echo "window.location='../?page=register.m';";
        echo "</script>";
        exit;
    }

    // Validate form data
    if (empty($m_email)) {
        $errorMsg .= 'กรุณากรอกอีเมล<br>';
    }
    if (empty($m_fname)) {
        $errorMsg .= 'กรุณากรอกชื่อ<br>';
    }
    if (empty($m_lname)) {
        $errorMsg .= 'กรุณากรอกนามสกุล<br>';
    }
    if (empty($m_phone)) {
        $errorMsg .= 'กรุณากรอกเบอร์โทร<br>';
    }
    if (empty($m_password1)) {
        $errorMsg .= 'กรุณากรอกรหัสผ่าน';
    } elseif (strlen($m_password1) < 6 || strlen($m_password1) > 10) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษรและไม่เกิน 10 ตัวอักษร';
    }

    if (empty($m_password2)) {
        $errorMsg .= 'กรุณากรอกรหัสผ่านอีกครั้ง<br>';
    } elseif (strlen($m_password2) < 6 || strlen($m_password2) > 10) {
        $errorMsg .= 'รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร';
    }

    // Check if there are any errors
    if (!empty($errorMsg)) {
        $_SESSION['error'] = $errorMsg;
        echo "<script>";
        echo "alert('" . $_SESSION['error'] . "');"; // Display error message
        echo "window.location='../?page=register.m';";
        echo "</script>";
        exit;
    } elseif (!filter_var($m_email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
        echo "<script>";
        echo "alert('" . $_SESSION['error'] . "');"; // แสดงข้อความผิดพลาดด้วย alert()
        echo "window.location='../?page=register.m';";
        echo "</script>";
        exit;
    } elseif ($m_password1 !== $m_password2) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่านให้ตรงกัน';
        echo "<script>";
        echo "alert('" . $_SESSION['error'] . "');"; // แสดงข้อความผิดพลาดด้วย alert()
        echo "window.location='../?page=register.m';";
        echo "</script>";
        exit;
    }


    // Hash the password
    $hashed_password = password_hash($m_password1, PASSWORD_DEFAULT);

    if (isset($_FILES['usr_img'])) {
        $usr_upload_directory =  '../images/usr_img/';
        // File data for idcard
        $usr_file_name = $_FILES['usr_img']['name'];
        $usr_file_tmp_name = $_FILES['usr_img']['tmp_name'];

        // Move the file to the desired directory
        if (move_uploaded_file($usr_file_tmp_name, $usr_upload_directory . $usr_file_name)) {

            $sql = "INSERT INTO `register` (`m_fname`, `m_lname`, `m_ctry`,  `m_phone`, `m_email`, `m_password`, `urole`,`usr_img`,`registered`,`method` ) 
            VALUES ('$m_fname', '$m_lname', '$m_ctry','$m_phone','$m_email', '$hashed_password', '$urole','$usr_file_name', '$current_date', 'bagdrop')";


            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>";
                echo "alert('สมัครสำเร็จ');";
                echo "window.location='../?page=login';";
                echo "</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('No files were uploaded');</script>";
        }
    }
}
