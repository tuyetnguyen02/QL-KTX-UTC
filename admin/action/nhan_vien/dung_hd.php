<?php
session_start();
require('../../../database/connect.php');  
require('../../../database/query.php');

if(isset($_GET['admin_id'])) {
    $admin_id = $_GET['admin_id'];

    // Nếu người dùng đã xác nhận xóa, thực hiện xóa dịch vụ
    if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql_update = "UPDATE admin SET status = '0' WHERE admin_id = '".$admin_id."'";
        $update = mysqli_query($conn, $sql_update);
        
        if($update) {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Dừng hoạt động thành công!"); 
                        window.location.href = "../../ds_nhanvien.php";
                    }
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Đã xảy ra lỗi, không thể xoá dịch vụ!"); 
                        window.location.href = "../../ds_nhanvien.php";
                    }
                  </script>';
        }
    } else {
        // Nếu chưa xác nhận, hiển thị hộp thoại xác nhận
        echo '<script type="text/javascript">
                if(confirm("Bạn có chắc chắn muốn dừng tài khoản này không?")) {
                    window.onload = function () { 
                        window.location.href = "dung_hd.php?confirm=yes&admin_id='.$admin_id.'";
                    }
                } else {
                    window.onload = function () { 
                        window.location.href = "../../ds_nhanvien.php";
                    }
                }
              </script>';
    }
}
?>