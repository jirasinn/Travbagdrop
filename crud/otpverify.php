<?php session_start(); ?>

<?php
if (isset($_POST["return_bag"])) {
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $m_email = $_POST['m_email'];
    $b_id = $_POST['b_id'];
    $_SESSION['bag'] = $b_id;
    require "../Mail/phpmailer/PHPMailerAutoload.php";
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';

    $mail->Username = '*******@msu.ac.th';
    $mail->Password = '******';

    $mail->setFrom('63010912564@msu.ac.th', 'OTP Verification');
    $mail->addAddress($_POST["m_email"]);

    $mail->isHTML(true);
    $mail->Subject = "Your OTP code";
    $mail->Body = "<p>Dear user, </p> <h3>Your verify OTP code is $otp <br></h3>
    <br><br>
    <p>With regrads,</p>";

    if (!$mail->send()) {
?>
        <script>
            alert("<?php echo " Invalid Email " ?>");
        </script>
<?php
    }
}
?>
