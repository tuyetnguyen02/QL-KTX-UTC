<?php
session_start();
require('../../../database/connect.php');	
require('../../../database/query.php');

$contract_id = $_GET['contract_id'];

$sql_update = "UPDATE contract SET status = 3 WHERE contract_id =  '".$contract_id."'";
$update = queryExecute($conn, $sql_update);



if($update){
    header("Location: ../../admin_send_email.php?contract_error_id=" . $contract_id);
    exit;
    
}else{
    echo '<script type="text/javascript">
            alert("Huỷ không thành công. Bạn cần thử lại!");
            window.onload = function () { 
                window.location.href = "../../ds_sinhvien_dangky_phong.php";
            }
        </script>';
}
?>