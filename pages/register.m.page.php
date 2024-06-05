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

</head>

<body>

    <div class="background">
        <div class="container">
            <div style="height: 10px; border-radius: 0 0 10px 10px; background-color: #f4f71b; margin:-20px -20px 20px -20px;"></div>
            <a href="/travbagdrop/?page=login"><img src="images/leftarrow.png" style="width:40px;height:40px; margin-bottom:10px;"></a>
            <center>
                <h2 style="font-weight: bold; color: black;">สมัครสมาชิก</h2>
            </center>

            <form method="post" enctype="multipart/form-data" action="crud/regissuc.m.php" onsubmit="return checkIfNotBot();">
                <center>
                    <div class="profile-picture">
                        <h1 class="upload-icon">
                            <i class="fa fa-plus " aria-hidden="true"></i>
                        </h1>
                        <input class="file-uploader" type="file" name="usr_img" onchange="upload()" accept="image/gif, image/jpeg, image/png" />
                    </div>

                </center>
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

                <input type="text" name="m_email" class="rounded-button" placeholder="อีเมลล์" required>
                <br><br>


                <input type="password" name="m_password1" class="rounded-button" placeholder="รหัสผ่าน" required>
                <div style="text-align:left; margin-top: 5px;">
                    <small class="text-danger note" style="margin-left: 140px;">หมายเหตุ:
                        รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร</small>
                </div>

                <br>

                <input type="password" class="rounded-button" name="m_password2" placeholder="ยืนยันรหัสผ่าน" required>
                <br><br>


                <center><input type="submit" name="submit" value="สมัครสมาชิก" class="rounded-button2"></center> <br>
                <div class="g-recaptcha" data-sitekey="6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC" align='center'></div>

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

        function upload() {

            const fileUploadInput = document.querySelector('.file-uploader');

            // using index [0] to take the first file from the array
            const image = fileUploadInput.files[0];

            // check if the file selected is not an image file
            if (!image.type.includes('image')) {
                return alert('Only images are allowed!');
            }

            // check if size (in bytes) exceeds 10 MB
            if (image.size > 10_000_000) {
                return alert('Maximum upload size is 10MB!');
            }

            const fileReader = new FileReader();
            fileReader.readAsDataURL(image);

            fileReader.onload = (fileReaderEvent) => {
                const profilePicture = document.querySelector('.profile-picture');
                profilePicture.style.backgroundImage = `url(${fileReaderEvent.target.result})`;
            }
        }
    </script>