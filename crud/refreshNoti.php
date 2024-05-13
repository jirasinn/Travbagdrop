<?php
require_once('../libs/connect.class.php');
session_start();
$db = new ConnectDb();
$conn = $db->getConn();
$mk_name = $_SESSION['mkname'];
$sql = "SELECT * FROM bagreserv 
JOIN register ON register.m_id = bagreserv.m_id 
WHERE bagreserv.mk_name LIKE '$mk_name' 
AND (status = 'รอดำเนินการ' OR status = 'คืนสำเร็จ' OR status = 'ฝากสำเร็จ') 
ORDER BY curr_timestamp DESC LIMIT 6";


$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo '<div id="noti" style="background-color:#d9d9d9; ">
    <div style="text-align:center; margin-left: -1vw; margin-right: -1vw;  padding: 10px; background-color: white;">
        <div class="d-flex align-items-center" style="margin:10px 0 10px 0;">
            <a href=""><img src="images/leftarrow.png" style="width:40px;height:40px;"></a>
            <div class="flex-grow-1 text-center">
                <h4 style="font-weight:900; ">แจ้งเตือนทั้งหมด</h4>
            </div>
        </div>
    </div>';

    while ($row = $result->fetch_assoc()) {
        $bag_id = $row['bag_id'];
        $checkDate = findNotifDate($row["curr_timestamp"],  7 * 60 * 60);


        echo '<button type="button" id="retr-online" name="retr-online" onclick="displayContent(\'re_online\', \'re_online-link\', \'' . $bag_id . '\')"  style="width: 100%; padding: 0px; border: 0px; margin-top: 5px; text-align:left;">';

        echo '<div style="display: flex; ">';

        echo '<div style="background-color: white; flex: 3; padding: 5px;">';
        echo '<img class="noti-img" src="images/img_avatar.png" >';
        echo '<span style="font-size: 15px; font-weight: 600;">' . $row["m_fname"] . ' ' . $row["m_lname"] . ' ' . '</span>';
        echo '<span style="font-size: 15px;">เวลา' . ' ' . $row["reserv_time"] . ' ' . 'วันที่' . ' ' . $row["reserv_date"] . ' ' . '-' . ' ' . $row["retrive_time"] . ' ' . 'วันที่' . ' ' . $row["retrive_date"] . '<span style="font-weight: 600; margin-left: 13px;">' . $checkDate . '</span>' .  '</span><br>';
        echo '</div>';

        echo '<div style="background-color: ' . ($row["status"] == "คืนสำเร็จ" ? '#7d7777' : ($row["status"] == "ฝากสำเร็จ" ? '#76c70c' : ($row["status"] == "รอดำเนินการ" ? '#faf61e' : '#f7f420'))) . '; padding: 5px; flex: 1; display: flex; justify-content: center; align-items: center">';
        echo '<span style="font-size: 18px; font-weight: 600;">' . $row["status"] . '</span><br>';
        echo '</div>';


        echo '</div>';
        echo '</button>';
    }
}


function findNotifDate($notif_date, $timezoneOffset)
{

    $sent_date = (strpos($notif_date, ' ') !== FALSE) ? strtotime($notif_date) : $notif_date;
    $localTime = gmdate("Y-m-d H:i:s", time() + $timezoneOffset);

    $today = strtotime($localTime);

    $calc = $today - $sent_date;
    $calcDate = gmdate("d-m-y", $calc);
    $calcTime = gmdate("H:i:s", $calc); //Will always be correct

    //Get How many days, months and years that has passed
    $date_passed = explode("-", $calcDate);
    $time_passed = explode(":", $calcTime);

    $days_passed = ($date_passed[0] != '01') ? intval($date_passed[0]) - 1 : NULL;
    $months_passed = ($date_passed[1] != '01') ? intval($date_passed[1]) - 1 : NULL;
    $years_passed = ($date_passed[2] != '70') ? intval($date_passed[2]) - 70 : NULL;

    $hours_passed = ($time_passed[0] != '00') ? intval($time_passed[0]) : NULL;
    $mins_passed = ($time_passed[1] != '00') ? intval($time_passed[1]) : NULL;
    $secs_passed = intval($time_passed[2]);

    //Set up your Custom Text output here
    $s = ["วินาที", "วินาทีที่แล้ว"];
    $m = ["นาที", "วินาทีที่แล้ว", "นาที", "วินาทีที่แล้ว"];
    $h = ["ชั่วโมง", "นาทีที่แล้ว", "ชั่วโมง", "นาทีที่แล้ว"];
    $d = ["วัน", "ชั่วโมงที่แล้ว", "วัน", "ชั่วโมงที่แล้ว"];
    $M = ["เดือน", "วันที่แล้ว", "เดือน", "วันที่แล้ว"];
    $y = ["ปี", "เดือนที่แล้ว", "ปี", "ปีที่แล้ว"];


    if (
        !($days_passed) && !($months_passed) && !($years_passed)
        && !($hours_passed) && !($mins_passed)
    ) {

        $ret = ($secs_passed == 1) ? $secs_passed . ' ' . $s[0] : $secs_passed . ' ' . $s[1];
    } else if (
        !($days_passed) && !($months_passed) && !($years_passed)
        && !($hours_passed)
    ) {

        $retA = ($mins_passed == 1) ? $mins_passed . ' ' . $m[0] : $mins_passed . ' ' . $m[2];
        $retB = ($secs_passed == 1) ?  $secs_passed . ' ' . $m[1] : $secs_passed . ' ' . $m[3];

        $ret = $retA . ' ' . $retB;
    } else if (!($days_passed) && !($months_passed) && !($years_passed)) {

        $retA = ($hours_passed == 1) ? $hours_passed . ' ' . $h[0] : $hours_passed . ' ' . $h[2];
        $retB = ($mins_passed == 1) ?  $mins_passed . ' ' . $h[1] : $mins_passed . ' ' . $h[3];

        $ret = $retA . ' ' . $retB;
    } else if (!($years_passed) && !($months_passed)) {
        $retA = ($days_passed == 1) ? $days_passed . ' ' . $d[0] :  $days_passed . ' ' . $d[2];
        $retB = ($hours_passed == 1) ? $hours_passed . ' ' . $d[1] : $hours_passed . ' ' . $d[3];

        $ret = $retA . ' ' . $retB;
    } else if (!($years_passed)) {

        $retA = ($months_passed == 1) ? $months_passed . ' ' . $M[0] : $months_passed . ' ' . $M[2];
        $retB = ($days_passed == 1) ? $days_passed . ' ' . $M[1] : $days_passed . ' ' . $M[3];

        $ret = $retA . ' ' . $retB;
    } else {
        $retA = ($years_passed == 1) ? $years_passed . ' ' . $y[0] : $years_passed . ' ' . $y[2];
        $retB = ($months_passed == 1) ? $months_passed . ' ' . $y[1] : $months_passed . ' ' . $y[3];

        $ret = $retA . ' ' . $retB;
    }

    if (strpos($ret, '-') !== FALSE) {
        $ret .= " ( TIME ERROR )-> Invalid Date Provided!";
    }

    return $ret;
}
$conn->close();
?>
</div>