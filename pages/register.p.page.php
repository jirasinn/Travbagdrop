<div class="row col-12">

    <div class="col-3">

        <div class="slide-bg">
            <div class="d-flex flex-column flex-shrink-0 p-3 " style="width: 350px; background-color: #121139;">

                <div class="container text-center">
                    <img src="images/newlogobd.png" class="me-2" width="180" height="182">
                    <a
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none text-center">

                    </a>
                </div>

            </div>
        </div>

    </div>
    <!-- end col-5 -->

    <div class="col-9">

        <form method="post" id="send-otp"  action="crud/regissuc.p.php" target="iframe_target"
            enctype="multipart/form-data">

            <label for="mk_name">ชื่อสถานประกอบการ</label><br>
            <input type="text" id="mk_name" name="mk_name" placeholder="ชื่อสถานประกอบการณ์" required><br>

            <label for="mk_code">หมายเลขสถานประกอบการ</label><br>
            <input type="text" id="mk_code" name="mk_code" placeholder="หมายเลขสถานประกอบการณ์" required><br>

            <div class="form-row">
                <label class="custom-file-upload">
                    <input type="file" name="fileD" accept="image/gif, image/jpeg, image/png" data-target="file-label">
                    เพิ่มเอกสารประกอบการ <i class="bi bi-upload" ></i>
                </label>
                <span id="file-label"></span>
            </div>
            <br>

            <!-- จังหวัด-->
            <label for="province">จังหวัด</label><br>
           
            <select name="province" id="province" class="rounded-button" required>
                    <option value="">เลือกจังหวัด</option>
                    <?php
                    $db = new ConnectDb();
                    $conn = $db->getConn();

                    $sql = "SELECT * FROM thai_provinces";
                    $result = mysqli_query($conn, $sql);

                    // วนลูปแสดงตัวเลือกคณะ
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['name_th'] . "</option>";
                    }
                    // ปิดการเชื่อมต่อฐานข้อมูล
                    mysqli_close($conn);
                    ?>
                </select><br>
            <!-- map -->
            <label for="location">ที่อยู่สถานที่ประกอบการ</label><br>
            <input type="text" id="location" name="location" placeholder="ที่อยู่สถานที่ประกอบการ" required><br>

            <input type="hidden" name="latitude" id="latitude" value="">
            <input type="hidden" name="longitude" id="longitude" value="">
            <!--  -->
            <a class="btn primary" onclick="openMapModal()">
                <div class="card-text"> ปักหมุดสถานที่ประกอบการ <i class="bi bi-geo-alt-fill" style='color: red;'></i></div>
            </a>
            <!--  -->
            <div id="message"></div>
            <!--  -->
            <script>
                var latitudeInput = document.getElementById('latitude');
                var longitudeInput = document.getElementById('longitude');
                var messageElement = document.getElementById('message');

                // Function to update message
                function updateMessage() {
                    var latitude = latitudeInput.value.trim();
                    var longitude = longitudeInput.value.trim();

                    if (latitude !== "" && longitude !== "") {
                        messageElement.innerHTML = '<p style="color:green;"><i class="bi bi-check-circle-fill"></i> ทำการปักหมุดเรียบร้อยแล้ว</p>';
                    } else {
                        messageElement.innerHTML = '<p style="color:red;"><i class="bi bi-x-circle-fill"></i> ยังไม่ได้ปักหมุดสถานประกอบการของท่าน</p>';
                    }
                }
            </script>

            <!--  -->
            <label for="mk_phone">เบอร์ติดต่อสถานที่ประกอบการ</label><br>
            <input type="phone" id="mk_phone" name="mk_phone" placeholder="เบอร์ติดต่อสถานที่ประกอบการ" required><br>

            <div style="display: flex; flex-direction: row;">
                <div style="flex: 1;">
                    <label for="mk_fname1">ชื่อผู้มีอำนาจ</label><br>
                    <input type="text" id="mk_fname1" name="mk_fname1" placeholder="ชื่อผู้มีอำนาจ" required
                        style="padding: 10px; width: 95%;"><br>
                </div>
                <div style="flex: 1;">
                    <label for="mk_lname1">นามสกุล</label><br>
                    <input type="text" id="mk_lname1" name="mk_lname1" placeholder="นามสกุล" required
                        style="padding: 10px;"><br>
                </div>
            </div>

            <label for="mk_phone1">เบอร์ติดต่อ</label><br>
            <input type="phone" id="mk_phone1" name="mk_phone1" placeholder="เบอร์ติดต่อ" required><br>

            <label for="" style="color: #999;">*กรณีที่มี</label><br>

            <div style="display: flex; flex-direction: row;">
                <div style="flex: 1;">
                    <label for="mk_fname2">ชื่อผู้ประสานงาน<span style="color: red;">*</span></label><br>
                    <input type="text" id="mk_fname2" name="mk_fname2" placeholder="ชื่อผู้ประสานงาน"
                        style="padding: 10px; width: 95%;"><br>
                </div>
                <div style="flex: 1;">
                    <label for="mk_lname2">นามสกุล<span style="color: red;">*</span></label><br>
                    <input type="text" id="mk_lname2" name="mk_lname2" placeholder="นามสกุล" style="padding: 10px;"><br>
                </div>
            </div>

            <label for="mk_phone2">เบอร์ติดต่อ<span style="color: red;">*</span></label><br>
            <input type="phone" id="mk_phone2" name="mk_phone2" placeholder="เบอร์ติดต่อ"><br>

            <label for="mk_email">E-mail</label><br>
            <input type="email" id="mk_email" name="mk_email" placeholder="email"><br>

            <label for="password">รหัสผ่าน</label><br>
            <input type="password" name="mk_password1" placeholder="รหัสผ่าน" placeholder="รหัสผ่าน" required>

            <div style="display: flex; align-items: center; margin-top: -18px;">
                <small class="text-danger note" style="margin-left: 5px;">หมายเหตุ:
                    รหัสผ่านต้องมีความยาวระหว่าง 6 ถึง 10 ตัวอักษร</small>
            </div>
            <br>

            <input type="password" name="mk_password2" placeholder="ยืนยันรหัสผ่าน" required>

            <div class="form-row">
                <label class="form-label">อัพโหลดสถานที่เก็บสัมภาระ</label>
                <label class="custom-file-upload">
                    <input type="file" name="fileS" accept="image/gif, image/jpeg, image/png" data-target="file-label2">
                    อัพโหลดภาพ <i class="bi bi-upload"></i>
                </label>
                <span id="file-label2"></span>
            </div>
            <br>
            <div class="form-row">
                <label class="form-label">อัพโหลดสถานที่ประกอบการ</label>
                <label class="custom-file-upload">
                    <input type="file" name="fileM" accept="image/gif, image/jpeg, image/png" data-target="file-label3">
                    อัพโหลดภาพ <i class="bi bi-upload"></i>
                </label>
                <span id="file-label3"></span>
            </div>
            <!-- <div class="g-recaptcha" data-sitekey="6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC" align='center'></div> -->
            <br>
            <!--  -->

            <!--  -->
            <input type="submit" name="submit" value="ยืนยันการลงทะเบียน" data-bs-toggle="modal" data-bs-target="#otp-modal">

            <iframe id="iframe_target" name="iframe_target" src="#" style="display: none; visibility: hidden;"></iframe>
        </form>

    </div>

    <!-- end col-7 -->

    <!--  -->
