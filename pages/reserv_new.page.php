<?php
if (!isset($_SESSION['bagdrop_member_id_type'])) {
    echo "<script>";
    echo "alert('กรุณาเข้าสู่ระบบ');";
    echo "window.location='?page=login';";
    echo "</script>";
    exit;
}
$m_id = $_SESSION['bagdrop_member_id'];
$storeCode = $_GET['store'];
// $storeCode = $_SESSION['selectedStore'];

$_SESSION['store'] = $storeCode;
// $storeCode = $_SESSION['store'];

?>
<br><br>
<!--  -->
<div class="row col-md-12">
    <a href="?page=home"><img src="images/กลับ.png" width="4%" style="margin-left: 15%;  margin-top: 0%; "></a>
</div>

<div class="circle-bar col-md-12">

    <div class="circle active">
        1
        <div class="circle-description">ข้อมูลสัมภาระ</div>
    </div>
    <div class="circle">
        2
        <div class="circle-description">ข้อมูลลูกค้า</div>
    </div>
    <div class="circle">
        3
        <div class="circle-description">ชำระเงิน</div>
    </div>
</div>

<!--  -->

<style>
    .circle-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 850px;
        height: 20px;
        background-color: #F7F41F;
        border-radius: 25px;
        padding: 1px;
        margin-left: 30%;
        margin-bottom: -2%;
    }

    .circle-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 45%;
        height: 20px;
        background-color: #F7F41F;
        border-radius: 25px;
        padding: 1px;
        margin-left: 30%;
        margin-bottom: 0.5%;
        margin-top: -2.5%;
    }

    .circle {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        font-weight: bold;
        color: #000;
    }

    .circle.active .circle-description {
        color: #000;
        /* เปลี่ยนสีข้อความที่ active เป็นสีดำ */
    }

    .circle-description {
        position: absolute;
        top: calc(100% + 10px);
        left: 50%;
        transform: translateX(-50%);
        white-space: nowrap;
        color: #ccc;
        /* เปลี่ยนสีข้อความที่ไม่ active เป็นสีเทา */
        padding: 5px 10px;
        border-radius: 5px;
        opacity: 1;

    }

    .active {
        background-color: #007bff;
        color: #fff;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        100% {
            transform: scale(1.1);
        }
    }
</style>

