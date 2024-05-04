<?php
session_start();
require('../../database/connect.php');	
require('../../database/query.php');
// echo "Test";
if(isset($_SESSION['useradmin'])){
    if(isset($_GET['giatri'])){
        $giatri = $_GET['giatri'];
        $giatri = str_replace('\'', '\\\'', $giatri);
        $sql_loaiphong = "SELECT * FROM room_type WHERE room_type_name like '%$giatri%'";
        $loaiphong = mysqli_query($conn,$sql_loaiphong);
        $kq = '';
        $i=0;
        if($loaiphong && $loaiphong->num_rows == 0){
            $kq = "Không tìm thấy dữ liệu";
        }else{
            while($row = $loaiphong->fetch_assoc()){
                $i++;
                $is_air_conditioned = $row['is_air_conditioned'] ? "Có" : "Không";
                $is_cooked = $row['is_cooked'] ? "Không cho phép" : "Cho phép"; // Sửa điều kiện này
                $kq .= "
                <tr>
                    <td>".$i."</td>
                    <td>".$row['room_type_name']."</td>
                    <td>".$is_air_conditioned."</td>
                    <td>".$is_cooked."</td>
                    <td>".$row['max_quantity']."</td>
                    <td>".$row['price']." đ/tháng</td>
                    <td class='img_admin'><img src='../".$row['url_image']."' alt='product' /></td>
                    <td style='color : ".($row['enable'] ? "green" : "red")."'>".($row['enable'] ? "Hoạt động tốt" : "Đang sửa chữa")."</td>
                    <td><li class='breadcrumb-item'><a href='chi_tiet_loai_phong.php?id=".$row['room_type_id']."'>Chi tiết</a></li></td>
                </tr>";
            }
        }
        
        echo $kq; // Xuất ra kết quả
    }
}else{
    header('location: ../dang_nhap.php');
}


?>