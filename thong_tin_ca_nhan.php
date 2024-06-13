<?php require(__DIR__.'/layouts/header.php'); ?> 

<?php

if(!isset($_SESSION['login'])){
	echo "<script>window.location.href = 'dang-nhap.php';</script>";
}

$number_student = $_SESSION['user'];
//echo $number_student;
$sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
$sv = mysqli_query($conn, $sql_sv)->fetch_assoc();

$msv = $sv['student_id'];

// goi data cho dịch vụ đặt phòng
$sql_contract = "SELECT * FROM contract WHERE student_id = '".$msv."'";
$contract = mysqli_query($conn, $sql_contract)->fetch_assoc();

$sql_semester = "SELECT * FROM semester WHERE status = true";
$semester = mysqli_query($conn, $sql_semester)->fetch_assoc();

if($contract){
    //echo $contract['room_id'];
    $room_id = $contract['room_id'];
    //$semester_id = $contract['semester_id'];

    $sql_room = "SELECT * FROM room WHERE room_id = '".$room_id."'";
    $room = mysqli_query($conn, $sql_room)->fetch_assoc();
    $room_type_id = $room['room_type_id'];

    

    $sql_roomtype = "SELECT * FROM room_type WHERE room_type_id = '".$room_type_id."'";
    $room_type = mysqli_query($conn, $sql_roomtype)->fetch_assoc();

    // hiển thị hoá đoan điện nước
    $sql_bill = "SELECT * FROM bill b
    LEFT JOIN room r ON r.room_id = b.room_id
    LEFT JOIN student s ON s.student_id = b.student_id
    LEFT JOIN admin ad ON ad.admin_id = b.admin_id1
    LEFT JOIN admin a ON a.admin_id = b.admin_id2
    WHERE b.room_id = '".$room_id."' AND created_date > '".$semester['start_date']."'";
    $bill = mysqli_query($conn, $sql_bill);

}
// gọi data cho dịch vụ gửi xe máy, xe đạp và dịch vụ dọn vệ sinh
$sql_services_guixemay = "SELECT * FROM services WHERE services_name = 'Gửi xe máy'";
$services_guixemay = mysqli_query($conn, $sql_services_guixemay)->fetch_assoc();
$sql_services_guixedap = "SELECT * FROM services WHERE services_name = 'Gửi xe đạp'";
$services_guixedap = mysqli_query($conn, $sql_services_guixedap)->fetch_assoc();
$sql_services_vesinh = "SELECT * FROM services WHERE services_name = 'Vệ sinh khu vực'";
$services_vesinh = mysqli_query($conn, $sql_services_vesinh)->fetch_assoc();

$sql_guixemay = "SELECT * FROM register_services WHERE semester_id = '".$semester['semester_id']."' AND student_id = '".$msv."'AND services_id = '".$services_guixemay['services_id']."'";
$guixe_may = mysqli_query($conn, $sql_guixemay)->fetch_assoc();

$sql_guixedap = "SELECT * FROM register_services WHERE semester_id = '".$semester['semester_id']."' AND student_id = '".$msv."'AND services_id = '".$services_guixedap['services_id']."'";
$guixe_dap = mysqli_query($conn, $sql_guixedap)->fetch_assoc();

$sql_vesinh = "SELECT * FROM register_services WHERE semester_id = '".$semester['semester_id']."' AND student_id = '".$msv."'AND services_id = '".$services_vesinh['services_id']."'";
$vesinh = mysqli_query($conn, $sql_vesinh)->fetch_assoc();
// đưa thông tin lên trang thông tin cá nhân của api student -----------------------------------------

// echo $services_guixemay['services_id'];
// echo $guixe_may['semester_id'];

// if($guixe_may == NULL) echo "Khong co dịch vụ gửi xe máy";

//fomat dateTame
$currentDate = new DateTime(); 
$currentDate->modify('-1 month'); // lấy ra tháng trước thời điểm hiện tại 04 -> 03
// echo $currentDate->format('m');

