<?php
session_start();
require('../../database/connect.php');	
require('../../database/query.php');
$number_admin = $_SESSION["useradmin"];
//echo $number_student;
$sql_admin = "SELECT * FROM admin WHERE number_admin = '".$number_admin."'";
$admin = mysqli_query($conn, $sql_admin)->fetch_assoc();

$admin_id = $admin['admin_id'];
$send_date = $_GET['send_date'];
$feedback_id = $_GET['feedback_id'];
$status = true;

    // $sql_update = "UPDATE `feedback` SET `status` = '1' ,`admin_id` = '".$admin_id."' WHERE `feedback_id` = '".$feedback_id."';";
    $sql_update = "UPDATE `feedback` SET `status` = '".$status."', `admin_id` = '".$admin_id."' WHERE `feedback`.`feedback_id` = '".$feedback_id."';";
    $update = queryExecute($conn, $sql_update);

    if(isset($update)){
        header("Location: ../admin_send_email.php?feedback_id=" . $feedback_id . "&send_date=" . $send_date);
        exit;

        // $jsVar = json_encode($send_date);
        // echo '<script type="text/javascript">
        //     var jsVar = ' . $jsVar . ';
        //     alert("Gửi thông báo thành công! " + jsVar);
        //     window.onload = function () { 
        //         window.location.href = "../sua_chua_vat_chat.php";
        //     }

        // </script>';
    }else{
        echo '<script type="text/javascript">
            alert("Gửi thông báo không thành công! ");
            window.onload = function () { 
                window.location.href = "../sua_chua_vat_chat.php";
            }
        </script>';
    }
    // lỗi khi chọn ngày nhưng lại không link sang bên này . chỉnh type thành button mới được . chưa kiểm soát không điền vào input
?>