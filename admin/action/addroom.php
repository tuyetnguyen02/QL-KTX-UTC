<?php
    session_start();
    require('../../database/connect.php');	
    require('../../database/query.php');


    $roomname = $_POST['roomname'];
    $gender = $_POST['gender'];
    $enable = $_POST['enable'];
    // $roomtypeid = $roomtype['room_type_id'];
    $roomtypeid = $_GET['id'];

    $sql_insert = "INSERT INTO `room`(`room_name`,`enable`,`room_gender`,`room_type_id`)
    VALUES ('".$roomname."','".$enable."','".$gender."','".$roomtypeid."')";
    queryExecute($conn, $sql_insert);

     $jsVar = json_encode($roomtypeid);
    echo '<script type="text/javascript">
                 var jsVar = ' . $jsVar . ';
                window.onload = function () { 
                    window.location.href = "../chi_tiet_loai_phong.php?id=" + jsVar;
                    alert("Thêm thành công!");
                    
                }

            </script>';
?>