/////// kiểm tra nhap password và update password
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $matkhau1 = $_POST['matkhau1'];
    $matkhau2 = $_POST['matkhau2'];
    if($matkhau1 == $matkhau2){
        $sql_update= "UPDATE `student` SET `password`='".$matkhau1."' WHERE student_id = ".$msv."";
	    $capnhat = queryExecute($conn,$sql_update);
        echo '<script type="text/javascript">

                window.onload = function () { alert("Cập nhật thành công!");}
                setTimeout(function() {
                    window.location.href = "thong_tin_ca_nhan.php";
                }, 1000); // Tải lại sau 1 giây
            </script>';
    }
    else
        echo '<script type="text/javascript">

                window.onload = function () { alert("Nhập sai mật khẩu"); }

            </script>';
}



// biến total_dicvu : tính tổng tiền cần thanh toán
$total_dichvu = 0;
?>

    <section class="breadcrumb-section">
        <h2 class="sr-only">Site Breadcrumb</h2>
        <div class="container">
            <div class="breadcrumb-contents">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                        <li class="breadcrumb-item active">Thông tin cá nhân</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>
    <div class="page-section inner-page-sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-6 col-12 mt--30 mt-lg--0">
                            <div class="tab-content" id="myaccountContent">
                                <!-- thong tin tài khoản -->
                                <div class="" id="account-info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Thông tin sinh viên</h3>
                                        <div class="account-details-form">
                                            <form method="GET">
                                                <div class="row">
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Họ và tên</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Họ tên.."
                                                            type="text" required name="tensinhvien" disabled value="<?php echo $sv['name']; ?>">
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Mã sinh viên</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Mã sinh viên.."
                                                            type="text" required name="masinhvien" disabled value="<?php echo $sv['number_student']; ?>">
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Ngày sinh</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Ngày sinh.."
                                                            type="text" required name="ngaysinh" disabled value="<?php echo date("d-m-Y", strtotime($sv['birthday'])); ?>">
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Giới tính</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Giới tính.."
                                                            type="text" required name="gioitinh" disabled value="<?php if($sv['gender'] == 1) echo "Nữ";
                                                                                                                        else echo "Nam"; ?>">
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Email</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Email.."
                                                            type="text" required name="email" disabled value="<?php echo $sv['email']; ?>">
                                                    </div>
                                                    
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Chuyên ngành</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Chuyên ngành.."
                                                            type="text" required name="chuyennganh" value="<?php echo $sv['major']; ?>">
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Lớp</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Lớp.."
                                                            type="text" required name="lop" disabled value="<?php echo $sv['classroom']; ?>">
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Số điện thoại</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Số điện thoại.."
                                                            type="text" required name="sodienthoai" disabled value="<?php echo $sv['phone']; ?>">
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-3 " >Hộ khẩu</p>
                                                        <p>:</p>
                                                        <input class="col-8"  placeholder="Hộ khẩu.."
                                                            type="text" required name="hokhau" disabled value="<?php echo $sv['address']; ?>">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                            </div>
                        </div>
                        <!-- My Account Tab Content End -->

                        <div class="col-lg-6 col-12 mt--30 mt-lg--0">
                            <div class="tab-content" id="myaccountContent">
                                <!-- thong tin tài khoản -->
                                <div class="" id="account-info" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3>Dịch vụ đăng ký</h3>
                                        <div class="account-details-form">
                                            <!-- <form method="GET"> -->
                                                <div class="row">
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-2 " >Phòng</p>
                                                        <p>:</p>
                                                        <?php if($contract){?>
                                                        
                                                        <p class="col-3 " ><?php echo $room['room_name']; ?></p>
                                                        <p class="col-2 " >Loại Phòng</p>
                                                        <p>:</p>
                                                        <p class="col-3 " ><?php echo $room_type['room_type_name']; ?></p>
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-2 " >Thời gian ở</p>
                                                        <p>:</p>
                                                        <span class="col-8 " ><?php echo date("d-m-Y", strtotime($semester['start_date'])); ?> đến <?php echo date("d-m-Y", strtotime($semester['end_date'])); ?></span>
                                                        <!-- <p class="col-1">đến</p>
                                                        <p class="col-2 " ></p> -->
                                                    </div>
                                                    <div class="col-12  mb--30 aaaaa">
                                                        <p class="col-2 " >Trạng thái </p>
                                                        <p>:</p><?php 
                                                            switch($contract['status']) {
                                                                case 1:
                                                                    ?>
                                                                    <p class="col-8 text-success" >Đã thanh toán</p>
                                                                    <?php
                                                                    break;
                                                                case 0:
                                                                    $total_dichvu += $room_type['price'];
                                                                    ?>
                                                                    <p class="col-3 text-warning" >Chưa thanh toán</p>
                                                                    <p class="col-3 text-warning" ><a href="xu_ly_thanh_toan.php?total_price=<?php echo $room_type['price'];?>&contract_id=<?php echo $contract['contract_id'];?>">Thanh toán</a></p>
                                                                    <p class="col-1" style="color : red;"><a href="action/huy_phong.php?contract_id=<?php echo $contract['contract_id'];?>">Huỷ</a></p>
                                                                    <?php
                                                                    break;
                                                                case 2:
                                                                    ?>
                                                                    <p class="col-6 text-warning" >Đợi phê duyệt đơn đăng ký</p>
                                                                    <p class="col-1" style="color : red;"><a href="action/huy_phong.php?contract_id=<?php echo $contract['contract_id'];?>">Huỷ</a></p>
                                                                    <?php
                                                                    break;
                                                                case 3:
                                                                    ?>
                                                                    <p class="col-6 text-warning" >Đơn đăng ký không hợp lệ</p>
                                                                    <p class="col-1" style="color : red;"><a href="action/huy_phong.php?contract_id=<?php echo $contract['contract_id'];?>">Huỷ</a></p>
                                                                    <?php
                                                                    break;  
                                                                default:
                                                                    ?>
                                                                    <p class="col-6 " style="color: blue;">Chưa đăng kí phòng</p>
                                                                    <p class="col-2 text-warning" ><a href="loai_phong.php">Đăng ký</a></p>
                                                                    <?php
                                                                    break;
                                                            }
                                                            ?>
                                                        <?php } else{?>
                                                            <p class="col-6 " style="color: blue;">Chưa đăng kí phòng</p>
                                                            <p class="col-2 text-warning" ><a href="loai_phong.php">Đăng ký</a></p>
                                                            <?php }?>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="col-12" style="border-top: 1px dotted #000;"></p>
                                                    </div>
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-2 " >Gửi xe</p>
                                                        <p>:</p>
                                                        <?php if($guixe_may != NULL) { ?>
                                                            <p class="col-3 " >xe máy (<?php echo $guixe_may['motorbike_license_plate'];?>)</p>
                                                            <?php if($guixe_may['status'] == false){ $total_dichvu += $guixe_may['price'];?>
                                                            <p class="col-3 text-warning" ><a href="xu_ly_thanh_toan.php?total_price=<?php echo $guixe_may['price'];?>&register_xemay_id=<?php echo $guixe_may['register_services_id'];?>">Thanh toán</a></p>
                                                            <p class="col-1" style="color : red;"><a href="action/huy_dichvu.php?register_services_id=<?php echo $guixe_may['register_services_id'];?>">Huỷ</a></p><?php }else {?>
                                                                <p class="col-4 text-success" >Đã thanh toán</p>
                                                                <?php } } else{if($guixe_dap != NULL){?>
                                                            <p class="col-3 " >xe đạp</p>
                                                            <?php if($guixe_dap['status'] == false){ $total_dichvu += $guixe_dap['price'];?>
                                                                <p class="col-3 text-warning" ><a href="xu_ly_thanh_toan.php?total_price=<?php echo $guixe_dap['price'];?>&register_xedap_id=<?php echo $guixe_dap['register_services_id'];?>">Thanh toán</a></p>
                                                                <p class="col-1" style="color : red;"><a href="action/huy_dichvu.php?register_services_id=<?php echo $guixe_dap['register_services_id'];?>">Huỷ</a></p><?php }else {?>
                                                                    <p class="col-4 text-success" >Đã thanh toán</p>
                                                            <?php } }else{?>
                                                                <p class="col-6 ">Chưa đăng kí dịch vụ</p>
                                                                <p class="col-2 text-warning" ><a href="dich_vu.php">Đăng ký</a></p>
                                                                <?php }} ?>
                                                    </div>

                                                    <div class="col-12">
                                                        <p class="col-12" style="border-top: 1px dotted #000;"></p>
                                                    </div> 
                                                    
                                                    <div class="col-12  mb--20 aaaaa">
                                                        <p class="col-2 " >Dịch vụ vệ sinh khu vực</p>
                                                        <p>:</p>
                                                        <?php if($vesinh != NULL) { if($vesinh['status'] == false){ $total_dichvu += $vesinh['price'];?>
                                                            <p class="col-3 text-warning" >Chưa thanh toán</p>
                                                            <p class="col-3 text-warning"><a href="xu_ly_thanh_toan.php?total_price=<?php echo $vesinh['price'];?>&register_vesinh_id=<?php echo $vesinh['register_services_id'];?>">Thanh toán</a></p>
                                                            <p class="col-1" style="color : red;"><a href="action/huy_dichvu.php?register_services_id=<?php echo $vesinh['register_services_id'];?>">Huỷ</a></p><?php }else{?>
                                                            <p class="col-9 text-success" >Đã thanh toán</p>
                                                            <?php } } else { ?>
                                                            <p class="col-6 " >Chưa đăng kí dịch vụ</p>
                                                            <p class="col-2 text-warning" ><a href="dich_vu.php">Đăng ký</a></p>
                                                            <?php }?>
                                                    </div>
                                                    <?php if($total_dichvu != 0): ?>
                                                        <div class="col-12 mb--20 row">
                                                            <div class="col-sm-7"></div>
                                                            <form method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="xu_ly_thanh_toan.php?total_price=<?php echo $total_dichvu;  
                                                                if(isset($contract['status']) && !$contract['status']) echo '&contract_id='.$contract['contract_id'];
                                                                if(isset($vesinh['status']) && !$vesinh['status']) echo '&register_vesinh_id='.$vesinh['register_services_id'];
                                                                if(isset($guixe_may['status']) && !$guixe_may['status']) echo '&register_xemay_id='.$guixe_may['register_services_id'];
                                                                if(isset($guixe_dap['status']) && !$guixe_dap['status']) echo '&register_xedap_id='.$guixe_dap['register_services_id'];
                                                                ?>">
                                                                <button type="submit" class="btn btn--primary" style="padding: 5px 10px;">Thanh toán toàn bộ</button>
                                                            </form><br>
                                                        </div>
                                                    <?php endif; ?>
                                                    <!-- <div class="col-12 mb--20 row" >
                                                        <div class="col-sm-7"></div>
                                                        <form method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="xu_ly_thanh_toan.php?total_price=<?php //echo $total_dichvu;  
                                                                                                                                                    //if(isset($contract['status']) && !$contract['status']) echo '&contract_id='.$contract['contract_id'];
                                                                                                                                                    //if(isset($vesinh['status']) && !$vesinh['status']) echo '&register_vesinh_id='.$vesinh['register_services_id'];
                                                                                                                                                    //if(isset($guixe_may['status']) && !$guixe_may['status']) echo '&register_xemay_id='.$guixe_may['register_services_id'];
                                                                                                                                                    //if(isset($guixe_dap['status']) && !$guixe_dap['status']) echo '&register_xedap_id='.$guixe_dap['register_services_id'];
                                                                                                                                                    ?>">
                                                                                                                                                        <button type="submit" class="btn btn--primary" style="padding: 5px 10px;">Thanh toán toàn bộ</button>
                                                                                                                                                    </form><br>
                                                    </div> -->
                                                </div>
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                </div>
                                <!-- Single Tab Content End -->
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <button class="btn btn--primary" id="demo-btn-open" >Thay đổi mật khẩu</button>
    </div>
