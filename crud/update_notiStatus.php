<?php
require_once('../libs/connect.class.php');
session_start();
$db = new ConnectDb();
$conn = $db->getConn();
$mk_name = $_SESSION['mkname'];

$update_sql = "UPDATE bagreserv 
               SET noti_status = 'read' 
               WHERE mk_name LIKE '$mk_name' AND noti_status = 'unread'
               AND (status = 'รอดำเนินการ' OR status = 'คืนสำเร็จ' OR status = 'ฝากสำเร็จ')";
$conn->query($update_sql);


$conn->close();
