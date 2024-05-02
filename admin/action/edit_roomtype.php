<?php
    session_start();
    require('../../database/connect.php');	
    require('../../database/query.php');


    $is_air_conditioned = $_POST['is_air_conditioned'];
    $is_cooked = $_POST['is_cooked'];
    $max_quantity = $_POST['max_quantity'];
    $price = $_POST['price'];
    $enable = $_POST['enable'];
    
    $roomtypeid = $_GET['id'];

    $sql_update = "UPDATE `room_type` SET `is_air_conditioned` = '".$is_air_conditioned."',`is_cooked` = '".$is_cooked."',
    `max_quantity` = '".$max_quantity."',`price` = '".$price."',`enable` = '".$enable."' WHERE `room_type`.`room_type_id` = '".$roomtypeid."';";
    queryExecute($conn, $sql_update);

    $jsVar = json_encode($roomtypeid);
    echo '<script type="text/javascript">
                 var jsVar = ' . $jsVar . ';
                window.onload = function () { 
                    window.location.href = "../chi_tiet_loai_phong.php?id=" + jsVar;
                    alert("Cập nhật thành công!");
                    
                }

            </script>';
?>