<?php
    session_start();
    require('../database/connect.php');	
    require('../database/query.php');

    $number_student = $_SESSION["user"]; // lấy id của student, gọi session ko được ???
    $sql_student = "SELECT * FROM student WHERE number_student = '".$number_student."'"; 
    $student = mysqli_query($conn, $sql_student)->fetch_assoc();

    $student_id = $student['student_id'];

    $room_id = $_GET['room_id'];

    $sql_room = "SELECT * FROM room WHERE room_id = '".$room_id."'"; 
    $room = mysqli_query($conn, $sql_room)->fetch_assoc();

    $room_type_id = $room['room_type_id'];
    $sql_loaiphong = "SELECT * FROM room_type WHERE room_type_id = '".$room_type_id."'";
	$roomtype = mysqli_query($conn, $sql_loaiphong)->fetch_assoc();

    $price = $roomtype['price'];

    $sql_hocky = "SELECT * FROM semester WHERE status = true";
    $hocky = mysqli_query($conn, $sql_hocky)->fetch_assoc();
    
    $semester_id = $hocky['semester_id'];

    if(isset($_GET['room_id'])) {
    
        // Nếu người dùng đã xác nhận xóa, thực hiện xóa dịch vụ
        if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
            $sql_insert = "INSERT INTO `contract`(`student_id`,`semester_id`,`room_id`, `total_price`,`status`)
            VALUES ('".$student_id."','".$semester_id."','".$room_id."','".$price."', 2 )";
            $booking = mysqli_query($conn, $sql_insert);
            
            if($booking) {
                echo'
                <!DOCTYPE html>
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <meta name="view">
                        <link rel="stylesheet" href="style.css">
                        <title>Loading</title>
                    </head>
                    <body>
                        <div class="container">
                            <div class="container-loading">
                                <div class="loading" id="loading">
                                    <span style="--i:0">L</span>
                                    <span style="--i:1">o</span>
                                    <span style="--i:2">a</span>
                                    <span style="--i:3">d</span>
                                    <span style="--i:4">i</span>
                                    <span style="--i:5">n</span>
                                    <span style="--i:6">g</span>
                                    <span style="--i:7">.</span>
                                    <span style="--i:8">.</span>
                                    <span style="--i:9">.</span>
                                </div>
                            </div>
                            
                        </div>
                    </body>
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            // Hiển thị nội dung sau 1 giây
                            setTimeout(function() {
                                //document.getElementById('.'loading'.').style.display = '.'none'.';
                                alert("Đăng ký phòng thành công!"); 
                                window.location.href = "../thong_tin_ca_nhan.php";
                            }, 2000);
                            
                        });
                        
                    </script>
                </html>
                                
                ';
                // echo '<script type="text/javascript">
                //         setTimeout(function() {
                //             window.onload = function () { 

                //                 alert("Đăng ký phòng thành công!"); 
                //                 window.location.href = "../thong_tin_ca_nhan.php";
                //             }
                //         }, 2000);
                        
                //         </script>';
            } else {
                echo '<script type="text/javascript">
                        window.onload = function () { 
                            alert("Đã xảy ra lỗi, không thể đăng ký phòng!"); 
                            window.location.href = "../danh_sach_phong.php?id='.$room_type_id.'";
                        }
                        </script>';
            }
        } else {
            // Nếu chưa xác nhận, hiển thị hộp thoại xác nhận
            echo '<script type="text/javascript">
                    if(confirm("Bạn có chắc chắn muốn đăng ký ở phòng này không?")) {
                        window.onload = function () { 
                            window.location.href = "dangky_phong.php?confirm=yes&room_id='.$room_id.'";
                        }
                    } else {
                        window.onload = function () { 
                            window.location.href = "../danh_sach_phong.php?id='.$room_type_id.'";
                        }
                    }
                    </script>';
        }
    }
?>