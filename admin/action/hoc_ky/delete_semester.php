<?php
session_start();
require('../../../database/connect.php');  
require('../../../database/query.php');

if(isset($_GET['semester_id'])) {
    $semester_id = $_GET['semester_id'];

    // Nếu người dùng đã xác nhận xóa, thực hiện xóa dịch vụ
    if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $sql_delete = "DELETE FROM semester WHERE semester_id = '".$semester_id."'";
        $semester = mysqli_query($conn, $sql_delete);
        
        if($semester) {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Xoá học kỳ thành công!"); 
                        window.location.href = "../../hoc_ky.php";
                    }
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    window.onload = function () { 
                        alert("Đã xảy ra lỗi, không thể xoá học kỳ!"); 
                        window.location.href = "../../hoc_ky.php";
                    }
                  </script>';
        }
    } else {
        // Nếu chưa xác nhận, hiển thị hộp thoại xác nhận
        echo '<script type="text/javascript">
                if(confirm("Bạn có chắc chắn muốn xoá học kỳ này không?")) {
                    window.onload = function () { 
                        window.location.href = "delete_semester.php?confirm=yes&semester_id='.$semester_id.'";
                    }
                } else {
                    window.onload = function () { 
                        window.location.href = "../../hoc_ky.php";
                    }
                }
              </script>';
    }
}
?>