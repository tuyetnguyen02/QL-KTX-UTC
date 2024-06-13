<?php
session_start();
require('../database/connect.php');	
require('../database/query.php');

$number_student = $_SESSION['user']; // lấy id của student
//echo $number_student;
$sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
$sv = mysqli_query($conn, $sql_sv)->fetch_assoc();
$student_id = $sv['student_id'];

$room_id2 = $_GET['room_id'];

$sql_update = "UPDATE `contract` SET `room_id2` = '".$room_id2."' WHERE `contract`.`student_id` = '".$student_id."';";
queryExecute($conn, $sql_update);

    echo '<script type="text/javascript">
            window.onload = function () { 
                alert("Đăng ký đổi phòng đã được gửi đi!"); 
                window.location.href = "../loai_phong.php";
            }
            </script>';

?>