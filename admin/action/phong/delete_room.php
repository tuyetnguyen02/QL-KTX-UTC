<?php
session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');
    
    $room_id = $_GET['id'];

    $sql_room = "SELECT * FROM room WHERE room_id = '".$room_id."'"; 
    $room = mysqli_query($conn, $sql_room)->fetch_assoc();

    $sql_roomtype = "SELECT * FROM room_type WHERE room_type_id = '".$room['room_type_id']."'"; 
    $roomtype = mysqli_query($conn, $sql_roomtype)->fetch_assoc();

    $roomtype_id = $room['room_type_id'];

    echo $room_id;

    $sql_delete = "DELETE FROM room WHERE room_id = '".$room_id."'";
    $roomdelete = mysqli_query($conn, $sql_delete);
    
    echo '<script type="text/javascript">
                
                window.onload = function () { 
                    alert("Xoá loại thành công!"); 
                    window.location.href = "../../chi_tiet_loai_phong.php?id=" + ' . $roomtype_id . ';
                }

            </script>';
?>