<!--  -->
<div class="container col-md-12">
    <!--  -->
    <div class="container col-md-5">
        <!--  -->

        <form class="first-form">

            <div class="card-body">
                <div class="container text-left">
                    <div class="name">


                        <?php
                        $db = new ConnectDb();
                        $conn = $db->getConn();
                        // ตรวจสอบว่ามีการเชื่อมต่อกับฐานข้อมูลหรือไม่
                        if ($conn) {
                            // สร้างคำสั่ง SQL เพื่อดึงข้อมูลร้านค้าโดยใช้ mk_code
                            $sql2 = "SELECT * FROM market 

            WHERE mk_id = '$storeCode'";
                            // ส่งคำสั่ง SQL ไปทำงาน
                            $rs2 = mysqli_query($conn, $sql2);
                            // ตรวจสอบว่ามีข้อมูลที่ได้จากการค้นหาหรือไม่
                            if (mysqli_num_rows($rs2) > 0) {
                                // วนลูปเพื่อแสดงข้อมูลทุกแถวที่ได้จากการค้นหา
                                while ($data2 = mysqli_fetch_array($rs2)) {
                                    $mk_img = $data2['mk_img'];
                        ?>

                                    <!--  -->
                                    <!-- แสดงรูปภาพร้านค้า -->
                                    <br>
                                    <img src="images/market/<?= $mk_img; ?>" style="max-width: 560px;" height="330" width="100%"><br>
                                    <br>
                                    <!-- แสดงชื่อร้านค้า -->
                                    <h5><b>
                                            <?= $data2['mk_name']; ?>
                                        </b></h5>
                                    <br>
                                    <!-- แสดงเบอร์โทร -->
                                    <!-- <b>เบอร์โทร:</b>
                                    <?= $data2['mk_phone']; ?><br> -->

                                    <div class="row col-md-12" style="font-size: 24px; margin-top: -5px;">
                                        <!-- ประเภทกระเป๋า บรรจุได้ -->

                                        <!--  -->
                                        <?php
                                        // Connect to database (assuming you have already established a database connection)
                                        $db = new ConnectDb();
                                        $conn = $db->getConn();
                                        // Check connection
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }

                                        // Query to get all tracked items
                                        $sql = "SELECT tracking FROM bagreserv 
                                        WHERE mk_id = '$storeCode' AND status != 'คืนสำเร็จ'";
                                        $result = $conn->query($sql);

                                        // Initialize variables to store counts for each category
                                        $spaceA = 0;
                                        $spaceB = 0;
                                        $spaceC = 0;

                                        // If there are tracked items in the result
                                        if ($result->num_rows > 0) {
                                            // Iterate through each tracked item
                                            while ($row = $result->fetch_assoc()) {
                                                // Extract the tracking IDs
                                                $trackingIDs = explode(", ", $row['tracking']);

                                                // Iterate through each tracking ID
                                                foreach ($trackingIDs as $trackingID) {
                                                    // Determine the category (A, B, or C) based on the first letter of the tracking ID
                                                    $category = substr($trackingID, 0, 1);

                                                    // Extract the number from the tracking ID
                                                    $number = intval(substr($trackingID, 1));

                                                    // Update the available space for the corresponding category
                                                    switch ($category) {
                                                        case 'A':
                                                            if ($spaceA < 21) {
                                                                $spaceA++;
                                                            } else {
                                                                $spaceA = 21; // Set to maximum value
                                                            }
                                                            break;
                                                        case 'B':
                                                            if ($spaceB < 21) {
                                                                $spaceB++;
                                                            } else {
                                                                $spaceB = 21; // Set to maximum value
                                                            }
                                                            break;
                                                        case 'C':
                                                            if ($spaceC < 21) {
                                                                $spaceC++;
                                                            } else {
                                                                $spaceC = 21; // Set to maximum value
                                                            }
                                                            break;
                                                        default:
                                                            // Invalid category
                                                            break;
                                                    }
                                                }
                                            }
                                        }

                                        // Close the database connection
                                        $conn->close();

                                        // Function to echo a colored category name and apply the style to the entire row
                                        function echoColoredCategory($category, $space)
                                        {
                                            $sizeLabel = "";
                                            switch ($category) {
                                                case 'A':
                                                    $sizeLabel = "ขนาดของกระเป๋า  16-21 นิ้ว";
                                                    break;
                                                case 'B':
                                                    $sizeLabel = "ขนาดของกระเป๋า  24-26 นิ้ว";
                                                    break;
                                                case 'C':
                                                    $sizeLabel = "ขนาดของกระเป๋า  29-32 นิ้ว";
                                                    break;
                                                default:
                                                    $sizeLabel = "Unknown Size";
                                                    break;
                                            }

                                            if ($space == 21) {
                                                return "<p style='color:red; text-decoration: line-through; margin-top: -8px;'>$sizeLabel <span style=' \margin-left: 30px;'>$space/21</span></p>";
                                            } else {
                                                return "<p style='margin-top: -8px;'>$sizeLabel <span style=' \margin-left: 30px;'>$space/21</span></p>";
                                            }
                                        }

                                        // Output the available space for each category
                                        echo "" . echoColoredCategory('A', $spaceA) . "<br>";
                                        echo "" . echoColoredCategory('B', $spaceB) . "<br>";
                                        echo "" . echoColoredCategory('C', $spaceC) . "<br>";
                                        ?>
                                        <!-- end col -->
                                    </div>

                                    <h6 style="font-size: 24px;"><b>
                                            เวลเปิด-ปิด
                                        </b> 00.00-24.00 น.</h6>
                                    <!--  -->

                                    <?php
                                    $db = new ConnectDb();
                                    $conn = $db->getConn();

                                    // คำสั่ง SQL เพื่อหาค่าเฉลี่ยของคะแนนรีวิวและจำนวนรีวิวทั้งหมด
                                    $sql3 = "SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews 
         FROM feedback 
         WHERE mk_id = '$storeCode'";
                                    $rs3 = mysqli_query($conn, $sql3);

                                    // เรียกดึงข้อมูลจากผลลัพธ์ของคำสั่ง SQL
                                    $data3 = mysqli_fetch_array($rs3);

                                    // หากต้องการแสดงค่าเฉลี่ยและจำนวนรีวิวทั้งหมด
                                    $average_rating = $data3['average_rating'];
                                    $total_reviews = $data3['total_reviews'];
                                    ?>

                                    <!-- แสดงคะแนนรีวิวเฉลี่ยและจำนวนรีวิวทั้งหมด -->
                                    <h6 style="font-size: 24px;"><b>
                                            คะแนนรีวิว <?= number_format($average_rating, 1); ?>
                                            <span style="color: #F7F41F; pointer-events: none;">&#9733;</span>

                                            <span style="font-weight: normal; font-size: 0.9em; vertical-align: middle; display: inline-block; margin-left: 10px; margin-top: -10px; pointer-events: none; font-size: 24px;">จาก
                                                <?= $total_reviews; ?> รีวิว</span>
                                        </b></h6>

                                    <!-- <input type="hidden" name="mk_id" value="<?= $data2['mk_id']; ?><br>"> -->
                        <?php
                                }
                            } else {
                                // ถ้าไม่พบข้อมูลร้านค้า
                                echo "ไม่พบข้อมูลร้านค้า";
                            }
                        } else {
                            // ถ้าไม่สามารถเชื่อมต่อกับฐานข้อมูลได้
                            echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
                        }
                        ?>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end card -->
        </form>


        <!--  -->
    </div>
    <!-- End col-md-6 -->


    <div class="container col-md-7">
        <!--  -->


        <form class="second-form" method="post" action="" enctype="multipart/form-data">
            <div class="card-body">
                <div class="container col-md-12">
                    <?php

                    if (isset($_POST['datersev']) && isset($_POST['rsevtime']) && isset($_POST['dateretr']) && isset($_POST['retrtime'])) {
                        // บันทึกข้อมูลลงใน Session
                        $_SESSION['reservation_date'] = $_POST['datersev'];
                        $_SESSION['reservation_time'] = $_POST['rsevtime'];
                        $_SESSION['retrieval_date'] = $_POST['dateretr'];
                        $_SESSION['retrieval_time'] = $_POST['retrtime'];
                    }

                    ?>
                    <!--  -->
                    <div class="container col-md-6">
                        <div class="form-row">
                            <div class="name" style="font-weight: bold; font-size: 24px; margin: 10px;">
                                วันที่และเวลารับฝาก</div>
                            <div class="value">
                                <?php
                                $db = new ConnectDb();
                                $conn = $db->getConn();

                                // ตรวจสอบว่ามีข้อมูลใน Session หรือไม่
                                if (isset($_SESSION['reservation_date']) && isset($_SESSION['reservation_time'])) {
                                    $reserv_date = $_SESSION['reservation_date'];
                                    $reserv_time = $_SESSION['reservation_time'];
                                    echo '<p><input class="input--style-6" type="date" name="datersev" value="' . $reserv_date . '" required></p>';
                                    echo '<input class="input--style-6" type="time" name="rsevtime" value="' . $reserv_time . '" required>';
                                } else {
                                    $query = "SELECT reserv_date, reserv_time FROM cart WHERE m_id = $m_id LIMIT 1";
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $reserv_date = $row['reserv_date'];
                                        $reserv_time = $row['reserv_time'];
                                        echo '<p><input class="input--style-6" type="date" name="datersev" value="' . $reserv_date . '" required ></p>';
                                        echo '<input class="input--style-6" type="time" name="rsevtime" value="' . $reserv_time . '" required >';

                                        // เก็บข้อมูลลงใน Session
                                        $_SESSION['reservation_date'] = $reserv_date;
                                        $_SESSION['reservation_time'] = $reserv_time;
                                    } else {
                                        echo '<p><input class="input--style-6" type="date" name="datersev" required></p>';
                                        echo '<input class="input--style-6" type="time" name="rsevtime" required>';
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <div class="container col-md-6">
                        <div class="form-row">
                            <div class="name" style="font-weight: bold; font-size: 24px; margin: 10px;">
                                วันที่และเวลารับคืน</div>
                            <div class="value">
                                <?php
                                // ตรวจสอบว่ามีข้อมูลใน Session หรือไม่
                                if (isset($_SESSION['retrieval_date']) && isset($_SESSION['retrieval_time'])) {
                                    $retrive_date = $_SESSION['retrieval_date'];
                                    $retrive_time = $_SESSION['retrieval_time'];
                                    echo '<p><input class="input--style-6" type="date" name="dateretr" value="' . $retrive_date . '" required></p>';
                                    echo '<input class="input--style-6" type="time" name="retrtime" value="' . $retrive_time . '" required>';
                                } else {
                                    $query = "SELECT retrive_date, retrive_time FROM cart WHERE m_id = $m_id LIMIT 1";
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();
                                        $retrive_date = $row['retrive_date'];
                                        $retrive_time = $row['retrive_time'];
                                        echo '<p><input class="input--style-6" type="date" name="dateretr" value="' . $retrive_date . '" required></p>';
                                        echo '<input class="input--style-6" type="time" name="retrtime" value="' . $retrive_time . '" required>';

                                        // เก็บข้อมูลลงใน Session
                                        $_SESSION['retrieval_date'] = $retrive_date;
                                        $_SESSION['retrieval_time'] = $retrive_time;
                                    } else {
                                        echo '<p><input class="input--style-6" type="date" name="dateretr" required></p>';
                                        echo '<input class="input--style-6" type="time" name="retrtime" required>';
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                </div>
                <!--  -->
                <div class="container col-md-12">

                    <div class="container col-md-6">
                        <div class="form-row">
                            <div class="name" style="font-weight: bold; font-size: 24px; margin: 10px;">ขนาดของสัมภาระ
                            </div>
                            <div class="value">

                                <?php
                                $db = new ConnectDb();
                                $conn = $db->getConn();

                                $sql2 = "SELECT * FROM cate";
                                $rs2 = mysqli_query($conn, $sql2);

                                // Fetch data for each category
                                $dataS = mysqli_fetch_array($rs2);
                                $dataM = mysqli_fetch_array($rs2);
                                $dataL = mysqli_fetch_array($rs2);
                                ?>

                                <input type="hidden" value="<?= $dataS['cate_price']; ?>" id="priceS">
                                <input type="hidden" value="<?= $dataM['cate_price']; ?>" id="priceM">
                                <input type="hidden" value="<?= $dataL['cate_price']; ?>" id="priceL">

                                <div class="catetext" style="height: 34px; width: 50px; font-size: 18px;">
                                    <input type="text4" readonly name="cateSmall" id="cateS" placeholder="<?= $dataS['cate_name']; ?>" onchange="calculatePrice()">
                                </div><br>
                                <div class="catetext" style="height: 34px; width: 50px; font-size: 18px;">
                                    <input type="text4" readonly name="cateMedium" id="cateM" placeholder="<?= $dataM['cate_name']; ?>" onchange="calculatePrice()">
                                </div><br>
                                <div class="catetext" style="height: 34px; width: 50px; font-size: 18px;">
                                    <input type="text4" readonly name="cateLarge" id="cateL" placeholder="<?= $dataL['cate_name']; ?>" onchange="calculatePrice()">
                                </div>

                                <!--  -->
                                <script>
                                    var cartItems = []; // Array to store cart items

                                    function calculatePrice() {

                                        var categoryNameS = document.getElementById('cateS').getAttribute('placeholder');
                                        var categoryNameM = document.getElementById('cateM').getAttribute('placeholder');
                                        var categoryNameL = document.getElementById('cateL').getAttribute('placeholder');

                                        // Function to add item to cart
                                        function addToCart(categoryName, quantity, pricePerItem) {
                                            // Find if the category already exists in cartItems
                                            var existingItemIndex = cartItems.findIndex(item => item.categoryName === categoryName);

                                            if (existingItemIndex !== -1) {
                                                // If the category already exists, update its quantity only if quantity > 0
                                                if (quantity > 0) {
                                                    cartItems[existingItemIndex].quantity = quantity;
                                                } else {
                                                    // If quantity is 0, remove the item from cartItems
                                                    cartItems.splice(existingItemIndex, 1);
                                                }
                                            } else if (quantity > 0) {
                                                // If the category doesn't exist and quantity > 0, add it as a new item
                                                var newItem = {
                                                    categoryName: categoryName,
                                                    quantity: quantity,
                                                    pricePerItem: pricePerItem
                                                };
                                                cartItems.push(newItem);
                                            }

                                            // Debug statement to view cart items in the console
                                            console.log("Cart Items:", cartItems);
                                        }

                                        var quantitys = parseInt(document.getElementById('quantityS').value);
                                        var pricePerItemS = parseFloat(document.getElementById('priceS').value);
                                        addToCart(categoryNameS, quantitys, pricePerItemS);

                                        var quantitym = parseInt(document.getElementById('quantityM').value);
                                        var pricePerItemM = parseFloat(document.getElementById('priceM').value);
                                        addToCart(categoryNameM, quantitym, pricePerItemM);

                                        var quantityl = parseInt(document.getElementById('quantityL').value);
                                        var pricePerItemL = parseFloat(document.getElementById('priceL').value);
                                        addToCart(categoryNameL, quantityl, pricePerItemL);

                                        var selectedCategoryNames = [];
                                        // Iterate over the cartItems array
                                        cartItems.forEach(item => {
                                            // Push the category name of the item to the selectedCategoryNames array
                                            selectedCategoryNames.push(item.categoryName);
                                        });

                                        // Convert the array of category names to a single string with comma-separated values
                                        var selectedCategoryNamesString = selectedCategoryNames.join(', ');


                                        // Define a variable to store the total selected quantity
                                        var totalSelectedQuantity = 0;

                                        // Iterate over the cartItems array
                                        cartItems.forEach(item => {
                                            // Add the quantity of the item to the total selected quantity
                                            totalSelectedQuantity += item.quantity;
                                        });

                                        var totalS = pricePerItemS * quantitys;
                                        var totalM = pricePerItemM * quantitym;
                                        var totalL = pricePerItemL * quantityl;
                                        var totalPrice = totalS + totalM + totalL;

                                        document.getElementById('selected_quantity').value = totalSelectedQuantity;
                                        document.getElementById('selected_category_name').value = selectedCategoryNamesString;
                                        document.getElementById('total-price-display').innerHTML = 'ราคา ' + totalPrice.toFixed(2) + ' บาท';
                                        document.getElementById('total_price_input').value = totalPrice.toFixed(2);
                                    }

                                    document.addEventListener('DOMContentLoaded', function() {
                                        // เรียกใช้ calculatePrice() เมื่อหน้าเว็บโหลดเสร็จ
                                        calculatePrice();

                                    });
                                </script>

                            </div>
                        </div>
                    </div>
                    <!--  -->

                    <div class="container col-md-6">
                        <div class="form-row">
                            <label for="quantity" style="font-weight: bold; font-size: 24px; margin: 10px;">จำนวน</label>
                            <div class="1div">
                                <span class="minusS">-</span>
                                <input type="text" class="numtext" id="quantityS" value="0" onchange="calculatePrice('<?= $dataS['cate_name']; ?>')" readonly>
                                <span class="plusS">+</span>
                            </div>
                            <div class="2div">
                                <span class="minusM">-</span>
                                <input type="text" class="numtext" id="quantityM" value="0" onchange="calculatePrice('<?= $dataM['cate_name']; ?>')" readonly>
                                <span class="plusM">+</span>
                            </div>
                            <div class="3div">
                                <span class="minusL">-</span>
                                <input type="text" class="numtext" id="quantityL" value="0" onchange="calculatePrice('<?= $dataL['cate_name']; ?>')" readonly>
                                <span class="plusL">+</span>
                            </div>

                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                            <script>
                                $(document).ready(function() {
                                    $('.minusS').click(function() {
                                        var $input = $(this).next(); // Fix selector here
                                        var count = parseInt($input.val()) - 1;
                                        count = count < 0 ? 0 : count; // Changed 1 to 0 for minimum count
                                        $input.val(count);
                                        $input.change();
                                        return false;
                                    });
                                    $('.plusS').click(function() {
                                        var $input = $(this).prev();
                                        $input.val(parseInt($input.val()) + 1);
                                        $input.change();
                                        return false;
                                    });
                                    $('.minusM').click(function() {
                                        var $input = $(this).next();
                                        var count = parseInt($input.val()) - 1;
                                        count = count < 0 ? 0 : count;
                                        $input.val(count);
                                        $input.change();
                                        return false;
                                    });
                                    $('.plusM').click(function() {
                                        var $input = $(this).prev();
                                        $input.val(parseInt($input.val()) + 1);
                                        $input.change();
                                        return false;
                                    });
                                    $('.minusL').click(function() {
                                        var $input = $(this).next();
                                        var count = parseInt($input.val()) - 1;
                                        count = count < 0 ? 0 : count;
                                        $input.val(count);
                                        $input.change();
                                        return false;
                                    });
                                    $('.plusL').click(function() {
                                        var $input = $(this).prev();
                                        $input.val(parseInt($input.val()) + 1);
                                        $input.change();
                                        return false;
                                    });
                                });
                            </script>
                        </div>
                    </div>

                </div>
                <!--  -->
                <!-- HTML -->
                <div class="container col-md-11">
                    <div class="form-row">
                        <label class="custom-file-upload">
                            <input type="file" name="files[]" accept="image/gif, image/jpeg, image/png" multiple onchange="handleFileSelect(event, 'file-preview')" required>
                            <img src="images/เพิ่มรูป.png" style="width: 38px; height: 35px;"> แนบรูปภาพ
                        </label>
                        <div id="file-preview" class="file-preview"></div>
                    </div>

                    <div class="form-row">
                        <label class="custom-file-upload">
                            <input type="file" name="idcard_files" accept="image/gif, image/jpeg, image/png" onchange="handleFileSelect(event, 'file-preview-idcard')" required>

                            <img src="images/เพิ่มรูป.png" style="width: 38px; height: 35px;"> แนบรูปบัตรประชาชน
                        </label>
                        <div id="file-preview-idcard" class="file-preview"></div>
                    </div>
                </div>

                <script>
                    function handleFileSelect(event, previewId) {
                        const files = event.target.files;
                        const filePreviewContainer = document.getElementById(previewId);
                        filePreviewContainer.innerHTML = '';

                        if (files.length > 0) {
                            for (let i = 0; i < files.length; i++) {
                                const file = files[i];
                                const fileReader = new FileReader();
                                const filePreviewItem = document.createElement('div');
                                filePreviewItem.classList.add('file-preview-item');

                                if (file.type.match('image.*')) {
                                    const img = document.createElement('img');
                                    img.classList.add('file-preview-image');
                                    img.file = file;
                                    filePreviewItem.appendChild(img);

                                    fileReader.onload = (function(aImg, fileName) {
                                        return function(e) {
                                            aImg.src = e.target.result;
                                            const fileNameElement = document.createElement('span');
                                            fileNameElement.textContent = fileName;
                                            fileNameElement.classList.add('file-name'); // Add file-name class
                                            filePreviewItem.appendChild(fileNameElement);
                                        };
                                    })(img, file.name);
                                    fileReader.readAsDataURL(file);
                                } else {
                                    const fileNameElement = document.createElement('span');
                                    fileNameElement.textContent = file.name;
                                    filePreviewItem.appendChild(fileNameElement);
                                }

                                filePreviewContainer.appendChild(filePreviewItem);
                            }
                            // ซ่อนข้อความแจ้งเตือน
                            document.getElementById('file-upload-error').style.display = 'none';
                        } else {
                            // แสดงข้อความแจ้งเตือน
                            document.getElementById('file-upload-error').style.display = 'block';
                        }
                    }
                </script>
                <br>

                <!--  -->

                <div class="row" align='center'>

                    <h3>
                        <div name="total_price"></div>
                        <input type="hidden" id="total_price_input" name="total_price" value="0.00">
                    </h3>

                    <!--  -->
                    <?php
                    // ตรวจสอบว่ามีการเชื่อมต่อกับฐานข้อมูลหรือไม่
                    if ($conn) {
                        // สร้างคำสั่ง SQL เพื่อดึงข้อมูลร้านค้าจากตาราง market
                        $sql = "SELECT mk_name FROM market WHERE mk_id = '$storeCode'";
                        // ส่งคำสั่ง SQL ไปทำงาน
                        $result = mysqli_query($conn, $sql);
                        // ตรวจสอบว่ามีข้อมูลที่ได้จากการค้นหาหรือไม่
                        if (mysqli_num_rows($result) > 0) {
                            // ดึงข้อมูลร้านค้า
                            $data = mysqli_fetch_assoc($result);
                            // กำหนดค่าของ mk_name
                            $mk_name = $data['mk_name'];
                        } else {
                            // ถ้าไม่พบข้อมูลร้านค้า
                            $mk_name = "ไม่พบข้อมูลร้านค้า";
                        }
                    } else {
                        // ถ้าไม่สามารถเชื่อมต่อกับฐานข้อมูลได้
                        $mk_name = "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้";
                    }
                    ?>

                    <!-- สร้าง input hidden เพื่อส่งค่า mk_name -->
                    <input type="hidden" name="selected_market_name" value="<?= $mk_name; ?>">

                    <input type="hidden" name="selected_market_id" value="<?= $storeCode; ?>">
                    <!--  -->


                    <input type="hidden" name="selected_quantity" id="selected_quantity">
                    <input type="hidden" name="selected_category_name" id="selected_category_name">


                    <div class="card-submit">
                        <br>
                        <input type="submit" name="Submit" value="เพิ่มรายการ">
                    </div>
                </div>
            </div>
        </form>
        <!--  -->

    </div>
    <!-- End col-md-6 -->
</div>
<div class="container col-12">
    <form class="third-form">

        <br>
        <?php
        if (isset($_SESSION['reservation_date']) && isset($_SESSION['reservation_time']) && isset($_SESSION['retrieval_date']) && isset($_SESSION['retrieval_time'])) {
            $reserv_date = $_SESSION['reservation_date'];
            $reserv_time = $_SESSION['reservation_time'];
            $retrive_date = $_SESSION['retrieval_date'];
            $retrive_time = $_SESSION['retrieval_time'];
        ?>


            <div class="reservation-info">
                <div class="reservation-info green-text">เวลาในการฝาก <?= $reserv_date; ?> <span class="time">เวลา
                        <?= $reserv_time; ?></div>
                <div class="reservation-info red-text">เวลาในการรับคืน <?= $retrive_date; ?> <span class="time2">เวลา
                        <?= $retrive_time; ?></div>
            </div>
        <?php
        }
        ?>
        <style>
            .reservation-info {
                font-family: Arial, sans-serif;
                font-size: 22px;
                /* ปรับขนาดตัวอักษรตามต้องการ */
                line-height: 1.5;
                /* ปรับระยะห่างระหว่างบรรทัด */
                margin-left: 20px;
                /* จัดช่องไฟด้านล่าง */
            }

            .reservation-info .time {
                margin-left: 21%;
            }

            .reservation-info .time2 {
                margin-left: 20%;
            }

            .green-text {
                color: green;
            }

            .red-text {
                color: red;
            }
        </style>

        <div class="col-md-12">
            <?php
            $storeCode = $_GET['store'];
            ?>

            <div class="card-body" style="margin-left: 20px; margin-right: 20px;" id="cartItem">
                <!-- ส่วนของโค้ดที่ใช้แสดงตะกร้าสินค้า -->
                <?php
                $db = new ConnectDb();
                $conn = $db->getConn();
                $sql = "SELECT * FROM cart 
                        WHERE m_id = $m_id and mk_id = '$storeCode'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $category_name = $row['category_name'];
                        $quantity = $row['quantity'];
                        $price = $row['price'];
                ?>

                        <div class="row" style="margin-left: 10px;">
                            <div class="bag border">

                                <div class="col">
                                    <a class="text text-dark">
                                        <?php echo $category_name; ?>
                                    </a>
                                </div>
                                <div class="col text-center" style="margin-left: 15%;">
                                    <a class="text text-warning">จำนวน
                                        <?php echo $quantity; ?> ใบ
                                    </a>
                                </div>
                                <div class="col text-right" style="margin-left: 18%;">
                                    <a class="price text-success">ราคา
                                        <?php echo $price; ?> บาท
                                    </a>
                                </div>

                                <a href="?page=clear_cart&store=<?= $storeCode ?>&id=<?= $row['cart_id'] ?>" class="btn btn-danger btn-sm">ลบ</a>

                            </div>
                        </div>
                        <br>
                        <!--  -->

                <?php
                    }
                }
                ?>
                <!-- ส่วนของการส่งคำสั่งดำเนินการ -->
                <style>
                    .yellow-button {
                        background-color: #E5E71A;
                        border: black;
                        color: #000000;
                        padding: 10px 20px;
                        text-align: center;
                        text-decoration: none;
                        display: inline-block;
                        font-weight: bold;
                        /* ทำให้ข้อความเป็นตัวหนา */
                        font-size: 24px;
                        /* ปรับขนาดข้อความ */
                        margin: 4px 2px;
                        cursor: pointer;
                        border-radius: 4px;
                    }

                    .yellow-button:hover {
                        background-color: #ffc200;
                    }
                </style>

                <!--  -->
                <?php
                // เชื่อมต่อฐานข้อมูล
                $db = new ConnectDb();
                $conn = $db->getConn();

                // เตรียม SQL query
                $sql6 = "SELECT * FROM cart WHERE cart.m_id = $m_id AND cart.mk_id = '$storeCode'";

                $rs6 = mysqli_query($conn, $sql6);

                // เริ่มแถวใหม่
                echo '<div class="row" style="margin-left: 10px;">';

                // สร้าง array เพื่อเก็บชื่อ idcard ที่เคยแสดงแล้ว
                $already_shown_idcards = [];

                // แสดงข้อมูล idcard และรูปภาพที่ไม่ซ้ำ
                while ($data6 = mysqli_fetch_assoc($rs6)) {
                    $idcard = $data6['idcard'];

                    // ตรวจสอบว่า idcard นี้เคยแสดงไว้แล้วหรือไม่
                    if (!empty($idcard) && !in_array($idcard, $already_shown_idcards)) {
                        // ถ้ายังไม่ได้แสดง ให้เพิ่ม idcard เข้าไปในตัวแปรเพื่อระบุว่าได้แสดงไว้แล้ว

                        // แสดงรูป idcard
                ?>
                        <!-- รูปภาพ -->
                        <div class="col-md-2">
                            <img src="images/idcard/<?= $idcard; ?>" class="img-fluid" style="width: 50%; height: 55%;" alt="<?= $idcard; ?>">
                            <p><?= $idcard; ?></p>
                        </div>
                    <?php
                        $already_shown_idcards[] = $idcard;
                    }

                    // แยกชื่อรูปภาพทั้งหมดออกมาแล้วแสดงทั้งหมด
                    $pictures = preg_split('/,\s*"/', $data6['picture']);
                    foreach ($pictures as $picture) {
                        // ตัดเครื่องหมาย " ออกจากชื่อไฟล์
                        $picture = trim($picture, '"');
                    ?>
                        <!-- รูปภาพ -->
                        <div class="col-md-2">
                            <img src="images/<?php echo $picture; ?>" class="img-fluid " style="width: 50%; height: 55%;" alt="<?php echo $picture; ?>">
                            <p><?php echo $picture; ?></p>
                        </div>

                <?php
                    }
                }
                // ปิดแถว
                echo '</div>';
                ?>
                <!--  -->
                <?php
                // เชื่อมต่อฐานข้อมูล
                $db = new ConnectDb();
                $conn = $db->getConn();

                // เตรียม SQL query
                $sql7 = "SELECT SUM(price) AS total_price FROM cart WHERE cart.m_id = $m_id and cart.mk_id = '$storeCode'";

                $rs6 = mysqli_query($conn, $sql7);
                $data6 = mysqli_fetch_assoc($rs6);
                $sumprice = $data6['total_price'];
                ?>
                <label class="card-text">
                    <h3>
                        <div id="total-price-display" name="total_price"><b>ราคารวมทั้งสิ้น <?php echo $sumprice; ?>
                                บาท</b></div>
                        <input type="hidden" id="total_price_input" name="total_price" value="<?php echo $sumprice; ?>">
                    </h3>
                </label>
                <br>

                <!--  -->
                <div class="card-submit" align="center">
                    <a href="?page=reserv_new2" class="yellow-button">ดำเนินการ</a>
                </div>
                <!--  -->
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Function to handle form submission
        $('form').submit(function(e) {
            // Prevent the default form submission
            e.preventDefault();

            // Serialize the cartItems array to JSON
            var cartItemsJSON = JSON.stringify(cartItems);

            // Update the value of the hidden input field
            $('#cartItems').val(cartItemsJSON);

            // Submit the form
            this.submit();
        });

        function loadCartItems() {
            // ใช้ AJAX โหลดข้อมูลตะกร้าสินค้า
            $.ajax({
                url: "?page=reserv_new&store=<?= $storeCode ?>", // URL ที่ใช้โหลดข้อมูล
                type: "GET",
                success: function(response) {
                    // นำข้อมูลที่โหลดมาแสดงที่ส่วนที่กำหนดไว้
                    $("#cartItem").html($(response).find("#cartItem").html());
                }
            });
        }

        // โหลดรายการสินค้าเมื่อหน้าเว็บโหลด
        loadCartItems();

        // สร้าง setInterval เพื่อโหลดข้อมูลใหม่ทุกๆ 10 วินาที
        setInterval(function() {
            loadCartItems();
        }, 10000);
    });
