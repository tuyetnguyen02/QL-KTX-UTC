<?php
  session_start();
  if(!isset($_SESSION['loginadmin'])){
    echo "<script>window.location.href = 'dang_nhap.php';</script>";
  }

require('../database/connect.php');	
require('../database/query.php');

$number_admin = $_SESSION["useradmin"]; // mã nhân viên , ko phải id
//echo $number_student;
$sql_admin = "SELECT * FROM admin WHERE number_admin = '".$number_admin."'";
$admin = mysqli_query($conn, $sql_admin)->fetch_assoc();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kí túc xá UTC</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/my_edit.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../image/logo/Logo-UTC.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php require(__DIR__.'/navbar.php'); ?> 
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php require(__DIR__.'/sidebar.php'); ?> 
        
      