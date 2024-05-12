<?php
session_start();
require('../database/connect.php');	
require('../database/query.php');

// $contract_id = $_GET['contract_id'];
// echo $contract_id;

// $sql_delete = "DELETE FROM contract WHERE `contract`.`contract_id` = '".$contract_id."'";
// $delete = queryExecute($conn, $sql_delete);

// if($delete){
//     echo '<script type="text/javascript">
//             alert("Huỷ phòng thành công.");
//             window.onload = function () { 
//                 window.location.href = "../thong_tin_ca_nhan.php";
//             }
//         </script>';
    
// }else{
//     echo '<script type="text/javascript">
//             alert("Huỷ phòng không thành công. Bạn cần thử lại!");
//             window.onload = function () { 
//                 window.location.href = "../thong_tin_ca_nhan.php";
//             }
//         </script>';
// }

if(isset($_GET['contract_id'])) {
    $contract_id = $_GET['contract_id'];

    // Nếu người dùng đã xác nhận huỷ, thực hiện huỷ 
    if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql_delete = "DELETE FROM contract WHERE `contract`.`contract_id` = '".$contract_id."'";
        $delete = mysqli_query($conn, $sql_delete);
        
        if($delete) {
            echo '<script type="text/javascript">
                    alert("Huỷ phòng thành công!");
                    window.onload = function () { 
                        window.location.href = "../thong_tin_ca_nhan.php";
                    }
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Đã xảy ra lỗi, không thể huỷ phòng! Bạn cần thử lại."); 
                        window.location.href = "../thong_tin_ca_nhan.php";
                    }
                  </script>';
        }
    } else {
        // Nếu chưa xác nhận, hiển thị hộp thoại xác nhận
        echo '<script type="text/javascript">
                if(confirm("Bạn có chắc chắn muốn huỷ đăng ký phòng này không?")) {
                    window.onload = function () { 
                        window.location.href = "huy_phong.php?confirm=yes&contract_id='.$contract_id.'";
                    }
                } else {
                    window.onload = function () { 
                        window.location.href = "../thong_tin_ca_nhan.php";
                    }
                }
              </script>';
    }
}
?>