<!-- thông tin tiền điện nước start-->
<main class="inner-page-sec-padding-bottom bill">
    <div class="container">
        <section>
            <div class="container1" >
                <div class="row my-6">
                    <div class="col-sm-12 bill" style="align-items: center;">
                        <h4>Hoá đơn điện nước</h4>
                    </div>
                    <div class="col-sm-12">
                        <p>
                        - Lưu ý: hạn đóng tiền điện nước
                        <span style="font-weight: bold; color: lightcoral"
                            >từ ngày nhận thông báo đến ngày cuối cùng trong tháng</span
                        >
                        . Nếu không thanh toán đúng hạn sẽ bị
                        <span style="font-weight: bold">CẮT ĐIỆN NƯỚC</span> theo quy định.
                        </p>
                    </div>
                </div>
                <table class="table text-center">
                    <thead class="table-dark">
                    <tr>
                        <th>Tháng</th>
                        <th>Chỉ số điện đầu</th>
                        <th>Chỉ số điện cuối</th>
                        <th>Chỉ số nước đầu</th>
                        <th>Chỉ số nước cuối</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thanh toán</th>
                    </tr>
                    </thead>
                    <?php if(isset($contract) && $contract['status'] == 1){?>
                    <tbody>
                        <?php if(isset($bill)){
                            while($row = $bill->fetch_assoc()){?>
                            <tr>
                                <td><?php   $currentDate = new DateTime($row['created_date']); 
                                            $currentDate->modify('-1 month');
                                            echo $currentDate->format('m'); ?></td>
                                <td><?php echo $row['initial_electricity'];?></td>
                                <td><?php echo $row['final_electricity'];?></td>
                                <td><?php echo $row['initial_water'];?></td>
                                <td><?php echo $row['final_water'];?></td>
                                <td class="money"><?php echo $row['price'];?> (VNĐ)</td>
                                <td><?php echo date("d-m-Y", strtotime($row['created_date'])); ?></td>
                                <?php if($row['status_bill']){?>
                                    <td class="text-success">Đã thanh toán</td>
                                    <td></td>
                                    <?php }else{?>
                                        <td class="text-warning">Chưa thanh toán</td>
                                        <td><a href="xu_ly_thanh_toan.php?total_price=<?php echo $row['price'];?>&bill_id=<?php echo $row['bill_id'];?>" class="text-warning">Thanh toán</a></td>
                                    <?php }?>
                            </tr>
                        <?php } } ?>
                    </tbody>
                    <?php } ?>
                </table>
                </div>
            </div>

        </section>
    </div>
