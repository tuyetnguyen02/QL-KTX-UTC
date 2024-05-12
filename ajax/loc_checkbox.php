<?php
// Kết nối cơ sở dữ liệu và tệp query.php nếu cần
session_start();
require('../database/connect.php');  
require('../database/query.php');

// Kiểm tra xem có giá trị của các checkbox được gửi lên không
if(isset($_GET['giatri']) && isset($_GET['airConditioned']) && isset($_GET['cooked'])) {
    // Khai báo các biến để lưu trữ giá trị của checkbox
    $airConditioned = isset($_GET['airConditioned']) ? $_GET['airConditioned'] : 0;
    $cooked = isset($_GET['cooked']) ? $_GET['cooked'] : 0;
    $giatri = $_GET['giatri'];
    $giatri = str_replace('\'', '\\\'', $giatri);
    // Tạo câu truy vấn dựa trên giá trị của các checkbox
    $sql_loaiphong = "SELECT * FROM room_type WHERE 1";

    if($airConditioned == 1) {
        $sql_loaiphong .= " AND is_air_conditioned = 1";
    }

    if($cooked == 1) {
        $sql_loaiphong .= " AND is_cooked = 1";
    }
    if($giatri > 0){
        $sql_loaiphong .= " AND max_quantity = '".$giatri."'";
    }
    $loaiphong = mysqli_query($conn,$sql_loaiphong);
    $kq = '';
    if($loaiphong && $loaiphong->num_rows == 0){
        $kq = "Không có loại phòng phù hợp";
    }else{
        while($row = $loaiphong->fetch_assoc()){
            $kq .= '
            <div class="col-lg-4 col-sm-6">
                <a href="danh_sach_phong.php?id='. $row['room_type_id'] .'">
                    <div class="card_item_roomtype text-black">
                        <i class="fa fa-home fa-lg pt-3 pb-1 px-3 mb-2"></i>
                        <div class="product-header">
                            <img src="'. $row['url_image'] .'" class="d-block w-100" alt="..." />
                        </div>

                        <div class="product-card--body">
                            <div class="text-center">
                                <h5 class="card-title" style="font-weight: bolder">'. $row['room_type_name'] .'</h5>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="fa fa-snowflake"></i> Máy lạnh</span>
                                    <span>'. ($row['is_air_conditioned'] ? "Có" : "Không") .'</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="fa fa-fish"></i> Nấu ăn</span>
                                    <span>'. ($row['is_cooked'] ? "Cho phép" : "Không cho phép") .'</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span><i class="fa fa-user-friends"></i> Số lượng</span>
                                    <span>'. $row['max_quantity'] .'</span>
                                </div>
                                <div class="text-center">
                                    <span class="text-center '. ($row['enable'] ? "text-success" : "text-warning") .'" style="font-weight: bold">'. ($row['enable'] ? "Hoạt động tốt" : "Đang sửa chữa") .'</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between total font-weight-bold">
                                <span><i class="fa fa-money-check-alt"></i> Giá</span>
                                <span>'. $row['price'] .'đ/tháng</span> 
                            </div>
                        </div>
                    </div>
                </a>
            </div>';
        }
    }
    
    echo $kq; // Xuất ra kết quả
} else {
    // Không có giá trị của checkbox được gửi lên
    echo "Không có giá trị của checkbox được gửi lên.";
}
?>
