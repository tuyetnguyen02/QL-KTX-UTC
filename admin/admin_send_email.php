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
    <p style="text-align: center;">Điện thoại văn phòng: 0292.9992773 - Điện thoại di động: 0977823399 (Zalo)</p>';
    $message = '<script type="text/javascript">
                    alert("Gửi thông báo thành công!");
                    window.onload = function () { 
                        window.location.href = "sua_chua_vat_chat.php";
                    }
                </script>';
}
// phản hồi về việc xác nhận đơn đăng ký ở của sinh viên
if(isset($_GET['contract_id'])){
    $contract_id = $_GET['contract_id'];
    $sql_student = "SELECT * FROM student s
                INNER JOIN contract c ON s.student_id = c.student_id
                INNER JOIN room r ON c.room_id = r.room_id
                INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id
                INNER JOIN semester sem ON sem.semester_id = c.semester_id
                WHERE c.contract_id = '".$contract_id."' AND sem.status = true ";
    $student = mysqli_query($conn, $sql_student)->fetch_assoc();
    $student_email = $student['email'];
    $subject = 'Thong bao xac nhan dang ky phong KTX';
    $body = '<p>Chào em <b>'.$student['name'].'</b>. Tôi đã nhận được đơn đăng ký nội trú KTX phòng <b>'.$student['room_name'].'</b> của em. 
    Đơn đăng ký của em hoàn toàn hợp lệ và được xác nhận đăng ký ở thành công. Để đi đến bước cuối cùng(vào ở), em hãy thanh toán tiền phòng trước hạn đăng ký.
    Nếu hết thời gian đăng ký mà em chưa thanh toán tiền phòng, ban quản lý sẽ huỷ bỏ đơn đăng ký của em. Nếu em có bất kỳ thắc mắc nào hãy gửi đến
    <b>ktx_utc@utc.edu.vn</b> hoặc đến trực tiếp ban quản lý KTX(P105 D1)</p>
    <p style="text-align: center;">Kí túc xá Đại học Giao thông Vận tải Hà nội</p>
    <p style="text-align: center;">Trung tâm hỗ trợ sinh viên - Phòng Công tác sinh viên</p>
    <p style="text-align: center;">Điện thoại văn phòng: 0292.9992773 - Điện thoại di động: 0977823399 (Zalo)</p>';
    $message = '<script type="text/javascript">
                    alert("Xác nhận thành công. Đã gửi thông báo đến sinh viên!");
                    window.onload = function () { 
                        window.location.href = "ds_sinhvien_dangky_phong.php";
                    }
                </script>';
}
// phản hồi về việc huỷ đơn đăng ký ở của sinh viên
if(isset($_GET['contract_error_id'])){
    $contract_id = $_GET['contract_error_id'];
    $sql_student = "SELECT * FROM student s
                INNER JOIN contract c ON s.student_id = c.student_id
                INNER JOIN room r ON c.room_id = r.room_id
                INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id
                INNER JOIN semester sem ON sem.semester_id = c.semester_id
                WHERE c.contract_id = '".$contract_id."' AND sem.status = true ";
    $student = mysqli_query($conn, $sql_student)->fetch_assoc();
    $student_email = $student['email'];
    $subject = 'Thong bao xac nhan dang ky phong KTX';
    $body = '<p>Chào em <b>'.$student['name'].'</b>. Tôi đã nhận được đơn đăng ký nội trú KTX phòng <b>'.$student['room_name'].'</b> của em. 
    Đơn đăng ký của em không hợp lệ, KTX ưu tiên các bạn có hoàn cảnh khó khăn và thuộc khu vực vùng núi và đồng bằng. Nếu em có bất kỳ thắc mắc nào hãy gửi đến
    <b>ktx_utc@utc.edu.vn</b> hoặc đến trực tiếp ban quản lý KTX(P105 D1)</p>
    <p style="text-align: center;">Kí túc xá Đại học Giao thông Vận tải Hà nội</p>
    <p style="text-align: center;">Trung tâm hỗ trợ sinh viên - Phòng Công tác sinh viên</p>
    <p style="text-align: center;">Điện thoại văn phòng: 0292.9992773 - Điện thoại di động: 0977823399 (Zalo)</p>';
    $message = '<script type="text/javascript">
                    alert("Huỷ đơn thành công. Đã gửi thông báo đến sinh viên!");
                    window.onload = function () { 
                        window.location.href = "ds_sinhvien_dangky_phong.php";
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