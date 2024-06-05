<?php session_start() ?>


<?php
include('../libs/connect.class.php');
if (isset($_POST["verify"])) {
    $otp = $_SESSION['otp'];
    $otp_code = $_POST['otp_code'];
    $b_id = $_SESSION['bag'];

    if ($otp != $otp_code) {
?>
        <script>
            alert("Invalid OTP code");
        </script>
    <?php
    } else {
        mysqli_query($connect, "UPDATE bagreserv SET status = 'คืนสำเร็จ' WHERE bag_id = '$b_id'");
    ?>
        <script>
            // Close the OTP modal
            var otpModal = window.parent.document.getElementById("otp-modal");
            otpModal.style.display = "none";
            window.parent.location.reload();
            alert("OTP verification successful");
        </script>
<?php
    }
}

?>