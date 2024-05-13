<!-- Map -->
<div style="height: 90vh;" id="map">

<!-- ช่องกรอกข้อความเพื่อค้นหา -->

</div>
<div class="search-container">
    <input type="text" id="search-input" placeholder="ค้นหาตำแหน่ง...">
    <button onclick="searchLocation()">ค้นหา</button>
</div>


<!-- Icon หาตำแหน่งปัจจุบัน -->
<a id="findme-icon" class="btn primary" onclick="getLocation()">
    <i class="bi bi-geo-alt-fill"></i>
</a>


<!-- ฟิลเตอร์ร้านใกล้ฉัน  -->
<div class="card">
    <div class="card-header">ร้านใกล้ฉัน</div>
    <div class="distance-options">
        <select id="distance-select">
            <option value="0" selected>ดูทั้งหมด</option>
            <option value="1">1 kl</option>
            <option value="2">2 kl</option>
            <option value="3">3 kl</option>
            <option value="4">4 kl</option>
            <option value="5">5 kl</option>
            <option value="6">6 kl</option>
            <option value="7">7 kl</option>
            <option value="8">8 kl</option>
            <option value="9">9 kl</option>
            <option value="10">10 kl</option>
            <option value="11">11 kl</option>
            <option value="12">12 kl</option>
            <option value="13">13 kl</option>
            <option value="14">14 kl</option>
            <option value="15">15 kl</option>
            <option value="16">16 kl</option>
            <option value="17">17 kl</option>
            <option value="18">18 kl</option>
            <option value="19">19 kl</option>
            <option value="20">20 kl</option>
            <option value="21">21 kl</option>
            <option value="22">22 kl</option>
            <option value="23">23 kl</option>
            <option value="24">24 kl</option>
            <option value="25">25 kl</option>
        </select>
    </div>
    <button class="search-button" onclick="filterLocation()">ค้นหา</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const distanceSelect = document.getElementById('distance-select');
        const distanceOptions = document.querySelectorAll(".distance-option");

        distanceSelect.addEventListener('change', function () {
            const selectedDistance = this.value;
            distanceOptions.forEach(option => {
                if (option.getAttribute('data-distance') === selectedDistance) {
                    option.classList.add('active');
                } else {
                    option.classList.remove('active');
                }
            });
        });
    });
</script>
<!--  -->
<div id='show_latlng'></div>

<input type="hidden" id="latitude">
<input type="hidden" id="longitude">
<!-- End Map -->
<?php
$db = new ConnectDb();
$conn = $db->getConn();

$marketLocations = $db->getMarketLocations();

$selectedStoreId = $_GET['id'] ?? null;
?>
<!-- End Map -->

