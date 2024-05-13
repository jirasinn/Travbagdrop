<?php
class ConnectDb

{
    public $host = "localhost";
    public $user = "root";
    public $pwd = "";
    public $db = "bagdrop";
    public $conn;
    public $rs;

    public function __construct()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pwd, $this->db);
        if (!$this->conn) {
            die("เชื่อมต่อฐานข้อมูลไม่ได้: " . mysqli_connect_error());
        }
    }
    public function getConn()
    {
        return $this->conn;
    }

    // map
    public function getMarketLocations()
    {
        // เรียกใช้งานตัวแปร connection โดยไม่จำเป็นต้องรับพารามิเตอร์ $conn เนื่องจากมันเป็นตัวแปรสมาชิกของคลาส
        $sql = "SELECT * FROM market
   ";
        $result = mysqli_query($this->conn, $sql);

        if (!$result) {
            // ใช้ die() เพื่อหยุดการทำงานและแสดงข้อความแจ้งเตือนหากเกิดข้อผิดพลาดในการดึงข้อมูล
            die("Error fetching market shopLocations: " . mysqli_error($this->conn));
        }

        // สร้างอาเรย์เปล่าเพื่อเก็บพิกัดร้านค้า
        $shopLocations = [];
        // วนลูปผลลัพธ์ที่ได้จากการ query เพื่อดึงข้อมูลแต่ละแถวและเก็บไว้ในอาเรย์ $shopLocations
        while ($row = mysqli_fetch_assoc($result)) {
            $shopLocations[] = $row;
        }

        return $shopLocations;
    }
}
?>

<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "bagdrop";

$connect = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}
