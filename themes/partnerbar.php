<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #121139;">
    <div class="container-fluid">
        <div class="col-md-12">
            <a class="navbar-brand mb-0 h1" href="?page=home"><img src="images/newlogobd.png" width="10%"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="?page=home">
                            <i class="bi bi-house-door"></i>
                            หน้าหลัก</a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="" style="color: yellow;">ตั้งค่าร้านค้า</a>
                    </li>
                    <li class="nav-item">
                        <div class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">
                                Language
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#"><i class=""></i>ไทย</a></li>
                                <li><a class="dropdown-item" href="#"><i class=""></i>อังกฤษ</a></li>
                                <li><a class="dropdown-item" href="#"><i class=""></i>จีน</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="" style="color: yellow;">
                            ติดต่อส่วนกลาง</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>



<script>
    // เพิ่มการเปิด/ปิดสถานะของ dropdown เมื่อคลิกที่ลูกศร dropdown
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownToggle = document.querySelector('.dropdown-toggle');
        var dropdownMenu = document.querySelector('.dropdown-menu');

        dropdownToggle.addEventListener('click', function() {
            var isOpen = dropdownMenu.classList.contains('show');
            if (isOpen) {
                dropdownMenu.classList.remove('show');
            } else {
                dropdownMenu.classList.add('show');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // เช็ค URL ในแอดเดรสบาร์
        var currentPage = window.location.href;

        // ถ้าอยู่ที่หน้า partner_home
        if (currentPage.includes('?page=partner_home')) {
            // แสดง Navbar
            document.querySelector('.navbar').style.display = 'block';
        } else {
            // ถ้าไม่อยู่ในหน้า partner_home ซ่อนทั้งหมด
            document.querySelector('nav').style.display = 'none';
        }
    });
</script>