</div>
<!-- end col-12 -->
<!-- modal OTP -->
<div class="modal fade" id="otp-modal"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="staticBackdropLabel">เราได้ส่งรหัสยืนยันไปที่ Email ของท่านแล้ว กรุณากรอก OTP ที่ได้รับ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="otp-form" id="check-otp" action="crud/regis.p_checkotp.php" method="post" target="otp_target">
                    <input type="text" id="otp" name="otp_code" class="otp-btn" style="margin-bottom: 5%;" placeholder="กรอกรหัส OTP ที่ได้รับ" required autofocus>
                   
                    <center><input type="submit" id="otpVerify" name="verify" class="otp-submit" value="ยืนยัน"></center>
                </form>
                <iframe id="otp_target" name="otp_target" src="#" style="display: none; visibility: hidden;"></iframe>
            </div>
        </div><!-- modal content -->
    </div><!-- modal dialog -->
</div><!-- modal fade -->



<!-- Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">

                <!-- ส่วนแมพ -->
                <div id="mapModalContent" style="height: 80vh;"></div>

                <!-- Icon หาตำแหน่งปัจจุบัน -->
                <a id="findme-icon" class="btn primary" onclick="getLocation()">
                    <i class="bi bi-geo-alt-fill"></i>
                </a>

                <div id='show_latlng'></div>
                <!-- ช่องกรอกข้อความเพื่อค้นหา -->
                <div class="search-container">
                    <input type="text" id="search-input" placeholder="ค้นหาตำแหน่ง...">
                    <button onclick="searchLocation()">ค้นหา</button>
                </div>

                <div id='show_latlng'></div>

                <input type="hidden" id="latitude">
                <input type="hidden" id="longitude">
                <!-- End Map -->
                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();

                $marketLocations = $db->getMarketLocations();

                ?>
                <!--  -->
            </div>

            <div class="modal-footer">
                <button class="modal-footerBT" type="button" class="btn btn-secondary"
                    data-dismiss="modal">ยืนยันตำแหน่ง</button>
            </div>
        </div>
    </div>
