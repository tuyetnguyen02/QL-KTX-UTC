<?php 
session_start();

if(!isset($_SESSION['login'])){
echo "<script>window.location.href = 'dang_nhap.php';</script>";
}

require('./database/connect.php'); 
require('./database/query.php');

// $sql_chuyenmuc = "SELECT * FROM chuyenmuc";
// $chuyenmuc = queryResult($conn,$sql_chuyenmuc);


?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pustok - Cửa Hàng Bán Sách Trực Tuyến!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Use Minified Plugins Version For Fast Page Load -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/plugins.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
    <link rel="shortcut icon" type="image/x-icon" href="image/favicon.ico">
    <link rel="stylesheet" href="./scss/css/mycss.css">
</head>

<body>
    <div class="site-wrapper" id="top">
        <div class="site-header d-none d-lg-block">
            <div class="header-middle pt--10 pb--10">
                <div class="">
                    <div class="row align-items-center">
                        <div class="col-lg-3">
                            <a href="index.php" class="site-brand">
                                <img src="image/logo/logo.png" alt="">
                            </a>
                        </div>
                        <div class="col-lg-2">
                            <div class="header-phone ">
                                <div class="icon">
                                    <i class="fas fa-headphones-alt"></i>
                                </div>
                                <div class="text">
                                    <p>Hỗ trợ 24/7</p>
                                    <p class="font-weight-bold number">0988.888.999</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="main-navigation flex-lg-right">
                                <ul class="main-menu menu-right " style="display: -webkit-inline-box;">
                                    <li class="menu-item"> 
                                        <a href="index.php"><i class="fas fa-home"></i> Trang Chủ</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="loai_phong.php"><i class="fas fa-building"></i> Loại phòng</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="dich_vu.php"><i class="fas fa-pen-square"></i> Dịch vụ</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="sua_chua_vat_chat.php"><i class="fas fa-wrench"></i> Sửa chữa vật chất</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="thong_tin_ca_nhan.php"><i class="fas fa-address-card"></i> Thông tin cá nhân</a>
                                    </li>
                                    <li class="menu-item">
                                        <a href="dang_xuat.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>

        <div class="sticky-init fixed-header common-sticky">
            <div class="">
                <div class="row align-items-center">
                    <div class="col-lg-1">

                    </div>
                    <div class="col-lg-3">
                        <a href="index.php" class="site-brand">
                            <img src="image/logo/logo.png" alt="">
                        </a>
                    </div>
                    <div class="col-lg-7">
                        <div class="main-navigation flex-lg-right">
                            <ul class="main-menu menu-right ">
                                <li class="menu-item">
                                    <a href="index.php">Trang Chủ</a>
                                </li>
                                <li class="menu-item">
                                    <a href="loai_phong.php">Loại phòng</a>
                                </li>
                                <li class="menu-item">
                                    <a href="dich_vu.php">Dịch vụ</a>
                                </li>
                                <li class="menu-item">
                                    <a href="sua_chua_vat_chat.php">Sửa chữa vật chất</a>
                                </li>
                                <li class="menu-item">
                                    <a href="thong_tin_ca_nhan.php">Thông tin cá nhân</a>
                                </li>
                                <li class="menu-item">
                                    <a href="dang_xuat.php">Đăng xuất</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>