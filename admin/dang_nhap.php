<?php
session_start();

require('../database/connect.php');	
require('../database/query.php');


$err = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $manhanvien = $_POST['manhanvien']; // lấy dữ liệu từ input name taiKhoan
  $matKhau = $_POST['matKhau'];
  
  $sql = "SELECT * FROM `admin` WHERE number_admin = '".$manhanvien."' AND password = '".$matKhau."'";
  $result = queryResult($conn,$sql);
  if(!isset($result->num_rows)) {
      $err = "Sai tài khoản hoặc mật khẩu!";
  }else{
      $_SESSION["fullnameadmin"] = $result->fetch_assoc()["name"];
      $_SESSION["loginadmin"] = TRUE;
      $_SESSION["useradmin"] = $_POST['manhanvien'];
      //echo $masinhvien;
      //echo $_SESSION["user"];
      header("Location: index.php");  
      
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../scss/css/login.css">
    <title>Đăng Nhập - Admin</title>
</head>
<body>
<div class="container">
    <h2 class="login-title">Đăng Nhập</h2>
    
    <form class="login-form" method="POST">
      <div>
        <label for="name">Tài Khoản </label>
        <input
               id="name"
               type="text"
               placeholder="Nhập mã nhân viên..."
               name="manhanvien"
               required
               />
      </div>

      <div>
        <label for="password">Mật Khẩu </label>
        <input
               id="password"
               type="password"
               placeholder="Nhập mật khẩu..."
               name="matKhau"
               required
               />
      </div>
      <div>
        <p style="color : red;"><?php echo $err;?></p>
      </div>
      <button class="btn btn--form" type="submit" value="Log in">
        Đăng Nhập
      </button>

      

    </form>
</div>
</body>
</html>