<!--  -->
<!-- map -->
<script>
    var mymap = L.map('map').setView([16.041630974507328, 103.12578624259007], 13);
    var latlngMe = []
    var lastMarker; // ตัวแปรสำหรับเก็บหมุดล่าสุด

    var marketLocations = <?php echo json_encode($marketLocations); ?>;

    var customIcon = L.icon({
        iconUrl: 'images/marker.png', // ที่อยู่ของไฟล์รูปภาพ icon ที่คุณต้องการใช้
        iconSize: [70, 70], // ขนาดของ icon
        iconAnchor: [22, 94], // จุดที่ icon จะแสดงเพื่อชี้ไปยังแผนที่
        popupAnchor: [-3, -76] // จุดที่ popup จะเปิดขึ้นมา
    });

    // วนลูปข้อมูลตำแหน่งที่ตั้งจาก marketLocations และสร้างหมุดบนแผนที่ด้วย customIcon
    marketLocations.forEach(function (location) {
        if (location.latitude && location.longitude) {
            var marker = L.marker([parseFloat(location.latitude), parseFloat(location.longitude)], { icon: customIcon }).addTo(mymap);
            addPopupToMarker(marker, location);

            // เพิ่มเงื่อนไขเพื่อเปิด popup ของร้านค้าที่มี id ตรงกับที่รับมาจาก URL parameter
            if (location.mk_id == "<?php echo $selectedStoreId; ?>") {
                marker.openPopup();
            }
        }
    });

    // เรียกใช้ฟังก์ชันเมื่อหน้าเว็บโหลดเสร็จ
    document.addEventListener('DOMContentLoaded', function () {
        fetchMarketLocations();
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(mymap);

    var iconMarker = L.icon({
        iconUrl: 'images/melocation.png',
        iconSize: [70, 70]

    })

    // mark me location
    function addOrUpdateMarker(lat, lng) {
        // ตรวจสอบและลบหมุดเก่า
        if (lastMarker) {
            mymap.removeLayer(lastMarker);
        }
        // เพิ่มหมุดใหม่และอัปเดตตัวแปร lastMarker
        lastMarker = L.marker([lat, lng], { icon: iconMarker }).addTo(mymap);
        // อัปเดต latlngMe
        latlngMe = [lat, lng];
        console.log(latlngMe)
        // แสดงค่า latlngMe
        // document.getElementById('show_latlng').textContent = 'Latitude: ' + lat + ', Longitude: ' + lng;
        // อัปเดตฟิลด์ที่ซ่อนไว้
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
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
        mymap.setView([position.coords.latitude, position.coords.longitude], 13);
    }
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
            <b>อีเมล:</b> ${location.mk_email}<br>
            <b>เบอร์โทร:</b> ${location.mk_phone}<br>
            <b>คะแนนรีวิว:</b> ${location.avg_rating} &#9733;<br>
        
    `;
    }

    function addPopupToMarker(marker, location) {
        var locationString = location.latitude + ',' + location.longitude;
        var popupContent = createPopupContent(location);
        popupContent += `<br><button class="select-store" onclick="selectStore('${location.mk_id}')">เลือกร้านค้า</button>`;
        popupContent += `<br><button class="find-route" onclick="findRouteToStore('${locationString}')">หาเส้นทาง</button>`; // เพิ่มปุ่มหาเส้นทาง
        marker.bindPopup(popupContent);
    }

    // ฟังก์ชันสำหรับเลือกร้านค้าและเก็บ session
    function selectStore(storeCode) {

        window.location.href = '?page=reserv_new&store=' + storeCode;
    }
    // 

    // ค้นหาชื่อร้านค้า
    function searchLocation() {
        var input = document.getElementById('search-input').value; // รับค่าชื่อร้านค้าที่ต้องการค้นหา

        // ค้นหาชื่อร้านค้าใน marketLocations
        var foundLocation = marketLocations.find(function (location) {
            return location.mk_name === input;
        });

        if (foundLocation) {
            // พาไปยังตำแหน่งของร้านค้าที่พบ
            mymap.setView([parseFloat(foundLocation.latitude), parseFloat(foundLocation.longitude)], 14);
            var marker = L.marker([parseFloat(foundLocation.latitude), parseFloat(foundLocation.longitude)], { icon: customIcon }).addTo(mymap);
            addPopupToMarker(marker, foundLocation);
            marker.openPopup(); // เปิดป็อปอัพทันทีหลังจากเพิ่มมาร์คเกอร์ลงบนแผนที่
        } else {
            // หากไม่พบร้านค้า
            alert('ไม่พบร้านค้าที่คุณค้นหา');
        }
    }

    // นำทาง
    function findRouteToStore(storeLocation) {
        // console.log(storeLocation)
        var url = 'https://maps.google.com/?q=' + storeLocation;

        window.open(url, '_blank');

    }

    // กรองรัศมี
    function filterLocation() {
        var selectedDistance = document.getElementById('distance-select').value; // ระยะทางที่เลือกจาก dropdown

        mymap.eachLayer(function (layer) {
            if (layer instanceof L.Marker || layer instanceof L.Path) {
                mymap.removeLayer(layer);
            }
        });

        if (selectedDistance == 0) {
            // ถ้าเลือกระยะทางเป็น "ดูทั้งหมด" ให้แสดงทุกร้านค้า
            marketLocations.forEach(function (location) {
                if (location.latitude && location.longitude) {
                    var marker = L.marker([parseFloat(location.latitude), parseFloat(location.longitude)], { icon: customIcon }).addTo(mymap);
                    addPopupToMarker(marker, location);
                }
            });
        } else {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {

                    // เมื่อได้รับตำแหน่งปัจจุบันของผู้ใช้แล้ว
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;

                    showPosition(position);

                    // สร้างตำแหน่งปัจจุบันของผู้ใช้
                    var latlngMe = L.latLng(lat, lng);

                    // สร้างเส้นรัศมี
                    var radius = parseFloat(selectedDistance); // ค่าที่ผู้ใช้เลือกจาก dropdown ที่แปลงเป็นตัวเลข

                    var options = {
                        steps: 10, // จำนวนขั้นตอนของการสร้างเส้นรัศมี
                        units: 'kilometers',
                        properties: {
                            foo: 'bar'
                        }
                    };
                    var circle = turf.circle([lng, lat], radius, options); // สร้างเส้นรัศมีโดยใช้ตำแหน่งปัจจุบัน
                    // ค้นหาร้านค้าที่อยู่ภายในเส้นรัศมี
                    var ptsWithin = turf.pointsWithinPolygon(marketLocations, circle);
                    // สร้างและแสดงเส้นรัศมีบนแผนที่
                    var circleLayer = L.geoJSON(circle).addTo(mymap);
                    // สร้างและแสดงร้านค้าที่อยู่ภายในเส้นรัศมีบนแผนที่
                    var withinStoresLayer = L.geoJSON(ptsWithin, {
                        onEachFeature: function (feature, layer) {
                            layer.bindPopup(createPopupContent(feature.properties)); // สร้าง popup สำหรับแต่ละร้านค้า
                        }
                    }).addTo(mymap);

                    if (selectedDistance != 0) {
                        // เลือกระยะทางที่ไม่ใช่ "ดูทั้งหมด" ให้สร้างและแสดงเฉพาะร้านค้าที่อยู่ภายในรัศมี
                        marketLocations.forEach(function (location) {
                            if (location.latitude && location.longitude) {
                                var distance = turf.distance(turf.point([lng, lat]), turf.point([location.longitude, location.latitude]), { units: 'kilometers' });
                                if (distance <= selectedDistance) {
                                    var marker = L.marker([parseFloat(location.latitude), parseFloat(location.longitude)], { icon: customIcon }).addTo(mymap);
                                    addPopupToMarker(marker, location);
                                }
                            }
                        });
                    }

                });
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }
    }

    // 
    mymap.on('click', onClickForMap)
</script>
<!--  -->

<!-- css -->
<style>
    #findme-icon {
        position: absolute;
        top: 20vh;
        left: 189vh;
        background-color: #ffffff;
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

    /* สไตล์สำหรับช่องค้นหา */
    .search-container {
        position: absolute;
        z-index: 1000;
        top: 25%;
        left: 20px;
        /* เพิ่มค่า z-index เพื่อให้ปุ่มค้นหาอยู่เหนือกว่าแผนที่ */
        box-sizing: border-box;
    }

    .search-container input[type=text] {
        padding: 10px;
        margin-top: 8px;
        font-size: 17px;
        border: 2px solid #ccc;
        /* เปลี่ยนเป็นเส้นขอบ */
        border-radius: 5px;
        /* เพิ่มขอบมนเข้าไป */
        width: 230px;
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

    /* เลือกร้านค้า */
    .select-store {
        padding: 5px 10px;
        /* ปรับขนาดของปุ่ม */
        background-color: #ff6666;
        /* สีพื้นหลัง */
        color: white;
        /* สีข้อความ */
        border: none;
        /* ไม่มีเส้นขอบ */
        border-radius: 5px;
        /* ขอบมน */
        cursor: pointer;
        /* เปลี่ยนรูปลูกศรเป็นมือ */
        font-size: 16px;
        /* ขนาดตัวอักษร */
    }

    .select-store:hover {
        background-color: #ff4d4d;
        /* เปลี่ยนสีพื้นหลังเมื่อเมาส์วางทับ */
    }

    /* ปุ่มหาเส้นทาง */
    .find-route {
        margin-top: 2px;
        padding: 5px 8px;
        /* ปรับขนาดของปุ่ม */
        background-color: #E5E71A;
        /* สีพื้นหลัง */
        color: white;
        /* สีข้อความ */
        border: none;
        /* ไม่มีเส้นขอบ */
        border-radius: 5px;
        /* ขอบมน */
        cursor: pointer;
        /* เปลี่ยนรูปลูกศรเป็นมือ */
        font-size: 16px;
        /* ขนาดตัวอักษร */
    }

    .find-route:hover {
        background-color: yellow;
        /* เปลี่ยนสีพื้นหลังเมื่อเมาส์วางทับ */
    }

    /* ร้านใกล้ฉัน */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f2f2f2;
    }

    .card {
        position: absolute;
        top: 32vh;
        z-index: 1000;
        width: 220px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 20px;
        padding: 20px;
        box-sizing: border-box;
    }

    .card-header {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .distance-options {
        margin-bottom: 20px;
    }

    #distance-select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="#000000" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5H7z"/><path fill="none" d="M0 0h24v24H0z"/></svg>');
        background-repeat: no-repeat;
        background-position: calc(100% - 10px) center;
        background-size: 16px;
    }

    .search-button {
        background-color: #ff6666;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        cursor: pointer;
    }

    .search-button:hover {
        background-color: #ff4d4d;
    }
</style>