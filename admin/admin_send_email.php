<?php
session_start();
require('../database/connect.php');	
require('../database/query.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';

if(isset($_GET['feedback_id'])){
    $send_date = $_GET['send_date'];
    $feedback_id = $_GET['feedback_id'];
    $sql_feedback = "SELECT * FROM feedback f 
                    INNER JOIN student s ON s.student_id = f.student_id 
                    INNER JOIN room r ON f.room_id = r.room_id
                    WHERE feedback_id >= '".$feedback_id."'";
    $feedback = mysqli_query($conn, $sql_feedback)->fetch_assoc();
    // sử dụng các biến chuhng để gọi file này nhiều lần
    $student_email = $feedback['email'];
    $subject = 'Thong bao ngay nhan vien toi sua chua trang thiet bi';
    $body = '<p>Chào em <b>'.$feedback['name'].'</b>. Tôi đã nhận được phản hồi về sửa chữa trang thiết bị vật chất trong phòng <b>'.$feedback['room_name'].'</b> của em. 
    Nhân viên kĩ thuật sẽ tới sửa vào ngày <b>'.$send_date.'</b>. Nếu hôm đó phòng em không có ai ở phòng, em vui lòng phản hồi qua mail
    <b>ktx_utc@utc.edu.vn</b></p>
    <p style="text-align: center;">Kí túc xá Đại học Giao thông Vận tải Hà nội</p>
    <p style="text-align: center;">Trung tâm hỗ trợ sinh viên - Phòng Công tác sinh viên</p>
    <p style="text-align: center;">Điện thoại van phòng: 0292.9992773 - Điện thoại di động: 0977823399 (Zalo)</p>';
    $message = '<script type="text/javascript">
                    alert("Gửi thông báo thành công!");
                    window.onload = function () { 
                        window.location.href = "sua_chua_vat_chat.php";
                    }
                </script>';
}

//Create an instance; passing `true` enables exceptions
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
    $mail->addAddress( $student_email, 'Nguyen Thi Tuyet');     //Add a recipient
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
    echo $message;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>