</script>

<!-- css -->
<style>
    .text,
    .price {
        color: black;
        /* เปลี่ยนสีของตัวหนังสือเป็นสีดำ */
        text-decoration: none;
        /* ไม่มีเส้นใต้ข้อความ */
    }

    .bag {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        height: 100%;
    }
</style>

<!--  -->
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['selected_market_id'], $_POST['datersev'], $_POST['rsevtime'], $_POST['dateretr'], $_POST['retrtime'], $_POST['selected_category_name'], $_POST['selected_quantity'], $_POST['total_price'])) {

        // Establish database connection (assuming $conn is your connection variable)

        // กำหนดค่าที่จำเป็นสำหรับ insert ลงในฐานข้อมูล
        $mk_id = mysqli_real_escape_string($conn, $_POST['selected_market_id']);
        $reserv_date = mysqli_real_escape_string($conn, $_POST['datersev']);
        $reserv_time = mysqli_real_escape_string($conn, $_POST['rsevtime']);
        $retrive_date = mysqli_real_escape_string($conn, $_POST['dateretr']);
        $retrive_time = mysqli_real_escape_string($conn, $_POST['retrtime']);
        $selected_category_name = mysqli_real_escape_string($conn, $_POST['selected_category_name']);
        $selected_quantity = mysqli_real_escape_string($conn, $_POST['selected_quantity']);
        $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);

        // Check if files are uploaded
        if (isset($_FILES['files']) && is_array($_FILES['files']['name']) && is_array($_FILES['files']['tmp_name']) && count($_FILES['files']['name']) > 0) {
            // Upload directory for pictures
            $upload_directory = 'images/';
            // File data for pictures
            $file_names = $_FILES['files']['name'];
            $file_tmp_names = $_FILES['files']['tmp_name'];
            $picture_names = array();

            // Loop through each file for pictures
            for ($i = 0; $i < count($file_names); $i++) {
                $file_name = mysqli_real_escape_string($conn, $file_names[$i]); // Set $file_name
                $file_tmp_name = $file_tmp_names[$i]; // Set $file_tmp_name

                // Move the file to the desired directory
                if (move_uploaded_file($file_tmp_name, $upload_directory . $file_name)) {
                    $picture_names[] = $file_name;
                } else {
                    echo "<script>alert('Failed to move file: $file_name');</script>";
                }
            }

            // Check if there are any pictures to insert
            if (!empty($picture_names)) {
                // Combine file names with commas for pictures
                $picture_names_combined = implode('","', $picture_names);

                // ตรวจสอบการแนบไฟล์รูป idcard
                if (isset($_FILES['idcard_files'])) {
                    // Upload directory for idcard
                    $idcard_upload_directory = 'images/idcard/';
                    // File data for idcard
                    $idcard_file_name = $_FILES['idcard_files']['name'];
                    $idcard_file_tmp_name = $_FILES['idcard_files']['tmp_name'];

                    // Move the file to the desired directory
                    if (move_uploaded_file($idcard_file_tmp_name, $idcard_upload_directory . $idcard_file_name)) {
                        // Insert data into database for idcard
                        $sql_idcard = "INSERT INTO cart (mk_id, m_id, reserv_date, reserv_time, retrive_date, retrive_time, category_name, quantity, price, picture, idcard) 
                    VALUES ('$mk_id', $m_id, '$reserv_date', '$reserv_time', '$retrive_date', '$retrive_time', '$selected_category_name', '$selected_quantity', '$total_price', '$picture_names_combined', '$idcard_file_name')";

                        mysqli_query($conn, $sql_idcard);

                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            echo "<script>alert('บันทึกสำเร็จ');</script>";
                        } else {
                            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                        }
                    } else {
                        echo "<script>alert('No files were uploaded');</script>";
                    }
                } else {
                    echo "<script>alert('No files were uploaded or the files array is not properly formatted');</script>";
                }
            } else {
                echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');</script>";
            }
        }
    }
}
?>
<!-- End col-md-12 -->
</div>

