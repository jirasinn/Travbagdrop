<?php
// require_once('libs/connect.class.php');
$db = new ConnectDb();
$conn = $db->getConn();
// Check if member ID is set in session
if (isset($_GET['id'])) {
    // Check if form is submitted
    if (isset($_POST['submit'])) {

        // Get form data
        $m_fname = $_POST['m_fname'];
        $m_lname = $_POST['m_lname'];
        $m_ctry = $_POST['m_ctry'];
        $m_phone = $_POST['m_phone'];
        $m_email = $_POST['m_email'];

        // Get member ID from session
        $member_id = $_GET['id'];

        // Initialize SQL string
        $sql = "UPDATE register SET m_fname = '$m_fname', m_lname = '$m_lname', m_ctry = '$m_ctry', m_phone = '$m_phone' ";

        // Check if the email input field is not empty
        if (!empty($m_email)) {
            $sql .= ", m_email = '$m_email'";
        }

        // Append WHERE clause to specify the row to update
        $sql .= " WHERE m_id = $member_id";

        // Update the database
        if (mysqli_query($conn, $sql)) {
            echo "<script>";
            echo "alert('สมัครสำเร็จ');";
            echo "window.location='/travbagdrop/?page=home';";
            echo "</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
} else {
    echo "Member ID is not set in session.";
}
?>


    <div class="background">
        <div class="container">
            <div style="height: 10px; border-radius: 0 0 10px 10px; background-color: #f4f71b; margin:-20px -20px 20px -20px;"></div>
            <center>
                <h2 style="font-weight: bold; color: black;">กรุณากรอกข้อมูลเพิ่มเติม</h2>
            </center>

            <form method="post" enctype="multipart/form-data" action="" onsubmit="return checkIfNotBot();">

                <input type="text" name="m_fname" class="rounded-button" placeholder="ชื่อ" required><br><br>


                <input type="text" name="m_lname" class="rounded-button" placeholder="นามสกุล" required><br><br>


                <!-- <label class="form-label">country/ประเทศ</label> -->
                <select name="m_ctry" id="m_ctry" class="rounded-button" required>
                    <option value="">country/ประเทศ</option>
                    <?php
                    $db = new ConnectDb();
                    $conn = $db->getConn();

                    $sql = "SELECT * FROM tbl_country";
                    $result = mysqli_query($conn, $sql);

                    // วนลูปแสดงตัวเลือกคณะ
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['ct_code'] . "'>" . $row['ct_nameTHA'] . "</option>";
                    }
                    // ปิดการเชื่อมต่อฐานข้อมูล
                    mysqli_close($conn);
                    ?>
                </select><br><br>

                <input type="number" name="m_phone" maxlength="10" class="rounded-button" placeholder="เบอร์โทรศัพท์" required> <br><br>

                <input type="text" name="m_email" class="rounded-button" placeholder="อีเมลล์">
                <div style="text-align:left; margin-top: 5px;">
                    <small class="text-danger note" style="margin-left: 140px;">หมายเหตุ:
                        กรอกอีเมลกรณีที่ไม่ได้ผูกอีเมล</small>
                </div>

                <br><br>

                <center><input type="submit" name="submit" value="สมัครสมาชิก" class="rounded-button2"></center> <br>
                <div class="g-recaptcha" data-sitekey="6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC" align='center'></div>

            </form>
        </div>
    </div>


<style>
    .rounded-button {
        display: inline-block;
        padding: 10px 5px;
        color: black;
        text-align: left;
        text-decoration: none;
        border-radius: 5px;
        border: solid 1px #bfbfbf;
        cursor: pointer;
        font-size: 14px;
        width: 100%;
        height: 55px;
    }


    .rounded-button2 {
        background-color: #0fc20c;
        color: white;
        border: none;
        padding: 10px 20px;
        margin-top: 15px;
        cursor: pointer;
        font-weight: 900;
        width: 200px;
    }


    .profile-picture {
        opacity: 0.75;
        height: 120px;
        width: 120px;
        border-radius: 50%;
        position: relative;
        overflow: hidden;
        margin: 10px 0 10px 0;

        background-color: #faf5f5;
        border: solid 1px #d9d9d9;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }



    .file-uploader {
        /* make it invisible */
        opacity: 0;
        /* make it take the full height and width of the parent container */
        height: 100%;
        width: 100%;
        cursor: pointer;
        /* make it absolute */
        position: absolute;
        top: 0%;
        left: 0%;
    }



    .upload-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        /* initial icon state */
        opacity: 0;
        transition: opacity 0.3s ease;
        color: #ccc;
        -webkit-text-stroke-width: 2px;
        -webkit-text-stroke-color: #bbb;
    }

    /* toggle icon state */
    .profile-picture:hover .upload-icon {
        opacity: 1;
    }

    .background {
        position: relative;
        overflow: hidden;
    }

    .background::before {
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        top: 40%;
        left: 10%;
        z-index: -1;
        background: url('https://s3-alpha-sig.figma.com/img/a2e3/59ad/c8e3e7ac163a3e1d4298219605114df0?Expires=1709510400&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=Mwqa11pFmXUR6vEvQgFGuYkDqzZgITN0nNUCz0C-T42q2blNAUMK37HfQYpCrtuI4hZ58adKflDCTv2xpjUc7Dq5fJ8x0vmyZ2nmgqJgSScqFJWFNqcz6OIbwu8WaLpzUeIIyrz5AS-3zLYKBe2-QLXEmEXroOBGGeOnlwgenHnoxtOP3wgBFwo8rMFeGhRQQk50VbrrkZ-QtG5eK2n9fHfW25xLL2UtmOrWAxhY-gQYBelFkkYUgxwebM061cy7K8HBS3mSihfQpgT0blB~DCloz9tjLCUnXYPMkq3oGldybwRC3H87Zii08rwJIKLiQHFMDPaZaUDl-yX9l1JDCQ__') 0 0 repeat;
        background-repeat: no-repeat;
        transform: rotate(-25deg);
    }

    .container {
        display: flex;
        flex-direction: column;
        width: 500px;
        padding: 20px;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 50px auto;
    }
</style>

</html>