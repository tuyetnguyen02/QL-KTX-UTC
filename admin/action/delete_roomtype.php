<?php
session_start();
    require('../../database/connect.php');	
    require('../../database/query.php');
    
    $roomtype_id = $_GET['id'];

    echo $roomtype_id;
    $sql_delete = "DELETE FROM room_type WHERE room_type_id = '".$roomtype_id."'";
    $room = mysqli_query($conn, $sql_delete);
    echo '<script type="text/javascript">
                
                window.onload = function () { 
                    alert("Xoá loại phòng thành công!"); 
                    window.location.href = "../index.php";
                }

            </script>';
?>