<?php
$isSubmitted = isset($_POST["submit"]);

if ($isSubmitted) {
    $db = new ConnectDb();
    $conn = $db->getConn();
    $email = $_POST["m_email"];

    $sql_market = mysqli_query($conn, "SELECT * FROM market WHERE mk_email='$email'");
    $query_market = mysqli_num_rows($sql_market);

    $sql_register = mysqli_query($conn, "SELECT * FROM register WHERE m_email='$email'");
    $query_register = mysqli_num_rows($sql_register);

    if ($query_market <= 0 && $query_register <= 0) {
?>
        <script>
            alert("<?php echo "ไม่มีอีเมลนี้อยู่ในระบบ" ?>");
        </script>
        <?php
    } else {
        // generate token by binaryhexa 
        $token = bin2hex(random_bytes(50));

        //session_start ();
        $_SESSION['token'] = $token;
        $_SESSION['m_email'] = $email;

        require "Mail/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        // h-hotel account
        $mail->Username = '63010912564@msu.ac.th';
        $mail->Password = 'aaaa094276';

        // send by h-hotel email
        $mail->setFrom('63010912564@msu.ac.th', 'Password Reset');
        // get email from input
        $mail->addAddress($_POST["m_email"]);


        // HTML body
        $mail->isHTML(true);
        $mail->Subject = "Recover your password";
        $mail->Body = "<b>Dear User</b>
                <h3>We received a request to reset your password.</h3>
                <p>Kindly click the below link to reset your password</p>
                http://localhost/Travbagdrop/?page=resetpass
                <br><br>
                <p>With regrads,</p>
                <b>Bagdrop </b>";

        if (!$mail->send()) {
        ?>
            <script>
                // Display modal with error message
                document.getElementById('modal-text').innerHTML = 'Email could not be sent! Please try again later.';
                document.getElementById('myModal').style.display = 'block';
            </script>
        <?php
        } else {
        ?>
            <script>
                // Display modal with success message
                document.getElementById('modal-text').innerHTML = 'Email sent out! Kindly check your email inbox.';
                document.getElementById('myModal').style.display = 'block';
            </script>
<?php
        }
    }
}


?>

<!-- modal -->
<div class="background">
    <div class="container">
        <h1>ลืมรหัสผ่าน</h1>

        <form action="#" method="POST" name="recover_psw">
            <input type="email" placeholder="อีเมล" name="m_email" required>

            <div class="col-md-6 offset-md-4">
                <button type="submit" name="submit">ยืนยัน</button>
            </div>

        </form>

    </div>
</div>

<!-- Modal Structure -->
<div id="myModal" class="modal" style="display:none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; text-align: center; border-radius: 10px;">
        <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        <p id="modal-text" style="font-size: 18px;">Some text in the Modal..</p>
        <button id="confirmButton">ตกลง</button>
    </div>
</div>

<script>
    // Check if email is valid or not
    <?php if ($isSubmitted) : ?>
        <?php if (!$mail->send()) : ?>
            // Display modal with error message
            document.getElementById('modal-text').innerHTML = 'Invalid Email';
            document.getElementById('myModal').style.display = 'block';
        <?php else : ?>
            // Display modal with success message
            document.getElementById('modal-text').innerHTML = 'Success Message<br>Email send out! Kindly check your email inbox.';
            document.getElementById('myModal').style.display = 'block';
        <?php endif; ?>
    <?php endif; ?>

    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Get the confirm button
    var confirmButton = document.getElementById("confirmButton");

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks on confirm button, close the modal
    confirmButton.onclick = function() {
        modal.style.display = "none";
    }

    modal.addEventListener('click', function(event) {
        if (!event.target.closest('.modal-content')) {
            event.stopPropagation(); // Prevent event from bubbling to elements outside of the modal
        }
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<!-- end modal -->
<!-- css -->
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
        padding: 140px;
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
    input[type="email"],
    input[type="password"] {
        background-color: #f4f71bff;
        width: 100%;
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

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    /* Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Close Button Area */
    .modal-header {
        padding: 15px;
        border-bottom: 1px solid #ddd;
    }

    /* Modal Body */
    .modal-body {
        padding: 15px;
    }

    /* Modal Footer */
    .modal-footer {
        padding: 15px;
        text-align: right;
    }

    #confirmButton {
        background-color: #121139;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /*End Modal Content */
</style>