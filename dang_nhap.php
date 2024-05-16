<?php
session_start();

require('database/connect.php');	
require('database/query.php');



if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $masinhvien = $_POST['masinhvien']; // lấy dữ liệu từ input name taiKhoan
  $matKhau = $_POST['matKhau'];
  $err = "";
  $sql = "SELECT * FROM `student` WHERE number_student = '".$masinhvien."' AND password = '".$matKhau."'";
  $result = queryResult($conn,$sql);
  if(!isset($result->num_rows)) {
      $err = "Sai tài khoản hoặc mật khẩu!";
  }else{
      $_SESSION["fullname"] = $result->fetch_assoc()["name"];
      $_SESSION["login"] = TRUE;
      $_SESSION["user"] = $_POST['masinhvien'];
      $_SESSION["student_id"] = $result->fetch_assoc()["student_id"];
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
    <link rel="stylesheet" href="./css/login.css">
    <title>Đăng Nhập - User Sinh viên</title>
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
               placeholder="Nhập mã sinh viên..."
               name="masinhvien"
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

      <button class="btn btn--form" type="submit" value="Log in">
        Đăng Nhập
      </button>

      <?php if(isset($err) && !empty($err)){ ?>
            <p style="color: red;" ><strong>Lỗi!</strong> <?php echo $err; ?> </p>
        <?php } ?>

    </form>
</div>
</body>
</html>