</div>



<!-- script -->
<script>
    // pic
    document.querySelectorAll('input[type="file"]').forEach(function (input) {
        input.addEventListener('change', function () {
            const fileName = this.files[0].name;
            const targetId = this.getAttribute('data-target'); // เราสามารถใช้ attribute สร้างขึ้นเองเพื่อระบุ ID ของ element ที่ต้องการแสดงชื่อไฟล์
            document.getElementById(targetId).textContent = fileName;
        });
    });

    // 
    // function checkIfNotBot() {
    //     // ตรวจสอบว่า reCAPTCHA ถูกติ๊กหรือไม่
    //     var response = grecaptcha.getResponse();

    //     if (response.length !== 0) {
    //         // ถ้าติ๊กที่ reCAPTCHA แล้ว
    //         // ตรวจสอบบอทโดยใช้ reCAPTCHA Verification API
    //         verifyCaptcha(response);
    //     } else {
    //         // ถ้าไม่ติ๊กที่ reCAPTCHA
    //         alert('กรุณายืนยันว่าท่านไม่ใช่บอท');
    //         return false; // ไม่ส่งแบบฟอร์ม
    //     }
    // }

    // function verifyCaptcha(response) {
    //     // ทำการส่ง request ไปยัง Google reCAPTCHA Verification API
    //     fetch('https://www.google.com/recaptcha/api/siteverify', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/x-www-form-urlencoded',
    //         },
    //         body: `secret=6LfpEGYpAAAAADCl_jJncaYml7OmaVmnkF41-iCC&response=${response}`,
    //     })
    //         .then(response => response.json())
    //         .then(data => {
    //             // ตรวจสอบค่า success จาก response
    //             if (data.success) {
    //                 // ถ้าเป็นบอทจะไม่ทำการ submit ฟอร์ม
    //                 alert('คุณไม่ใช่บอท ยินดีต้อนรับ!');
    //                 // หรือสามารถทำการ submit ฟอร์มต่อได้
    //                 document.getElementById('registration-form').submit();
    //             } else {
    //                 // ถ้าเป็นบอทจะแสดง alert และไม่ทำการ submit ฟอร์ม
    //                 alert('คุณอาจเป็นบอท กรุณาลองใหม่');
    //             }
    //         })
    //         .catch(error => console.error('Error:', error));

    //     return false; // ไม่ส่งแบบฟอร์ม
    // }
