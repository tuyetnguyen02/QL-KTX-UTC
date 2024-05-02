<?php
    session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');

    $room_id = $_GET['room_id'];

    $room_gender = $_POST['room_gender'];
    $enable = $_POST['enable'];    
    echo $room_gender;
    

    $sql_update = "UPDATE `room` SET `room_gender` = '".$room_gender."',`enable` = '".$enable."' WHERE `room`.`room_id` = '".$room_id."';";
    queryExecute($conn, $sql_update);

     $jsVar = json_encode($room_id);
    echo '<script type="text/javascript">
                var jsVar = ' . $jsVar . ';
                window.onload = function () { 
                    window.location.href = "../../chi_tiet_phong.php?room_id=" + jsVar;
                    alert("Cập nhật thành công!");
                    
                }

            </script>';
?>