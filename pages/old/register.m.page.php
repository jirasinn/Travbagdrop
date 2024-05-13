<div class="container">
    <main>
        <div class="py-5 text-center">
            <h2>CREATE ACCOUNT</h2>
        </div>
        <div class="row">
            <div class="col-md-3">

            </div>

        </div>



        <div class="container">
            <main>
                <div class="py-5 text-center">
                    <h2>OR</h2>
                </div>
                <div class="row">
                    <div class="col-md-3">

                    </div>

                </div>

                <form method="post" action="crud/regissuc.m.php" onsubmit="return checkIfNotBot();">
                    <input type="text" name="m_fname" class="form-control" placeholder="First Name/ชื่อ" required><br>

                    <input type="text" name="m_lname" class="form-control" placeholder="Last Name/นามสกุล" required><br>

                    <input type="number" name="m_passport" maxlength="20" class="form-control"
                        placeholder="Passport/เลขบัตรประชาชน" required> <br>
                    <!--  -->

                    <!--  -->
                    <div class="mb-3" id="m_ctry_section">
                        <!-- <label class="form-label">country/ประเทศ</label> -->
                        <select name="m_ctry" id="m_ctry" required>
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
                        </select>
                    </div>
                    <!--  -->


                    <input type="number" name="m_phone" maxlength="10" class="form-control" placeholder="Phone/เบอร์โทร"
                        required> <br>

                    <input type="text" name="m_email" class="form-control" placeholder="Email Address" required> <br>

                    <input type="password" name="m_password1" class="form-control" placeholder="Password/รหัสผ่าน"
                        required> <small class="text-danger"><span class="note">หมายเหตุ: รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร</span></small>
                        <br><br>

                    <input type="password" class="form-control" name="m_password2"
                        placeholder="ยืนยัน Password/รหัสผ่าน" required>
                    <br>

                    <div class="g-recaptcha" data-sitekey="6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC" align='center'></div>

                    <input type="submit" name="submit" value="บันทึก" class="btn btn-primary"> <br>

                </form>



        </div>

</div>

<!--  -->
<script>
    function checkIfNotBot() {
        // ตรวจสอบว่า reCAPTCHA ถูกติ๊กหรือไม่
        var response = grecaptcha.getResponse();

        if (response.length !== 0) {
            // ถ้าติ๊กที่ reCAPTCHA แล้ว
            // ตรวจสอบบอทโดยใช้ reCAPTCHA Verification API
            verifyCaptcha(response);
        } else {
            // ถ้าไม่ติ๊กที่ reCAPTCHA
            alert('กรุณายืนยันว่าท่านไม่ใช่บอท');
            return false; // ไม่ส่งแบบฟอร์ม
        }
    }

    function verifyCaptcha(response) {
        // ทำการส่ง request ไปยัง Google reCAPTCHA Verification API
        fetch('https://www.google.com/recaptcha/api/siteverify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `secret=6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC&response=${response}`,
        })
            .then(response => response.json())
            .then(data => {
                // ตรวจสอบค่า success จาก response
                if (data.success) {
                    // ถ้าเป็นบอทจะไม่ทำการ submit ฟอร์ม
                    alert('คุณไม่ใช่บอท ยินดีต้อนรับ!');
                    // หรือสามารถทำการ submit ฟอร์มต่อได้
                    document.getElementById('registration-form').submit();
                } else {
                    // ถ้าเป็นบอทจะแสดง alert และไม่ทำการ submit ฟอร์ม
                    alert('คุณอาจเป็นบอท กรุณาลองใหม่');
                }
            })
            .catch(error => console.error('Error:', error));

        return false; // ไม่ส่งแบบฟอร์ม
    }
</script>
