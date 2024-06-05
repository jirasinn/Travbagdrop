<?php
require_once('../libs/connect.class.php');
session_start();

$mk_id = $_SESSION['bagdrop_member_id'];
$mk_name = $_SESSION['bagdrop_member_name'];

$db = new ConnectDb();
$conn = $db->getConn();
if (isset($_POST['bag_id'])) {

    $bag_id = $_POST['bag_id'];
    $mk_name = $_SESSION['mkname'];

    $sql = "SELECT * FROM bagreserv 
    JOIN register ON register.m_id = bagreserv.m_id 
    WHERE bagreserv.bag_id = '$bag_id' 
    AND bagreserv.mk_name LIKE '$mk_name' 
    AND status = 'รอดำเนินการ' ";
    $result = $conn->query($sql);

    // Check if there are rows returned by the query
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        echo '<div class="d-flex align-items-center" style="margin:10px 0 10px 0;">';
        echo '<a onclick="showContent(\'noti\', \'noti-link\')"><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>';
        echo '<div class="flex-grow-1 text-center">';
        echo '<h4 style="font-weight:900; ">รายการจองออนไลน์</h4>';
        echo '</div>';
        echo '</div>';

        echo '<div class="depo-container">';

        echo '<div class="col-11">';
        echo '<div class="depo-drop">ชื่อผู้ฝาก : ' . '<span style="color:#808000">'  .  $row["m_fname"] . ' ' . $row["m_lname"] . '</span>' . '</div>';
        echo '<div class="depo-drop">Email : ' . '<span style="color:#808000">' . $row["m_email"] . '</span>' . '</div>';
        echo '<div class="depo-drop">ประเทศ : ' . '<span style="color:#808000">' .  $row["m_ctry"] . '</span>' . '</div>';
        echo '<div class="depo-drop">เบอร์โทรศัพท์ : ' . '<span style="color:#808000">' .  $row["m_phone"] . '</span>' . '</div>';
        echo '<div class="depo-drop">สถานะกระเป๋า : ' .  '<span style="color:#808000">' . $row["status"] . '</span>' . '</div>';
        echo '<div class="depo-drop">สถานที่รับฝาก : ' .  '<span style="color:#808000">' . $row["mk_name"] . '</span>' . '</div>';
        echo '<div class="depo-drop">ประเภทกระเป๋า : ' . '<span style="color:#808000">' .  $row["category_name"] . '</span>' . '</div>';
        echo '<div class="depo-drop">จำนวนกระเป๋า : ' . '<span style="color:#808000">' .  $row["quantity"] . '</span>' . '</div>';
        echo '<div class="depo-drop" id="tracking">Tracking :</div>';
        echo '<div style="display:none;" id="trackingId"></div>';
        echo '</div>'; //col-12

        echo '<div style="display: grid; grid-template-columns: auto;">
                        <div style="display: flex;  ">
                        <div class="card" style="background-color: #d9d9d9;  ">
                            <img class="depo-img" src="images/บัตร.png" style="width: 100px; padding: 10px;">
                            <div class="card-body" style="background-color: white; height:fit-content;">
                                <div class="upload-btn-wrapper">
                                    <button class="file-btn">เพิ่มรูปภาพบัตรประชาชนหรือหนังสือเดินทาง</button>
                                    <input type="file" name="file" accept="image/gif, image/jpeg, image/png">
                                </div>
                            </div>
                        </div>
                            <div class="card" style="background-color: #d9d9d9;  ">
                                <img class="depo-img" src="images/กล่อง.png" style="width: 100px; padding: 10px; ">
                                <div class="card-body" style="background-color: white;">
                                    <div class="upload-btn-wrapper">
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#trackModal" class="file-btn" >เลือกช่องเก็บกระเป๋า</button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="trackModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content custom-modal-background">
                                <div class="modal-header"">
                                <h3 style="color: white; margin: 0 auto;"><b>เลือกที่เก็บกระเป๋า</b></h3>
                                <a data-bs-dismiss="modal"><img src="images/cross.png" style="width:25px;height:25px;"></a>
                            </div>
                                    <div class="modal-body" >
                                    <div style="display:flex;  justify-content:space-between; ">
                                    <div id="trackA" style="text-align:center; background-color:white; padding: 10px; flex: auto; margin:0 2.5px 0 0">  
                                    <h4>ขนาด 16-21 นิ้ว</h4>
                                    <div style="display:flex;  justify-content:space-around ;">
                                    <button type="button" id="A1" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A1</button>
                                    <button type="button" id="A2" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A2</button>
                                    <button type="button" id="A3" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A3</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="A4" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A4</button>
                                    <button type="button" id="A5" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A5</button>
                                    <button type="button" id="A6" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A6</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="A7" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A7</button>
                                    <button type="button" id="A8" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A8</button>
                                    <button type="button" id="A9" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A9</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="A10" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A10</button>
                                    <button type="button" id="A11" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A11</button>
                                    <button type="button" id="A12" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A12</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="A13" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A13</button>
                                    <button type="button" id="A14" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A14</button>
                                    <button type="button" id="A15" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A15</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="A16" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A16</button>
                                    <button type="button" id="A17" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A17</button>
                                    <button type="button" id="A18" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A18</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px; margin-bottom: 5px;">
                                    <button type="button" id="A19" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A19</button>
                                    <button type="button" id="A20" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A20</button>
                                    <button type="button" id="A21" onclick="toggleClicked(\'A\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">A21</button>
                                    </div>
                                    <div >
                                    <h5 id="countA">จำนวน</h5>
                                    <h6 id="trackingA"></h6>
                                    </div>
                                    </div>
                                    
                                    <div id="trackB" style="text-align:center; background-color:white; padding: 10px; flex: auto; margin:0 2.5px 0 2.5px">  
                                    <h4>ขนาด 24-26 นิ้ว</h4>
                                    <div style="display:flex;  justify-content:space-around ;">
                                    <button type="button" id="B1" onclick="toggleClicked(\'B\', this)"  style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B1</button>
                                    <button type="button" id="B2" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B2</button>
                                    <button type="button" id="B3" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B3</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="B4" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B4</button>
                                    <button type="button" id="B5" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B5</button>
                                    <button type="button" id="B6" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B6</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="B7" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B7</button>
                                    <button type="button" id="B8" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B8</button>
                                    <button type="button" id="B9" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B9</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="B10" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B10</button>
                                    <button type="button" id="B11" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B11</button>
                                    <button type="button" id="B12" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B12</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="B13" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B13</button>
                                    <button type="button" id="B14" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B14</button>
                                    <button type="button" id="B15" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B15</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="B16" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B16</button>
                                    <button type="button" id="B17" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B17</button>
                                    <button type="button" id="B18" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B18</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px; margin-bottom: 5px;">
                                    <button type="button" id="B19" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B19</button>
                                    <button type="button" id="B20" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B20</button>
                                    <button type="button" id="B21" onclick="toggleClicked(\'B\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">B21</button>
                                    </div>
                                    <h5 id="countB">จำนวน</h5>
                                    <h6 id="trackingB"></h6>
                                    </div>
                                    
                                    <div id="trackC" style="text-align:center; background-color:white; padding: 10px; flex: auto; margin:0 0 0 2.5px">  
                                    <h4>ขนาด 29-32 นิ้ว</h4>
                                    <div style="display:flex;  justify-content:space-around ;">
                                    <button type="button" id="C1" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C1</button>
                                    <button type="button" id="C2" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C2</button>
                                    <button type="button" id="C3" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C3</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="C4" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C4</button>
                                    <button type="button" id="C5" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C5</button>
                                    <button type="button" id="C6" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C6</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="C7" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C7</button>
                                    <button type="button" id="C8" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C8</button>
                                    <button type="button" id="C9" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C9</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="C10" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C10</button>
                                    <button type="button" id="C11" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C11</button>
                                    <button type="button" id="C12" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C12</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="C13" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C13</button>
                                    <button type="button" id="C14" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C14</button>
                                    <button type="button" id="C15" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C15</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px;">
                                    <button type="button" id="C16" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C16</button>
                                    <button type="button" id="C17" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C17</button>
                                    <button type="button" id="C18" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C18</button>
                                    </div>
                                    <div style="display:flex;  justify-content:space-around ; margin-top: 5px; margin-bottom: 5px;">
                                    <button type="button" id="C19" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C19</button>
                                    <button type="button" id="C20" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C20</button>
                                    <button type="button" id="C21" onclick="toggleClicked(\'C\', this)" style="padding: 5px; height: 50px; width: 50px; border-radius: 50%; ">C21</button>
                                    </div>
                                    <h5 id="countC">จำนวน</h5>
                                    <h6 id="trackingC"></h6>
                                    </div>
                                    <script>
                                    var clickedButtonsA = [];
                                    var clickedButtonsB = [];
                                    var clickedButtonsC = [];
                                  
                                    function toggleClicked(group, button) {
                                        var buttonText = button.textContent;
                                        var buttonId = button.id;
                                        
                                        // Toggle the clicked state
                                        button.classList.toggle("clicked");
                                
                                        switch (group) {
                                            case "A":
                                                if (clickedButtonsA.includes(buttonId)) {
                                                    clickedButtonsA = clickedButtonsA.filter(id => id !== buttonId);
                                                } else {
                                                    clickedButtonsA.push(buttonId);
                                                }
                                                document.getElementById("trackingA").textContent = clickedButtonsA.join(" ");
                                                document.getElementById("countA").textContent = "จำนวน " + clickedButtonsA.length + " ใบ";
                                                break;
                                            case "B":
                                                if (clickedButtonsB.includes(buttonId)) {
                                                    clickedButtonsB = clickedButtonsB.filter(id => id !== buttonId);
                                                } else {
                                                    clickedButtonsB.push(buttonId);
                                                }
                                                document.getElementById("trackingB").textContent = clickedButtonsB.join(" ");
                                                document.getElementById("countB").textContent = "จำนวน " + clickedButtonsB.length + " ใบ";
                                                break;
                                            case "C":
                                                if (clickedButtonsC.includes(buttonId)) {
                                                    clickedButtonsC = clickedButtonsC.filter(id => id !== buttonId);
                                                } else {
                                                    clickedButtonsC.push(buttonId);
                                                }
                                                document.getElementById("trackingC").textContent = clickedButtonsC.join(" ");
                                                document.getElementById("countC").textContent = "จำนวน " + clickedButtonsC.length + " ใบ";
                                                break;
                                            default:
                                                break;
                                        }
                                        var trackingContent = [];
                                            if (clickedButtonsA.length > 0) {
                                                trackingContent.push(clickedButtonsA.join(", "));
                                            }
                                            if (clickedButtonsB.length > 0) {
                                                trackingContent.push(clickedButtonsB.join(", "));
                                            }
                                            if (clickedButtonsC.length > 0) {
                                                trackingContent.push(clickedButtonsC.join(", "));
                                            }
                                            document.getElementById("tracking").textContent = "Tracking : " + trackingContent.join(", ");
                                            document.getElementById("trackingId").textContent = trackingContent.join(", ");
                                            
                                    }

                                    function insertDataIntoDatabase() {
                                        var trackingData = document.getElementById("tracking").textContent;
                                        var bag_id = document.getElementById("bag_id").value;
                                        var trackingId = document.getElementById("trackingId").textContent; 
                                        var xhr = new XMLHttpRequest();
                                    
                                        xhr.open("POST", "crud/insert_tracking.php", true);
                                    
                                        // Set the Content-Type header
                                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                                    
                                        // Define the callback function to handle the server response
                                        xhr.onreadystatechange = function () {
                                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                                if (xhr.status === 200) {
                                                    console.log("Success to insert data into database.");
                                                    fetchDatatoarray(trackingId); 
                                                } else {
                                                    // Request failed, handle error
                                                    console.error("Failed to insert data into database.");
                                                }
                                            }
                                        };
                                    
                                        // Prepare the data to be sent
                                        var data = "bag_id=" + encodeURIComponent(bag_id) + "&tracking_data=" + encodeURIComponent(trackingData);
                                    
                                        // Send the request with the data
                                        xhr.send(data);
                                    }

                                    function fetchDatatoarray() {
                                        var xhr = new XMLHttpRequest();
                                        xhr.open("GET", "crud/fetch_tracking.php", true);
                                        xhr.onreadystatechange = function () {
                                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                                if (xhr.status === 200) {
                                                    var responseData = JSON.parse(xhr.responseText);
                                                    for (var i = 0; i < responseData.length; i++) {
                                                        var trackingData = responseData[i];
                                                        var trackingIDs = trackingData.tracking.split(",").map(item => item.trim());
                                                        var mk_name = trackingData.mk_name;
                                                        trackingIDs.forEach(function(trackingID) {
                                                            var buttonElement = document.getElementById(trackingID);
                                                            if (buttonElement) {
                                                                buttonElement.style.backgroundColor = "red";
                                                                buttonElement.classList.remove("clicked");
                                                                console.log("Tracking ID " + trackingID + " matches data from the database.");
                                                            } else {
                                                                console.log("Button with ID " + trackingID + " was not found.");
                                                            }
                                                        });
                                                    }
                                                } else {
                                                    console.error("Failed to fetch data from the database.");
                                                }
                                            }
                                        };
                                        xhr.send();
                                    }
                                    
                                    
                                    
                                    $(document).ready(function() {
                                        $("#trackModal").on("shown.bs.modal", function () {
                                            // Retrieve the trackingId from localStorage
                                            var trackingId = localStorage.getItem("trackingId");
                                            
                                            // Set the trackingId in the trackingId element
                                            document.getElementById("trackingId").textContent = trackingId;
                                            
                                            fetchDatatoarray(); // Fetch data using the retrieved trackingId
                                        });
                                    });
                                            
                                            function updateNoti(contentId, clickedLinkId) {       
                                                // Show the selected content immediately
                                                $(".row.col-9 > *").hide();
                                                $("#" + contentId).show();
                                                
                                                $(".nav-link").removeClass("active");
                                                $("#" + clickedLinkId).addClass("active");
                                                refreshContent(contentId);
                                            }

                                            function refreshContent(contentId) {
                                                $.ajax({
                                                    type: "GET",
                                                    url: "crud/refreshNoti.php",
                                                    success: function(response) {
                                                        if ($("#noti").length) {
                            
                                                            $("#noti").html(response);
                                                        } else {
                                                            console.error("noti div not found");
                                                        }
                                                    },
                                                    error: function(xhr, status, error) {
                            
                                                        console.error(xhr.responseText);
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" name="cfTracking"  class="depo-btn" data-bs-dismiss="modal" >ยืนยัน</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>';
        echo "<script>
            var market_name = '$mk_name';
            </script>";

        echo '<div class="col" style="margin-top: 5vh; justify-self:center;">';
        echo '<div class="card" style="background-color: #d9d9d9;">';
        $baseUrl = 'http://localhost/Travbagdrop/images/';
        $filenameFromDB = isset($row['picture']) ? $row['picture'] : ''; // Check if $row['picture'] is set
        $filenames = json_decode($filenameFromDB, true); // Ensure associative array
        if ($filenames && is_array($filenames) && count($filenames) >= 2) { // Check if $filenames is an array and has 2 or more elements
            $slideshowId = uniqid(); // Generate a unique ID for the slideshow
            echo '<div id="slideshow-' . $slideshowId . '" class="carousel slide" data-ride="carousel">'; // Add unique ID to slideshow
            echo '<div class="carousel-inner">';
            $first = true;
            foreach ($filenames as $index => $filename) {
                // Replace plus signs with spaces
                $filename = str_replace('+', ' ', $filename);
                // Decode URL encoding
                $filename = urldecode($filename);
                // Encode filename for URL
                $encodedFilename = rawurlencode($filename);
                // Construct the full image URL
                $imageUrl = $baseUrl . $encodedFilename;

                if ($first) {
                    echo '<div class="carousel-item active"  id="slide-' . $index . '">'; // Change id to slide-
                    $first = false;
                } else {
                    echo '<div class="carousel-item"  id="slide-' . $index . '">'; // Change id to slide-
                }
                echo '<img class="d-block w-100" src="' . htmlspecialchars($imageUrl) . '" alt="Slide">'; // Sanitize imageUrl
                echo '</div>';
            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="prev" id="prevBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="next" id="nextBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';
        } else {
            if ($filenames) {
                foreach ($filenames as $filename) {
                    // Replace plus signs with spaces
                    $filename = str_replace('+', ' ', $filename);
                    // Decode URL encoding
                    $filename = urldecode($filename);
                    // Encode filename for URL
                    $encodedFilename = rawurlencode($filename);
                    // Construct the full image URL
                    $imageUrl = $baseUrl . $encodedFilename;
                    echo '<img class="depo-img" src="' . htmlspecialchars($imageUrl) . '" height="250" width="250"/>'; // Sanitize imageUrl
                    // Display only the first image
                    break;
                }
            }
        }
        echo '<div class="card-body" style="background-color: white;"> </div>';
        echo '</div>'; //card

        echo '</div>'; //col7
        echo '<div style="margin-top: 5vh;">';
        echo '<input type="hidden" id="bag_id" name="bag_id" value="' . $_POST['bag_id'] . '">';
        echo '<button type="button" name="Sub"  class="depo-btn"  onclick="updateNoti(\'noti\', \'noti-link\'); insertDataIntoDatabase();" >ยืนยัน</button>';
        echo '<button type="button" name="cancle"  class="depo-ccl" >ยกเลิก</button>';
        echo '</div>';
        echo '</div>';
        echo '</div>'; //container
    }

    $sql2 = "SELECT * FROM bagreserv 
    JOIN register ON register.m_id = bagreserv.m_id 
    WHERE bagreserv.bag_id = '$bag_id' 
    AND bagreserv.mk_name LIKE '$mk_name' 
    AND  status = 'คืนสำเร็จ' ";
    $result = $conn->query($sql2);

    // Check if there are rows returned by the query
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        echo '<a  onclick="showContent(\'noti\', \'noti-link\')"><img src="images/leftarrow.png" style="width:40px;height:40px; margin-bottom:10px;"></a>';
        echo '<div class="container" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding:0; border-radius: 10px 10px 0 0 ">';

        echo '<div class="all_order">';
        echo '<div class="row" >';

        // First Column
        echo '<div class="col" style=" background-color: #f7f420; box-shadow:  5px 5px 5px #c4c4c4; margin-left: 10px; margin-right: 10px;  margin-bottom: 2rem; border-radius: 10px 10px 0 0 ">';
        echo '<div class="all-group d-flex align-items-center justify-content-center">';
        echo '<h5><b>' .  '<span class="order">ออเดอร์หมายเลข: ' . $row["order_number"] . '</span>' . '</b></h5>' . '<h6 class="bag_count d-flex align-items-center justify-content-center"><b>' . 'เหลือเวลาอีก' . '<br>' . '<span style="color:#f20000; font-size: 18px;">' . '0น.' . '</span>' . '</b></h6>';
        echo '</div>';
        echo '</div>'; // Close col-lg-12 for first column

        echo '</div>'; // Close row

        // Second and Third Columns Side by Side
        echo '<div class="row">';

        // Second Column
        echo '<div class="col-6" style="height: 500px; margin-bottom: 2rem; ">';
        echo '<form action="" method="post">';
        echo '<div class="all-btn">ชื่อผู้ฝาก: <span style="color:#808000">' . $row["m_fname"] . ' ' . $row["m_lname"] . '</span></div>';
        echo '<div class="all-btn">Email: <span style="color:#808000">' . $row["m_email"] . '</span></div>';
        echo '<div class="all-btn">เลขบัตรประชาชน/หนังสือเดินทาง: <span style="color:#808000">' . $row["m_passport"] . '</span></div>';
        echo '<div class="all-btn">ประเทศ: <span style="color:#808000">' . $row["m_ctry"] . '</span></div>';
        echo '<div class="all-btn">สถานที่รับฝาก : ' .  '<span style="color:#808000">' . $row["mk_name"] . '</span>' . '</div>';
        echo '<div class="all-btn">เบอร์โทรศัพท์: <span style="color:#808000">' . $row["m_phone"] . '</span></div>';
        echo '<div class="all-btn">ประเภทกระเป๋า : ' . '<span style="color:#808000">' .  $row["category_name"] . '</span>' . '</div>';
        echo '<div class="all-btn">สถานะกระเป๋า: <span style="color:#808000">' . $row["status"] . '</span></div>';
        echo '</div>'; // Close col-lg-6 for second column

        // Third Column
        echo '<div class="col-6 d-flex flex-column align-items-end" style="height: 500px; margin-bottom: 2rem">';
        echo '<h5 class="card_all d-flex align-items-center justify-content-center"><b>' . 'รับคืนสำเร็จ' . '</b></h5>';
        echo '<div class="card" style="background-color: #d9d9d9; margin: auto;">';
        $baseUrl = 'http://localhost/Travbagdrop/images/';
        $filenameFromDB = isset($row['picture']) ? $row['picture'] : ''; // Check if $row['picture'] is set
        $filenames = json_decode($filenameFromDB, true); // Ensure associative array
        if ($filenames && is_array($filenames) && count($filenames) >= 2) { // Check if $filenames is an array and has 2 or more elements
            $slideshowId = uniqid(); // Generate a unique ID for the slideshow
            echo '<div id="slideshow-' . $slideshowId . '" class="carousel slide" data-ride="carousel">'; // Add unique ID to slideshow
            echo '<div class="carousel-inner">';
            $first = true;
            foreach ($filenames as $index => $filename) {
                // Replace plus signs with spaces
                $filename = str_replace('+', ' ', $filename);
                // Decode URL encoding
                $filename = urldecode($filename);
                // Encode filename for URL
                $encodedFilename = rawurlencode($filename);
                // Construct the full image URL
                $imageUrl = $baseUrl . $encodedFilename;

                if ($first) {
                    echo '<div class="carousel-item active"  id="slide-' . $index . '">'; // Change id to slide-
                    $first = false;
                } else {
                    echo '<div class="carousel-item"  id="slide-' . $index . '">'; // Change id to slide-
                }
                echo '<img class="d-block w-100" src="' . htmlspecialchars($imageUrl) . '" alt="Slide">'; // Sanitize imageUrl
                echo '</div>';
            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="prev" id="prevBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="next" id="nextBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';
        } else {
            if ($filenames) {
                foreach ($filenames as $filename) {
                    // Replace plus signs with spaces
                    $filename = str_replace('+', ' ', $filename);
                    // Decode URL encoding
                    $filename = urldecode($filename);
                    // Encode filename for URL
                    $encodedFilename = rawurlencode($filename);
                    // Construct the full image URL
                    $imageUrl = $baseUrl . $encodedFilename;
                    echo '<img class="depo-img" src="' . htmlspecialchars($imageUrl) . '" height="250" width="250"/>'; // Sanitize imageUrl
                    // Display only the first image
                    break;
                }
            }
        }
        echo '<div class="card-body" style="background-color: white;"></div>';
        echo '</div>';
        echo '</div>';

        echo '</div>'; // Close row
        echo '</div>'; // Close all_order div
        echo '</div>'; // Close container
    }

    $sql3 = "SELECT * FROM bagreserv 
    JOIN register ON register.m_id = bagreserv.m_id 
    WHERE bagreserv.bag_id = '$bag_id' 
    AND bagreserv.mk_name LIKE '$mk_name' 
    AND  status = 'ฝากสำเร็จ' ";
    $result = $conn->query($sql3);

    // Check if there are rows returned by the query
    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();
        echo '<a onclick="showContent(\'noti\', \'noti-link\')"><img src="images/leftarrow.png" style="width:40px;height:40px; margin-bottom:10px;"></a>';
        echo '<div class="container" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); padding:0; border-radius: 10px 10px 0 0 ">';
        echo '<div class="all_order">'; // Start all_order div here
        echo '<div class="row">';

        // First Column
        echo '<div class="col" style=" background-color: #f7f420; box-shadow:  5px 5px 5px #c4c4c4; margin-left: 10px; margin-right: 10px;  margin-bottom: 2rem; border-radius: 10px 10px 0 0 ">';
        echo '<div class="all-group d-flex align-items-center justify-content-center">';
        echo '<h5><b>' .  '<span class="order">ออเดอร์หมายเลข: ' . $row["order_number"] . '</span>' . '</b></h5>' . '<h6 class="bag_count d-flex align-items-center justify-content-center"><b>' . 'เหลือเวลาอีก' . '<br>' . '<span style="color:#f20000; font-size: 18px;">' . '2 วัน 10 ชั่วโมง' . '</span>' . '</b></h6>';
        echo '</div>';
        echo '</div>'; // Close col-lg-12 for first column

        echo '</div>'; // Close row

        // Second and Third Columns Side by Side
        echo '<div class="row">';

        // Second Column
        echo '<div class="col-6" style="height: 500px; margin-bottom: 2rem; ">';
        echo '<form action="" method="post">';
        echo '<div class="all-btn">ชื่อผู้ฝาก: <span style="color:#808000">' . $row["m_fname"] . ' ' . $row["m_lname"] . '</span></div>';
        echo '<div class="all-btn">Email: <span style="color:#808000">' . $row["m_email"] . '</span></div>';
        echo '<div class="all-btn">เลขบัตรประชาชน/หนังสือเดินทาง: <span style="color:#808000">' . $row["m_passport"] . '</span></div>';
        echo '<div class="all-btn">ประเทศ: <span style="color:#808000">' . $row["m_ctry"] . '</span></div>';
        echo '<div class="all-btn">สถานที่รับฝาก : ' .  '<span style="color:#808000">' . $row["mk_name"] . '</span>' . '</div>';
        echo '<div class="all-btn">เบอร์โทรศัพท์: <span style="color:#808000">' . $row["m_phone"] . '</span></div>';
        echo '<div class="all-btn">ประเภทกระเป๋า : ' . '<span style="color:#808000">' .  $row["category_name"] . '</span>' . '</div>';
        echo '<div class="all-btn">สถานะกระเป๋า: <span style="color:#808000">' . $row["status"] . '</span></div>';
        echo '<div class="all-btn" id="tracking">Tracking : ' . $row["tracking"] . '</div>';
        echo '</div>'; // Close col-lg-6 for second column

        // Third Column
        echo '<div class="col-6 d-flex flex-column align-items-end" style="height: 500px; margin-bottom: 2rem">';
        echo '<h5 class="card_all d-flex align-items-center justify-content-center"><b>' . 'กำลังฝาก' . '</b></h5>';
        echo '<div class="card" style="background-color: #d9d9d9; margin: auto;">';
        $baseUrl = 'http://localhost/Travbagdrop/images/';
        $filenameFromDB = isset($row['picture']) ? $row['picture'] : ''; // Check if $row['picture'] is set
        $filenames = json_decode($filenameFromDB, true); // Ensure associative array
        if ($filenames && is_array($filenames) && count($filenames) >= 2) { // Check if $filenames is an array and has 2 or more elements
            $slideshowId = uniqid(); // Generate a unique ID for the slideshow
            echo '<div id="slideshow-' . $slideshowId . '" class="carousel slide" data-ride="carousel">'; // Add unique ID to slideshow
            echo '<div class="carousel-inner">';
            $first = true;
            foreach ($filenames as $index => $filename) {
                // Replace plus signs with spaces
                $filename = str_replace('+', ' ', $filename);
                // Decode URL encoding
                $filename = urldecode($filename);
                // Encode filename for URL
                $encodedFilename = rawurlencode($filename);
                // Construct the full image URL
                $imageUrl = $baseUrl . $encodedFilename;

                if ($first) {
                    echo '<div class="carousel-item active"  id="slide-' . $index . '">'; // Change id to slide-
                    $first = false;
                } else {
                    echo '<div class="carousel-item"  id="slide-' . $index . '">'; // Change id to slide-
                }
                echo '<img class="d-block w-100" src="' . htmlspecialchars($imageUrl) . '" alt="Slide">'; // Sanitize imageUrl
                echo '</div>';
            }
            echo '</div>';
            echo '<a class="carousel-control-prev" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="prev" id="prevBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
            echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Previous</span>';
            echo '</a>';
            echo '<a class="carousel-control-next" href="#slideshow-' . $slideshowId . '" role="button" data-bs-slide="next" id="nextBtn" data-bs-target="#slideshow-' . $slideshowId . '">'; // Use unique slideshow ID
            echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
            echo '<span class="sr-only">Next</span>';
            echo '</a>';
            echo '</div>';
        } else {
            if ($filenames) {
                foreach ($filenames as $filename) {
                    // Replace plus signs with spaces
                    $filename = str_replace('+', ' ', $filename);
                    // Decode URL encoding
                    $filename = urldecode($filename);
                    // Encode filename for URL
                    $encodedFilename = rawurlencode($filename);
                    // Construct the full image URL
                    $imageUrl = $baseUrl . $encodedFilename;
                    echo '<img class="depo-img" src="' . htmlspecialchars($imageUrl) . '" height="250" width="250"/>'; // Sanitize imageUrl
                    // Display only the first image
                    break;
                }
            }
        }
        echo '<div class="card-body" style="background-color: white;"></div>';
        echo '</div>';
        echo '</div>';

        echo '</div>'; // Close row

        echo '</div>'; // Close all_order div
        echo '</div>'; // Close container
    }
}

$conn->close();
