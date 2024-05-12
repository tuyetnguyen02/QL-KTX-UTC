
<?php
session_start();
require('../database/connect.php');	
require('../database/query.php');


if(isset($_GET['register_services_id'])) {
    $register_services_id = $_GET['register_services_id'];

    // Nếu người dùng đã xác nhận huỷ, thực hiện huỷ 
    if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql_delete = "DELETE FROM register_services WHERE `register_services`.`register_services_id` = '".$register_services_id."'";
        $delete = mysqli_query($conn, $sql_delete);
        
        if($delete) {
            echo '<script type="text/javascript">
                    alert("Huỷ dịch vụ thành công!");
                    window.onload = function () { 
                        window.location.href = "../thong_tin_ca_nhan.php";
                    }
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Đã xảy ra lỗi, không thể huỷ dịch vụ! Bạn cần thử lại."); 
                        window.location.href = "../thong_tin_ca_nhan.php";
                    }
                  </script>';
        }
    } else {
        // Nếu chưa xác nhận, hiển thị hộp thoại xác nhận
        echo '<script type="text/javascript">
                if(confirm("Bạn có chắc chắn muốn huỷ đăng ký dịch vụ không?")) {
                    window.onload = function () { 
                        window.location.href = "huy_dichvu.php?confirm=yes&register_services_id='.$register_services_id.'";
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