<?php
session_start();
require('../database/connect.php');	
require('../database/query.php');

$number_student = $_SESSION['user']; // lấy id của student
//echo $number_student;
$sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
$sv = mysqli_query($conn, $sql_sv)->fetch_assoc();
$student_id = $sv['student_id'];

$semester_id = $_GET['semester_id'];
$services_id = $_GET['services_id'];
$price = $_GET['price'];

$currentDate = new DateTime();
$registration_date = $currentDate->format('Y-m-d');

if(isset($_GET['bien_soxe'])){ // gửi xe máy
    $bien_soxe = $_GET['bien_soxe'];
    $sql_insert = "INSERT INTO `register_services`(`student_id`,`semester_id`,`services_id`,`registration_date`, `motorbike_license_plate`,`price`,`status`)
            VALUES ('".$student_id."','".$semester_id."','".$services_id."','".$registration_date."','".$bien_soxe."','".$price."', 0 )";
    $booking = mysqli_query($conn, $sql_insert);
    echo '<script type="text/javascript">
            window.onload = function () { 
                alert("Đăng ký dịch vụ gửi xe máy thành công!"); 
                window.location.href = "../thong_tin_ca_nhan.php";
            }
            </script>';
}else{//gửi xe đạp và dịch vụ vệ sinh
    if($services_id == 1){ // 1 : id dịch vụ gửi xe đạp
        $sql_insert = "INSERT INTO `register_services`(`student_id`,`semester_id`,`services_id`,`registration_date`,`price`,`status`)
            VALUES ('".$student_id."','".$semester_id."','".$services_id."','".$registration_date."','".$price."', 0 )";
        $booking = mysqli_query($conn, $sql_insert);
        echo '<script type="text/javascript">
                window.onload = function () { 
                    alert("Đăng ký dịch vụ gửi xe đạp thành công!"); 
                    window.location.href = "../thong_tin_ca_nhan.php";
                }
                </script>';
    }else{ // dịch vụ dọn vệ sinh
        $sql_insert = "INSERT INTO `register_services`(`student_id`,`semester_id`,`services_id`,`registration_date`,`price`,`status`)
            VALUES ('".$student_id."','".$semester_id."','".$services_id."','".$registration_date."','".$price."', 0 )";
        $booking = mysqli_query($conn, $sql_insert);
        echo '<script type="text/javascript">
                window.onload = function () { 
                    alert("Đăng ký dịch vụ dọn vệ sinh thành công!"); 
                    window.location.href = "../thong_tin_ca_nhan.php";
                }
                </script>';
    }
}
?>