<?php
session_start();
require('../../../database/connect.php');  
require('../../../database/query.php');

if(isset($_GET['services_id'])) {
    $services_id = $_GET['services_id'];

    // Nếu người dùng đã xác nhận xóa, thực hiện xóa dịch vụ
    if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql_delete = "DELETE FROM services WHERE services_id = '".$services_id."'";
        $services = mysqli_query($conn, $sql_delete);
        
        if($services) {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Xoá dịch vụ thành công!"); 
                        window.location.href = "../../dich_vu.php";
                    }
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Đã xảy ra lỗi, không thể xoá dịch vụ!"); 
                        window.location.href = "../../dich_vu.php";
                    }
                  </script>';
        }
    } else {
        // Nếu chưa xác nhận, hiển thị hộp thoại xác nhận
        echo '<script type="text/javascript">
                if(confirm("Bạn có chắc chắn muốn xoá dịch vụ này không?")) {
                    window.onload = function () { 
                        window.location.href = "delete_services.php?confirm=yes&services_id='.$services_id.'";
                    }
                } else {
                    window.onload = function () { 
                        window.location.href = "../../dich_vu.php";
                    }
                }
              </script>';
    }
}
?>