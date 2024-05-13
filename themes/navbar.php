<nav class="navbar1 navbar-expand-lg navbar-dark" style="background-color: #121139;">

  <div class="container-fluid">
    <div class="col-md-12">
      <a class="navbar-brand mb-0 h1" href="?page=home"><img alt="newlogo" src="images/newlogobd.png" width="6%"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
        </ul>

        <ul class="nav">
          <li class="nav-item">
            <div class="dropdown text-end">
              <a href="#" class="d-block text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                </i>Language
              </a>
              <ul class="dropdown-menu text-small">
                <li><a class="dropdown-item" href="">
                    <i class=""></i>ไทย</a></li>

                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href=""><i class=""></i>อังกฤษ</a></li>
                <li><a class="dropdown-item" href=""><i class=""></i>จีน</a></li>

          </li>
          <!--  -->
        </ul>


        <ul class="nav">
          <!--  -->

          <li class="nav-item ">

          </li>

        </ul>
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

    // ถ้าอยู่ที่หน้า Home หรือ Partner Home
    if (currentPage.includes('?page=home') || currentPage.includes('?page=partner_home') || currentPage.endsWith('/')) {
      // ซ่อน Navbar
      document.querySelector('.navbar1').style.display = 'none';
    }
  });
</script>