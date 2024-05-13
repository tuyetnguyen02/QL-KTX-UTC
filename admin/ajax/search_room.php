<?php
session_start();
require('../../database/connect.php');	
require('../../database/query.php');
// echo "Test";
if(isset($_SESSION['useradmin'])){
    if(isset($_GET['giatri'])){
        $giatri = $_GET['giatri'];
        $giatri = str_replace('\'', '\\\'', $giatri);
        $sql_phong = "SELECT * FROM room r INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id  WHERE r.room_name like '%$giatri%'";
        $phong = mysqli_query($conn,$sql_phong);
        $kq = '<div class="row">
                <!-- modal list room in roomtype start-->
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên phòng</th>
                                            <th>Số lượng</th>
                                            <th>Giới tính</th>
                                            <th>Hoạt động</th>
                                            <th>Tác vụ</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        $i=0;
        if($phong && $phong->num_rows == 0){
            $kq = "Không tìm thấy dữ liệu";
        }else{
            while($row_room = $phong->fetch_assoc()){
                $i++;
                $kq .= '
                    <tr>
                        <td>' . $i . '</td>
                        <td>' . $row_room['room_name'] . '</td>
                        <td>' . $row_room['current_quantity'] . '/' . $row_room['max_quantity'] . '</td>
                        <td>' . ($row_room['room_gender'] == 0 ?  "Nam" : "Nữ") . '</td>
                        <td><span class="legend-label ' . ($row_room['enable'] ? "text-success" : "text-danger") . '">' . ($row_room['enable'] ? "Đang hoạt động" : "Đang sửa chữa") . '</span></td>
                        <td><li class="breadcrumb-item"><a href="chi_tiet_phong.php?room_id=' . $row_room['room_id'] . '">Chi tiết phòng</a></li></td>
                    </tr>';
            }
        }
        $kq .= '</tbody>
        </table>
    </div>
</div>
</div>
<!-- modal list room in roomtype end-->
</div>';
        echo $kq; // Xuất ra kết quả
    }
}else{
    header('location: ../dang_nhap.php');
}


?>