</script>

<!-- script map -->
<script>
    function openMapModal() {
        var myModal = new bootstrap.Modal(document.getElementById('mapModal'));
        myModal.show();

        $('#mapModal').on('shown.bs.modal', function () {
            var mymap = L.map('mapModalContent').setView([16.041630974507328, 103.12578624259007], 14);
            var latlngStore = [];
            var lastMarker;

            var customIcon = L.icon({
                iconUrl: 'images/marker.png',
                iconSize: [70, 70],
                iconAnchor: [22, 94],
                popupAnchor: [-3, -76]
            });

            var marketLocations = <?php echo json_encode($marketLocations); ?>;

            marketLocations.forEach(function (location) {
                if (location.latitude && location.longitude) {
                    var marker = L.marker([parseFloat(location.latitude), parseFloat(location.longitude)], { icon: customIcon }).addTo(mymap);
                    addPopupToMarker(marker, location); // เพิ่ม popup ให้กับ marker
                }
            });

            // เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จ
            document.addEventListener('DOMContentLoaded', function () {
                fetchMarketLocations();
            });

            // 
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mymap);

            var iconMarker = L.icon({
                iconUrl: 'images/melocation.png',
                iconSize: [100, 100]
            })

            // mark me shop
            function addOrUpdateMarker(lat, lng) {
                // ตรวจสอบและลบหมุดเก่า
                if (lastMarker) {
                    mymap.removeLayer(lastMarker);
                }
                // เพิ่มหมุดใหม่และอัปเดตตัวแปร lastMarker
                lastMarker = L.marker([lat, lng], { icon: iconMarker }).addTo(mymap);
                // อัปเดต latlngStore
                latlngStore = [lat, lng];
                // แสดงค่า latlngStore
                // document.getElementById('show_latlng').textContent = 'Latitude: ' + lat + ', Longitude: ' + lng;
                // อัปเดตฟิลด์ที่ซ่อนไว้
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                updateMessage();
            }

            // ปรับปรุงฟังก์ชัน onClickForMap เพื่อใช้ฟังก์ชัน addOrUpdateMarker
            function onClickForMap(e) {
                mymap.eachLayer(function (layer) {
                    if (layer instanceof L.Marker && layer.getLatLng().equals(e.latlng)) {
                        layer.openPopup();
                    }
                });
                addOrUpdateMarker(e.latlng.lat, e.latlng.lng);
                // console.log('Location:', latlngStore);
            }

            // ปรับปรุงฟังก์ชัน showPosition เพื่อใช้ฟังก์ชัน addOrUpdateMarker
            function showPosition(position) {
                addOrUpdateMarker(position.coords.latitude, position.coords.longitude);
                mymap.setView([position.coords.latitude, position.coords.longitude], 18);
            }

            $('#findme-icon').on('click', function () {
                // เมื่อคลิกที่ findme-icon ภายในโมดัล
                // เรียกใช้ getLocation() เพื่อเริ่มกระบวนการหาตำแหน่ง
                getLocation();
            });
            //   findme
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            // popup
            function createPopupContent(location) {
                var imagePath = `images/market/${location.mk_img}`;
                return `
        <div style="text-align: center;">
            <img src="${imagePath}" style="max-width: 120px;"><br><br>
            </div>
            <b>ชื่อร้านค้า:</b> ${location.mk_name}<br>
            <b>รหัสร้านค้า:</b> ${location.mk_code}<br>
            <b>เบอร์โทร:</b> ${location.m_phone}<br>`;
            }

            // ฟังก์ชันสำหรับเพิ่ม popup ลงในตัว marker
            function addPopupToMarker(marker, location) {
                var popupContent = createPopupContent(location);
                marker.bindPopup(popupContent);
            }
            // 
            mymap.on('click', onClickForMap)
        });
    }

