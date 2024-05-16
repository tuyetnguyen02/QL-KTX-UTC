<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';
require('database/connect.php');	
require('database/query.php');



if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $masinhvien = $_POST['masinhvien']; // lấy dữ liệu từ input name taiKhoan
  $email = $_POST['email'];
  $sql = "SELECT * FROM `student` WHERE number_student = '".$masinhvien."' AND email = '".$email."'";
  $result = queryResult($conn,$sql);
  if(!isset($result->num_rows)) {
    //   echo '<script type="text/javascript">
    //                 alert("Sai thông tin mã sinh viên hoặc email!");
    //         </script>';
    $err = "Sai thông tin mã sinh viên hoặc email!";
  }else{
        $pass = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $subject = 'Cap mat khau tam thoi';
        $body = '<p>Mật khẩu tạm thời: <b>'.$pass.'</b>. Lưu ý mật khẩu này chỉ sử dụng duy nhất một lần, bạn cần nhập chính xác và không được tải lại trang.
        Sau khi đăng nhập thành công bạn hãy vào mục thông tin cá nhân để xem lại mật khẩu hoặc thay đổi mật khẩu mới.
        <p style="text-align: center;">Kí túc xá Đại học Giao thông Vận tải Hà nội</p>
        <p style="text-align: center;">Trung tâm hỗ trợ sinh viên - Phòng Công tác sinh viên</p>
        <p style="text-align: center;">Điện thoại van phòng: 0292.9992773 - Điện thoại di động: 0977823399 (Zalo)</p>';
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'nguyentuyet032002it@gmail.com';                     //SMTP username
        $mail->Password   = 'yrdghdioxxsqpwro';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        
        $mail->setFrom('nguyentuyet032002it@gmail.com', 'KTX-UTC'); 
        $mail->addAddress( $email,);     //Add a recipient
        // $mail->addAddress('tuyetpksl@gmail.com');               //Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');

        //Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
        echo '<script type="text/javascript">
                window.onload = function () { 
                    window.location.href = "dang_nhap.php?pass='.$pass.'";
                    alert("Hãy kiểm tra email. Chúng tôi đã gửi email cho ban!");
                }
            </script>';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }      
      
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Đăng Nhập - User Sinh viên</title>
</head>
<body>
<div class="container">
    <h2 class="login-title">Đăng Nhập</h2>
    
    <form class="login-form" method="POST">
      <div>
        <label for="name">Mã sinh viên </label>
        <input
               id="name"
               type="text"
               placeholder="Nhập mã sinh viên..."
               name="masinhvien"
               required
               />
      </div>

      <div>
        <label for="email">Email </label>
        <input
               id="email"
               type="email"
               placeholder="Nhập email đăng ký với nhà trường..."
               name="email"
               required
               />
      </div>

      <button class="btn btn--form" type="submit" value="Log in">
        Lấy mật khẩu tạm thời
      </button>
    </form>  
      <!-- Quên password -->
      <div style="text-align: center;" >
        <a class="forgot-password" href="dang_nhap.php">Đăng nhập</a>
      </div>
      <?php if(isset($err) && !empty($err)){ ?>
        <div style="text-align: center;">
          <p style="color: red;" ><strong>Lỗi!</strong> <?php echo $err; ?> </p>
        </div>
            
        <?php } ?>

    
</div>
</body>
</html>