<!-- css -->

<style>
    .container {
        display: flex;
        padding: 10px;
        justify-content: space-between;
        /* จัดฟอร์มและสถานที่รับฝากอยู่ด้านขวาและซ้ายของพื้นที่ flex */
    }

    .container form {
        width: 100%;
        /* กำหนดความกว้างของฟอร์ม */
    }

    form {
        position: relative;
        /* ต้องเพิ่ม position: relative เพื่อให้สามารถใช้ position: absolute บนส่วนของ form */
        width: 45%;
        margin: 0;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        margin-top: 100px;
        /* เพิ่มระยะห่างด้านขวาของฟอร์ม */
        border: 1px solid black;
        /* เพิ่มเส้นขอบและกำหนดสีดำ */

    }

    .first-form::before {
        content: "สถานที่ฝากที่เลือก";
        text-align: center;
        position: absolute;
        /* ตั้งค่าให้เป็น absolute เพื่อให้สามารถจัดตำแหน่งได้ */
        top: -30px;
        /* ปรับตำแหน่งให้อยู่บนสุดของ form */
        left: 50%;
        /* ให้ข้อความอยู่ตรงกลาง */
        transform: translateX(-50%);
        /* จัดให้อยู่ตรงกลางแนวนอน */
        padding: 10px;
        width: 100.3%;
        font-size: 24px;
        background-color: #121139;
        color: #FFFFFF;
        /* สีข้อความ */
        border-top-left-radius: 10px;
        /* ปรับ radius ด้านบนซ้าย */
        border-top-right-radius: 10px;
        /* ปรับ radius ด้านบนขวา */
        border-bottom-right-radius: 0;
        /* ปรับให้ด้านล่างขวาเป็นเรียบ */
        border-bottom-left-radius: 0;
        /* ปรับให้ด้านล่างซ้ายเป็นเรียบ */
        border: 1px solid black;
        /* เพิ่มเส้นขอบและกำหนดสีดำ */
    }

    .second-form::before {
        content: "กรุณาเลือกวันที่และเวลา";
        text-align: center;
        position: absolute;
        /* ตั้งค่าให้เป็น absolute เพื่อให้สามารถจัดตำแหน่งได้ */
        top: -30px;
        /* ปรับตำแหน่งให้อยู่บนสุดของ form */
        left: 50%;
        /* ให้ข้อความอยู่ตรงกลาง */
        transform: translateX(-50%);
        /* จัดให้อยู่ตรงกลางแนวนอน */
        padding: 10px;
        width: 100.3%;
        font-size: 24px;
        background-color: #121139;
        color: #FFFFFF;
        /* สีข้อความ */
        border-top-left-radius: 10px;
        /* ปรับ radius ด้านบนซ้าย */
        border-top-right-radius: 10px;
        /* ปรับ radius ด้านบนขวา */
        border-bottom-right-radius: 0;
        /* ปรับให้ด้านล่างขวาเป็นเรียบ */
        border-bottom-left-radius: 0;
        /* ปรับให้ด้านล่างซ้ายเป็นเรียบ */
        border: 1px solid black;
        /* เพิ่มเส้นขอบและกำหนดสีดำ */
    }

    .third-form::before {
        content: "รายการสัมภาระ";
        text-align: center;
        position: absolute;
        /* ตั้งค่าให้เป็น absolute เพื่อให้สามารถจัดตำแหน่งได้ */
        top: -30px;
        /* ปรับตำแหน่งให้อยู่บนสุดของ form */
        left: 50%;
        /* ให้ข้อความอยู่ตรงกลาง */
        transform: translateX(-50%);
        /* จัดให้อยู่ตรงกลางแนวนอน */
        padding: 10px;
        width: 100.3%;
        font-size: 24px;
        background-color: #121139;
        color: #FFFFFF;
        /* สีข้อความ */
        border-top-left-radius: 10px;
        /* ปรับ radius ด้านบนซ้าย */
        border-top-right-radius: 10px;
        /* ปรับ radius ด้านบนขวา */
        border-bottom-right-radius: 0;
        /* ปรับให้ด้านล่างขวาเป็นเรียบ */
        border-bottom-left-radius: 0;
        /* ปรับให้ด้านล่างซ้ายเป็นเรียบ */
        border: 1px solid black;
        /* เพิ่มเส้นขอบและกำหนดสีดำ */
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="email"],
    input[type="tel"],
    textarea {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    /* เลือกกระเป๋าจอง */
    input[type="date"],
    textarea {
        border: 1px solid #000;
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        width: 270px;
        height: 50px;
        cursor: pointer;
    }

    input[type="time"],
    textarea {
        border: 1px solid #000;
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        width: 270px;
        height: 50px;
        cursor: pointer;
    }

    input[type="text4"],
    textarea {
        border: 1px solid #000;
        border-radius: 0.5rem;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        width: 270px;
        height: 45px;
        cursor: pointer;
    }

    /* CSS */
    input[type="submit"] {
        background-color: #E5E71A;
        color: #000000;
        padding: 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: bold;
        /* ทำให้ข้อความเป็นตัวหนา */
        font-size: 24px;
        /* ปรับขนาดข้อความ */
        margin-top: -15px;
    }

    input[type="submit"]:hover {
        background-color: #ffc200;
    }

    .custom-file-upload {
        border: 1px solid #000;

        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        height: 50px;
        width: 270px;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
        background-color: #f8f9fa;
        color: #212529;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
        margin-left: -20px;
        margin-right: 75px;
    }

    .file-preview {
        margin-top: 10px;
        display: flex;
        flex-wrap: wrap;
    }

    .file-preview-item {
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .file-preview-item img {
        max-width: 100px;
        max-height: 100px;
        margin-bottom: 5px;
    }

    .file-name {
        display: block;
        margin-top: 5px;
        font-size: 14px;
        text-align: center;
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

    .card-text {
        font-size: 20px;
        /* ปรับขนาดข้อความ */
        padding: 5px 6px;
        border-radius: 5px;
        width: 50%;
        margin: 0 auto;
        /* จัดให้อยู่กึ่งกลางตามแนวนอน */
        text-align: center;
        /* จัดให้ข้อความอยู่กึ่งกลางตามแนวนอน */
    }

    /* cart */

    /*  */
    span {
        cursor: pointer;
    }

    .number {
        margin: 100px;
    }

    .minusS,
    .minusM,
    .minusL,
    .plusS,
    .plusM,
    .plusL {
        width: 40px;
        height: 35px;
        background: #f7f420;
        border-radius: 15px;
        border: 1px solid #ddd;
        display: inline-block;
        text-align: center;
        font-size: larger;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .numtext {
        height: 40px;
        width: 110px;
        text-align: center;
        font-size: 20px;
        font-weight: 700;
        border: none;
        outline: none;
        vertical-align: middle;
        display: inline-block;
        margin-bottom: 0.3rem;
        margin-left: 37px;
        margin-right: 37px;
    }

    .catetext {
        display: inline-block;
        margin-bottom: 1rem;
    }

    .catetext input::placeholder {
        text-align: center;
    }
</style>