</main>
<!-- thông tin tiền điện nước end-->

    <!-- Modal edit update password start-->

    <div id="demo-wrapper">
        <div id="demo-modal-container">
            <div class="demo-modal" id="demo-modal-demo">
                <div class="demo-modal-header">
                    <h3>Thay đổi mật khẩu</h3>
                    <button class="btn-close" id="demo-btn-close">Đóng</button>
                </div>
                <div class="demo-modal-body">
                    <form method="POST">
                        <div class="col-12  mb--20 aaaaa">
                            <p class="col-4 " >Mật khẩu hiện tại</p>
                            <p>:</p>
                            <input class="col-6"  placeholder="Mật khẩu hiện tại.."
                                type="text" required name="matkhau" disabled value="<?php echo $sv['password']; ?>">
                        </div>
                        <div class="col-12  mb--20 aaaaa">
                            <p class="col-4 " >Nhập mật khẩu mới</p>
                            <p>:</p>
                            <input class="col-6" placeholder="Mật khẩu mới.."
                                        type="password" name="matkhau1">
                        </div>
                        <div class="col-12  mb--20 aaaaa">
                            <p class="col-4 " >Nhập lại mật khẩu</p>
                            <p>:</p>
                            <input class="col-6" placeholder="Nhập lại.."
                                        type="password" name="matkhau2">
                        </div>
                        <div class="col-12 btn--seve">
                            <button class="btn btn--primary" type="submit" id="demo-btn-close">Cập Nhật</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal edit update password end-->
    <script>
        const open = document.getElementById('demo-btn-open');
        // console.log(show);
        const close = document.getElementById('demo-btn-close');
 
        const modal_container = document.getElementById('demo-modal-container');
 
        open.addEventListener('click', ()=>{
            modal_container.classList.add('show');
        });
        close.addEventListener('click', ()=>{
            modal_container.classList.remove('show');
        });

        function tai_lai_trang(){
            location.reload();
        }
        // modal_container.addEventListener('click', (e)=>{
        //     if(!modal_demo.contains(e.target)){
        //         close.click();
        //     }
        // });

        //26-05 phát hiện ra lỗi không sử dụng đến
        // document.getElementById("submit_btn_guixe").addEventListener("click", function() {
        //     document.getElementById("form_guixe").submit(); 
        // });
        // document.getElementById("submit_btn_dv").addEventListener("click", function() {
        //     document.getElementById("form_dv").submit(); 
        // });
        document.addEventListener('DOMContentLoaded', function () {
            function formatCurrency(number) {
                return number.toLocaleString('vi-VN');
            }

            var priceElements = document.querySelectorAll('.money');

            priceElements.forEach(function(priceElement) {
                var priceText = priceElement.textContent;
                var priceValue = parseInt(priceText.replace('(VNĐ)', '').replace(/\./g, ''));

                if (!isNaN(priceValue)) {
                    priceElement.textContent = formatCurrency(priceValue) + '(VNĐ)';
                }
            });
        });
    </script>

<?php require(__DIR__.'/layouts/footer.php'); ?>

