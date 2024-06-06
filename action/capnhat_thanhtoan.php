<?php
session_start();
//3-12 : Gọi đến thư viện cài đặt và sử dụng phpmailer để gửi mail thông báo
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';
require('../database/connect.php');	
require('../database/query.php');

$number_student = $_SESSION['user'];
// $sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
// $sv = mysqli_query($conn, $sql_sv)->fetch_assoc(); 
//echo $number_student;
$sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
$sv = mysqli_query($conn, $sql_sv)->fetch_assoc();
$contract_id = NULL;
$register_services_id = NULL;
$bill_id = NULL;

$checkout = false; // kiểm soát việc update có thành công không
if(isset($_GET['contract_id'])){
    $contract_id = $_GET['contract_id'];
    $sql_update_contract = "UPDATE contract SET status = true WHERE contract_id =  '".$contract_id."'";
    $update_contruct = queryExecute($conn, $sql_update_contract);
    $checkout = isset($update_contruct) ? true : false;
}
if(isset($_GET['register_vesinh_id'])){
    $register_vesinh_id = $_GET['register_vesinh_id'];
    $sql_update_vesinh = "UPDATE register_services SET status = true WHERE register_services_id =  '".$register_vesinh_id."'";
    $update_vesinh = queryExecute($conn, $sql_update_vesinh);
    $checkout = isset($update_vesinh) ? true : false;
    $register_services_id = $_GET['register_vesinh_id'];
}
if(isset($_GET['register_xemay_id'])){
    $register_xemay_id = $_GET['register_xemay_id'];
    $sql_update_xemay = "UPDATE register_services SET status = true WHERE register_services_id =  '".$register_xemay_id."'";
    $update_xemay = queryExecute($conn, $sql_update_xemay);
    $checkout = isset($update_xemay) ? true : false;
    $register_services_id = $_GET['register_xemay_id'];
}
if(isset($_GET['register_xedap_id'])){
    $register_xedap_id = $_GET['register_xedap_id'];
    $sql_update_xedap = "UPDATE register_services SET status = true WHERE register_services_id =  '".$register_xedap_id."'";
    $update_xedap = queryExecute($conn, $sql_update_xedap);
    $checkout = isset($update_xedap) ? true : false;
    $register_services_id = $_GET['register_xedap_id'];
}
// Thanh toán bill điện nước là riêng biệt
if(isset($_GET['bill_id'])){
    $bill_id = $_GET['bill_id'];
    $sql_update_bill = "UPDATE bill SET status_bill = 1, student_id = '".$sv['student_id']."' WHERE bill_id =  '".$bill_id."'";
    $update_bill = queryExecute($conn, $sql_update_bill);
    $checkout = isset($update_bill) ? true : false;

}
// contract_id=42&price=650000&orderId=1717178317&requestId=1717178317&amount=650000&transId=4051909749&resultCode=0&responseTime=1717178270802&paymentOption=momo
$student_id = $sv['student_id'];
$payment_id = $_GET['orderId'];
$currentDate = new DateTime();
$datetime = $currentDate->format('Y-m-d H:i:s');
$method = $_GET['paymentOption'];
$total_price = $_GET['amount'];
// echo $payment_id . "-" . $method ."---". $total_price ."---". $number_student;
if($bill_id != NULL){
    $sql_insert = "INSERT INTO `payment` ( `payment_number`,`student_id`, `bill_id`, `datetime`, `method`, `total_price`)
    VALUES ('".$payment_id."','".$student_id."','".$bill_id."','".$datetime."','".$method."','".$total_price."')";
queryExecute($conn, $sql_insert);
}
if($contract_id != NULL && $register_services_id != NULL){
    $sql_insert = "INSERT INTO `payment` ( `payment_number`,`student_id`, `contract_id`, `register_services_id`, `datetime`, `method`, `total_price`)
        VALUES ('".$payment_id."','".$student_id."','".$contract_id."','".$register_services_id."','".$datetime."','".$method."','".$total_price."')";
    queryExecute($conn, $sql_insert);
}else{if($contract_id != NULL){
    $sql_insert = "INSERT INTO `payment` ( `payment_number`,`student_id`, `contract_id`, `datetime`, `method`, `total_price`)
        VALUES ('".$payment_id."','".$student_id."','".$contract_id."','".$datetime."','".$method."','".$total_price."')";
    queryExecute($conn, $sql_insert);
}elseif ($register_services_id != NULL) {
    $sql_insert = "INSERT INTO `payment` ( `payment_number`,`student_id`,`register_services_id`, `datetime`, `method`, `total_price`)
    VALUES ('".$payment_id."','".$student_id."','".$register_services_id."','".$datetime."','".$method."','".$total_price."')";
queryExecute($conn, $sql_insert);
}}

// echo $sql_insert;

if($checkout){
    // use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;

    // require '../vendor/PHPMailer/src/Exception.php';
    // require '../vendor/PHPMailer/src/PHPMailer.php';
    // require '../vendor/PHPMailer/src/SMTP.php';

        $price = $_GET['price'];
        $currentDateTime = (new DateTime())->format("H:i:s d-m-Y");
        $number_student = $_SESSION['user'];
        //echo $number_student;
        // $sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
        // $sv = mysqli_query($conn, $sql_sv)->fetch_assoc();  
        // sử dụng các biến chuhng để gọi file này nhiều lần
        $student_email = $sv['email'];
        $subject = 'Thong bao thanh toan tien thanh cong';
        $body = '<p>Chào em <b>'.$sv['name'].'</b>. Bạn đã thanh toán thành công số tiền <b>'.$price.'</b> tới cổng thanh toán của trường <b>Đại học Giao thông Vận tải Hà nội</b>. 
        Thời gian thanh toán : <b>'.$currentDateTime.' VNĐ</b>.
        <p style="text-align: center;">Kí túc xá Đại học Giao thông Vận tải Hà nội</p>
        <p style="text-align: center;">Trung tâm hỗ trợ sinh viên - Phòng Công tác sinh viên</p>
        <p style="text-align: center;">Điện thoại van phòng: 0292.9992773 - Điện thoại di động: 0977823399 (Zalo)</p>';
        $message = '<script type="text/javascript">
                        alert("Gửi thông báo thành công!");
                        window.onload = function () { 
                            window.location.href = "../thong_tin_ca_nhan.php";
                            alert("Thanh toán thành công!");
                        }
                    </script>';

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
        // echo 'Message has been sent';
        echo $message;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }    
}else{
    echo '<script type="text/javascript">
                window.onload = function () { 
                    window.location.href = "../thong_tin_ca_nhan.php";
                    alert("Thanh toán không thành công!");
                }
            </script>';
}

?>