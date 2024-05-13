<?php
session_start();
require_once("libs/connect.class.php")
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bagdrop</title>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- last  -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"> -->
    <!--  -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <!-- CSS ของ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styless.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/checkout/">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css" />

    <!-- Add Leaflet Routing Machine Plugin Script -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.js"></script>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src='https://unpkg.com/@turf/turf@6/turf.min.js'></script>
</head>

<body>
    <!--  -->

    <?php
    $page = "home";
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    }

    if (isset($_SESSION['bagdrop_member_id'])) {

        if ($_SESSION['bagdrop_member_id_type'] == 'partner') {

            require_once("themes/partnerbar.php");
            require_once("themes/navbar.php");

            if ($page == 'create_account' || isset($_GET["create_account"]))
                require_once("pages/create_account.page.php");

            // track
            elseif ($page == 'track_email' || isset($_GET["track_email"]))
                require_once("pages/track_email.page.php");
            elseif ($page == 'track_phone' || isset($_GET["track_phone"]))
                require_once("pages/track_phone.page.php");
            elseif ($page == 'track_onum' || isset($_GET["track_onum"]))
                require_once("pages/track_onum.page.php");
            elseif ($page == 'showtrack' || isset($_GET["showtrack"]))
                require_once("pages/showtrack.page.php");

            // reserv
            elseif ($page == 'cart' || isset($_GET["cart"]))
                require_once("pages/cart.page.php");
            elseif ($page == 'reserv_new' || isset($_GET["reserv_new"]))
                require_once("pages/reserv_new.page.php");
            elseif ($page == 'reserv_new2' || isset($_GET["reserv_new2"]))
                require_once("pages/reserv_new2.page.php");
            elseif ($page == 'payment' || isset($_GET["payment"]))
                require_once("pages/payment.page.php");
            //partner home
            elseif ($page == 'partner_home' || isset($_GET["partner_home"]))
                require_once("pages/partner_home.page.php");
            // clear
            elseif ($page == 'clear_cart' || isset($_GET["clear_cart"]))
                require_once("crud/clear_cart.page.php");
            elseif ($page == 'login' || isset($_GET["login"]))
                require_once("pages/login.page.php");
            elseif ($page == 'logout' || isset($_GET["logout"]))
                require_once("pages/logout.page.php");
            // map
            elseif ($page == 'map' || isset($_GET["map"]))
                require_once("pages/map.page.php");
            // 
            elseif ($page == 'cussupport' || isset($_GET["cussupport"]))
                require_once("pages/cussupport.page.php");
            else
                require_once("pages/default.page.php");
        }
        //member
        elseif ($_SESSION['bagdrop_member_id_type'] == 'member') {
            require_once("themes/navbar.php");

            if ($page == 'create_account' || isset($_GET["create_account"]))
                require_once("pages/create_account.page.php");

            // testSHOW.page
            elseif ($page == 'testSHOW' || isset($_GET["testSHOW"]))
                require_once("pages/testSHOW.page.php");
            // 

            // track
            elseif ($page == 'detailre' || isset($_GET["detailre"]))
                require_once("pages/detailre.page.php");
            elseif ($page == 'listreserv' || isset($_GET["listreserv"]))
                require_once("pages/listreserv.page.php");

            // reserv
            elseif ($page == 'cart' || isset($_GET["cart"]))
                require_once("pages/cart.page.php");
            elseif ($page == 'reserv_new' || isset($_GET["reserv_new"]))
                require_once("pages/reserv_new.page.php");
            elseif ($page == 'reserv_new2' || isset($_GET["reserv_new2"]))
                require_once("pages/reserv_new2.page.php");
            elseif ($page == 'payment' || isset($_GET["payment"]))
                require_once("pages/payment.page.php");

            // regis
            elseif ($page == 'register.m' || isset($_GET["register.m"]))
                require_once("pages/register.m.page.php");
            elseif ($page == 'register.p' || isset($_GET["register.p"]))
                require_once("pages/register.p.page.php");
            elseif ($page == 'add-information' || isset($_GET["add-information"]))
                require_once("pages/add-information.page.php");

            // clear
            elseif ($page == 'clear_cart' || isset($_GET["clear_cart"]))
                require_once("crud/clear_cart.page.php");
            elseif ($page == 'login' || isset($_GET["login"]))
                require_once("pages/login.page.php");
            elseif ($page == 'logout' || isset($_GET["logout"]))
                require_once("pages/logout.page.php");
            // map
            elseif ($page == 'map' || isset($_GET["map"]))
                require_once("pages/map.page.php");
            // 
            elseif ($page == 'cussupport' || isset($_GET["cussupport"]))
                require_once("pages/cussupport.page.php");
            else
                require_once("pages/default.page.php");
        } //admin
        elseif ($_SESSION['bagdrop_member_id_type'] == 'admin') {
            require_once("themes/navbar.php");

            if ($page == 'create_account' || isset($_GET["create_account"]))
                require_once("pages/create_account.page.php");

            // admin.page
            elseif ($page == 'admin' || isset($_GET["admin"]))
                require_once("pages/admin.page.php");
            // 

            // testSHOW.page
            elseif ($page == 'testSHOW' || isset($_GET["testSHOW"]))
                require_once("pages/testSHOW.page.php");
            // 

            // track
            elseif ($page == 'detailre' || isset($_GET["detailre"]))
                require_once("pages/detailre.page.php");
            elseif ($page == 'listreserv' || isset($_GET["listreserv"]))
                require_once("pages/listreserv.page.php");

            // reserv
            elseif ($page == 'cart' || isset($_GET["cart"]))
                require_once("pages/cart.page.php");
            elseif ($page == 'reserv_new' || isset($_GET["reserv_new"]))
                require_once("pages/reserv_new.page.php");
            elseif ($page == 'reserv_new2' || isset($_GET["reserv_new2"]))
                require_once("pages/reserv_new2.page.php");
            elseif ($page == 'payment' || isset($_GET["payment"]))
                require_once("pages/payment.page.php");

            // regis
            elseif ($page == 'register.m' || isset($_GET["register.m"]))
                require_once("pages/register.m.page.php");
            elseif ($page == 'register.p' || isset($_GET["register.p"]))
                require_once("pages/register.p.page.php");

            // clear
            elseif ($page == 'clear_cart' || isset($_GET["clear_cart"]))
                require_once("crud/clear_cart.page.php");
            elseif ($page == 'login' || isset($_GET["login"]))
                require_once("pages/login.page.php");
            elseif ($page == 'logout' || isset($_GET["logout"]))
                require_once("pages/logout.page.php");
            // map
            elseif ($page == 'map' || isset($_GET["map"]))
                require_once("pages/map.page.php");
            // 
            elseif ($page == 'cussupport' || isset($_GET["cussupport"]))
                require_once("pages/cussupport.page.php");
            else
                require_once("pages/default.page.php");
        } else {
        }
    } else {
        require_once("themes/navbar.php");

        if ($page == 'create_account' || isset($_GET["create_account"]))
            require_once("pages/create_account.page.php");

        // admin.page
        elseif ($page == 'admin' || isset($_GET["admin"]))
            require_once("pages/admin.page.php");
        // 

        // regis
        elseif ($page == 'listreserv' || isset($_GET["listreserv"]))
            require_once("pages/listreserv.page.php");
        elseif ($page == 'register.m' || isset($_GET["register.m"]))
            require_once("pages/register.m.page.php");
        elseif ($page == 'register.p' || isset($_GET["register.p"]))
            require_once("pages/register.p.page.php");
        elseif ($page == 'reserv_new' || isset($_GET["reserv_new"]))


            require_once("pages/reserv_new.page.php");
        elseif ($page == 'add-information' || isset($_GET["add-information"]))
            require_once("pages/add-information.page.php");

        elseif ($page == 'cart' || isset($_GET["cart"]))
            require_once("pages/cart.page.php");
        elseif ($page == 'payment' || isset($_GET["payment"]))
            require_once("pages/payment.page.php");

        // newpass
        elseif ($page == 'newpass' || isset($_GET["newpass"]))
            require_once("pages/newpass.page.php");
        elseif ($page == 'resetpass' || isset($_GET["resetpass"]))
            require_once("pages/resetpass.page.php");

        // clear
        elseif ($page == 'clear_cart' || isset($_GET["clear_cart"]))
            require_once("crud/clear_cart.page.php");
        elseif ($page == 'login' || isset($_GET["login"]))
            require_once("pages/login.page.php");
        elseif ($page == 'logout' || isset($_GET["logout"]))
            require_once("pages/logout.page.php");
        // map
        elseif ($page == 'map' || isset($_GET["map"]))
            require_once("pages/map.page.php");
        // 
        elseif ($page == 'cussupport' || isset($_GET["cussupport"]))
            require_once("pages/cussupport.page.php");
        else
            require_once("pages/default.page.php");
    }
    ?>

    <!-- buttom -->
    <?php if (!isset($_GET['page']) || ($_GET['page'] !== 'partner_home' && $_GET['page'] !== 'register.p' && $_GET['page'] !== 'map' && $_GET['page'] !== 'admin')) : ?>

        <div class="contact-section">
            <h4 class="text9">ศูนย์ช่วยเหลือ</h4>
            <div class="social-icons">
                <ul>
                    <div class="row">
                        <li>
                            <p class="btn btn-white" href="?page=login">
                                <img src="images/facebook.png">
                            </p>
                            <span>Travbagdrop</span>
                        </li>
                        <li>
                            <p class="btn btn-white" href="?page=login">
                                <img src="images/line.png">
                            </p>
                            <span>@Travbagdrop</span>
                        </li>
                    </div>
                    <div class="row">
                        <li>
                            <p class="btn btn-white" href="?page=login">
                                <img src="images/email.png">
                            </p>
                            <span>Bagdor@gmail.co.th</span>
                        </li>
                        <li>
                            <p class="btn btn-white" href="?page=login">
                                <img src="images/phone.png">
                            </p>
                            <span>0216494332</span>
                        </li>
                    </div>
                </ul>
            </div>
        </div>

    <?php endif; ?>

    <!--  -->

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->

</body>

</html>