</script>

<!--  -->
<!-- css -->
<style>
    form {
        width: 100%;
        /* margin: 0 auto; */
        background-color: transparent;
        padding: 40px;
        border: none;
        border-radius: 4px;
        /* margin-left: -155px; */
    }

    label {
        display: block;
        margin-bottom: -25px;
        padding: -15px;
        font-weight: bold;
    }

    #province,
    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="number"],
    input[type="phone"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #D9D9D9;
    }

    input[type="submit"] {
        width: 20%;
        padding: 10px;
        background-color: #121139;
        color: #F7F41F;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        display: block;
        margin: auto;
        margin-top: -15px;
    }

    input[type="submit"]:hover {
        background-color: #419ba3;
    }

    .custom-file-upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        background: #D9D9D9;
        color: #212529;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
    }

    .custom-file-upload:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }

    input[type="file"] {
        display: none;
    }

    #file-label {
        display: inline-block;
        margin-left: 10px;
    }

    #file-label2 {
        display: inline-block;
        margin-left: 10px;

    }

    #file-label3 {
        display: inline-block;
        margin-left: 10px;
    }

    .card-text {
        background: #D9D9D9;
        padding: 5px 10px;
        /* เพิ่มการเติมระยะขอบ */
        border-radius: 10px;
        /* เพิ่มการกำหนดรูปร่าง */
        margin-left: -15px;
    }

    .card-text:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
    }

    .modal-lg {
        top: 5vh;
        max-width: 1500px;
        /* ความกว้างสูงสุดของ modal */
        margin: 0 auto;
        /* จัดตำแหน่งกึ่งกลางตามแนวนอน */
    }

    .modal-content {
        border-radius: 40px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        width: 105%;
        /* กำหนดความกว้างเป็น 100% */
    }

    .modal-footerBT {
        width: 20%;
        padding: 10px;
        background-color: #121139;
        color: #F7F41F;
        border: none;
        border-radius: 14px;
        cursor: pointer;
    }

    .modal-footerBT:hover {
        background-color: #419ba3;
    }

    /* map */
    #findme-icon {
        position: absolute;
        top: 13vh;
        left: 94%;
        background-color: #ff6666;
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1000;
        /* ค่า z-index เพื่อให้ปุ่มของคุณอยู่เหนือกับแผนที่ */
    }

    /* สไตล์สำหรับช่องค้นหา map*/
    .search-container {
        position: absolute;
        top: 4vh;
        right: 5vh;
        z-index: 1000;
        /* เพิ่มค่า z-index เพื่อให้ปุ่มค้นหาอยู่เหนือกว่าแผนที่ */
    }

    .search-container input[type=text] {
        padding: 10px;
        margin-top: 8px;
        font-size: 17px;
        border: 2px solid #ccc;
        /* เปลี่ยนเป็นเส้นขอบ */
        border-radius: 5px;
        /* เพิ่มขอบมนเข้าไป */
        width: 300px;
        /* เพิ่มความยาว */
    }

    .search-container button {
        padding: 10px;
        margin-top: 8px;
        margin-left: -2px;
        /* ปรับขนาดเพื่อให้ปุ่มค้นหาตรงกลางกับ input */
        background: #ff6666;
        /* เปลี่ยนสีเป็นสีแดง */
        color: white;
        /* เปลี่ยนสีตัวอักษรให้เป็นสีขาว */
        font-size: 17px;
        border: 2px solid #ff6666;
        /* เปลี่ยนสีขอบเป็นสีแดง */
        border-radius: 5px;
        /* เพิ่มขอบมนเข้าไป */
        cursor: pointer;
    }

    /* เมื่อปุ่มถูกกด */
    .search-container button:hover {
        background: #ff4d4d;
        /* เปลี่ยนสีเมื่อเมาส์วางทับ */
        border-color: #ff4d4d;
        /* เปลี่ยนสีขอบเมื่อเมาส์วางทับ */
    }
</style>