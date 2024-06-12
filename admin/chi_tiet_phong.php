<?php require(__DIR__.'/layouts/header.php'); ?> 

<?php
    $i = 1;

    $room_id = $_GET['room_id'];
    //echo $room_id;
    $sql_room = "SELECT * FROM room WHERE room_id = '".$room_id."'"; 
    $room = mysqli_query($conn, $sql_room)->fetch_assoc();

    $sql_roomtype = "SELECT * FROM room_type WHERE room_type_id = '".$room['room_type_id']."'"; 
    $roomtype = mysqli_query($conn, $sql_roomtype)->fetch_assoc();


    $sql_student = "SELECT * FROM student s
            INNER JOIN contract c ON s.student_id = c.student_id
            INNER JOIN room r ON c.room_id = r.room_id
            INNER JOIN semester sem ON sem.semester_id = c.semester_id
            WHERE r.room_id = '".$room_id."' AND c.status = true AND sem.status = true";
    $student = queryResult($conn, $sql_student);
    //$roomtype = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($student == NULL){
            // $sql_delete = "DELETE FROM room_type WHERE room_type_id = '".$roomtype_id."'";
            // $room = mysqli_query($conn, $sql_delete);
            echo '<script type="text/javascript">

                    var result = confirm("Bạn có chắc chắn muốn xoá không?");
                    if (result) {
                        //ok
                        window.location.href = "action/phong/delete_room.php?id=" + ' . $room_id . ';
                    } else {
                        //cancel
                        alert("Hủy bỏ việc xoá?");
                        setTimeout(function() {
                            window.location.href = "chi_tiet_phong.php?room_id=" + ' . $room_id . ';
                        }, 0);
                    }

            </script>';
        }else{
            echo '<script type="text/javascript">
                    window.onload = function () { 
                    
                    alert("Xoá phòng không thành công, sinh viên đang sử dụng phòng này!");
                    setTimeout(function() {
                        window.location.href = "chi_tiet_phong.php?room_id=" + ' . $room_id . ';
                    }, 50); // Tải lại sau 1 giây
                }

            </script>';
        }
    }

    // form add new bill
    $sql_semester = "SELECT * FROM semester WHERE status = true";
    $semester = mysqli_query($conn, $sql_semester)->fetch_assoc();

    $sql_bill = "SELECT * FROM bill b
                LEFT JOIN room r ON r.room_id = b.room_id
                LEFT JOIN student s ON s.student_id = b.student_id
                LEFT JOIN admin ad ON ad.admin_id = b.admin_id1
                LEFT JOIN admin a ON a.admin_id = b.admin_id2
                WHERE b.room_id = '".$room_id."' AND created_date > '".$semester['start_date']."'";
    $bill = mysqli_query($conn, $sql_bill);

    $sql_bill_before = "SELECT bill_id, created_date, initial_electricity, initial_water, final_electricity, final_water
                        FROM bill
                        WHERE room_id = '".$room_id."'
                        ORDER BY created_date DESC
                        LIMIT 1;";
    $bill_before = mysqli_query($conn, $sql_bill_before);
   
    $check_addbill = true;
    if ($bill_before !== false && $bill_before !== null) { // Kiểm tra xem $bill_before không phải là false hoặc null
        $bill_before = $bill_before->fetch_assoc();
        if ($bill_before !== null) { // Kiểm tra xem $bill_before không phải là null
            $initial_electricity = $bill_before['final_electricity'];
            $initial_water = $bill_before['final_water'];
            
            $bill_before_date = new DateTime($bill_before['created_date']); 
            $bill_before_month = $bill_before_date->format('m');
            $bill_before_year = $bill_before_date->format('Y');

            $currentDate = new DateTime(); 
            // $currentDate->modify('-1 month');  Database lưu dữ liệu tại thời điểm tạo
            $current_month = $currentDate->format('m');
            $current_year = $currentDate->format('Y');

            if ($bill_before_month == $current_month && $bill_before_year == $current_year) {
                $check_addbill = false;
            } else {
                $check_addbill = true;
            }
            // check điều kiện đã có bill tháng trước hay chưa
            // echo $check_addbill . ' ' . $bill_before_date->format('Y-m-d') . ' ' . $currentDate->format('Y-m-d');
        } else {
            $initial_electricity = 0;
            $initial_water = 0;
        }
    } else {
        // Xử lý trường hợp khi câu truy vấn không thành công
        $initial_electricity = 0;
        $initial_water = 0;
    }
?>
<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card">
            
                <div class="card-body"style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> THÔNG TIN PHÒNG : <?php echo $room['room_name'];?></h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class=""><a href="chi_tiet_loai_phong.php?id=<?php echo $roomtype['room_type_id'];?>">Quay lại <i class="mdi mdi-arrow-right-bold-circle"></i></a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-sm-12  grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body" >
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th> Loại phòng </th>
                                                <th> Giới tính </th>
                                                <th> Số lượng tối đa </th>
                                                <th> Tình trạng </th>
                                                <th> Nấu ăn </th>
                                                <th> Máy lạnh </th>
                                                <th> Tác vụ </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <form method="POST">
                                            <tr>
                                                <td> <?php echo $roomtype['room_type_name'];?> </td>
                                                <td> <?php echo $room['room_gender'] == 0 ?  "Nam" : "Nữ" ; ?> </td>
                                                <td> <?php echo $roomtype['max_quantity'];?> </td>
                                                <td><span class="legend-label <?php if($room['enable']) echo "text-success"; else echo "text-danger";?>"><?php if($room['enable']) echo "Đang hoạt động"; else echo "Đang sửa chữa";?></span></td>
                                                <td><?php if($roomtype['is_cooked']) echo "Cho phép"; else echo "Không cho phép";?></td>
                                                <td><?php if($roomtype['is_air_conditioned']) echo "Có"; else echo "Không";?></td>
                                                <td> </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    <br>
                                    <div class="mb-2" style="position: absolute;right: 40px;">
                                        <button type="button" class="btn btn-inverse-success btn-fw" id="editroom-btn-open">Chỉnh sửa</button>
                                        <button type="submit" class="btn btn-inverse-danger btn-fw" >Xoá phòng này</button>
                                    </div>
                                    </form>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body"  style="overflow: auto;">
                                    <div class="page-header">
                                        <h3 class="page-title"> Danh sách sinh viên trong phòng </h3> 
                                        <!-- <nav aria-label="breadcrumb">
                                            <button class="btn btn-link btn-rounded btn-fw" id="addroom-btn-open" style="font-size: 16px;"><i class="mdi mdi-plus-circle-outline" style="font-size: 16px;"></i>Thêm hoá đơn điện nước</button>
                                        </nav> -->
                                    </div>
                                    <?php 
                                            if(!$student){ echo '<span class="text-success"></i>Hiện chưa có sinh viên!</span>';}
                                            else{ ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Mã sinh viên</th>
                                                <th>Họ và tên</th>
                                                <th>Ngành(Lớp)</th>
                                                <th>Số điện thoại</th>
                                                <th>Email</th>
                                                <th>Quê quán</th>
                                                <th>Giới tính</th>
                                                <th>Tác vụ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = $student->fetch_assoc()){ ?>
                                            <tr>
                                                <td><?php echo $i; $i++;?></td>
                                                <td><?php echo $row['number_student'];?></td>
                                                <td><?php echo $row['name'];?></td>
                                                <td><?php echo $row['major']; echo '('; echo $row['classroom'].')';?></td>
                                                <td><?php echo $row['phone'];?></td>
                                                <td><?php echo $row['email'];?></td>
                                                <td><?php echo $row['address'] ; ?></td>
                                                <td><?php echo $row['gender'] == 0 ?  "Nam" : "Nữ" ; ?></td>
                                            </tr>
                                            <?php }   } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body"  style="overflow: auto;">
                                    <div class="page-header">
                                        <h3 class="page-title"> Cập nhật tiền điện nước </h3> 
                                        <nav aria-label="breadcrumb">
                                            <button class="btn btn-link btn-rounded btn-fw" id="addroom-btn-open" style="font-size: 16px;">
                                                <?php if($check_addbill == true) {
                                                    echo '<i class="mdi mdi-plus-circle-outline" style="font-size: 16px;"></i> Thêm hoá đơn điện nước';
                                                }?>
                                            </button>
                                        </nav>
                                    </div>
                                    <?php 
                                            if(!$bill){ echo '<span class="text-success"></i>Chưa có hoá đơn điện nước nào!</span>';}
                                            else{ ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Tháng</th>
                                                <th>Chỉ số điện đầu</th>
                                                <th>Chỉ số điện cuối</th>
                                                <th>Chỉ số nước đầu</th>
                                                <th>Chỉ số nước cuối</th>
                                                <th>Tổng tiền thanh toán</th>
                                                <th>SV thanh toán</th>
                                                <th>Người lập</th>
                                                <th>Ngày lập</th>
                                                <th>Người cập nhật</th>
                                                <th>Tình trạng</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = $bill->fetch_assoc()){ ?>
                                            <tr>
                                                <td><?php   $currentDate = new DateTime($row['created_date']); 
                                                            $currentDate->modify('-1 month');
                                                            echo $currentDate->format('m'); ?></td>
                                                <td><?php echo $row['initial_electricity'];?></td>
                                                <td><?php echo $row['final_electricity'];?></td>
                                                <td><?php echo $row['initial_water'];?></td>
                                                <td><?php echo $row['final_water'];?></td>
                                                <td><spam class="money"><?php echo $row['price'];?> (VNĐ)</spam></td>
                                                <td><?php echo $row['name'] ; ?></td>
                                                <td><?php $sql_admin1 = "SELECT admin_name FROM admin WHERE admin_id = '".$row['admin_id1']."'";
                                                            $admin1 = mysqli_query($conn, $sql_admin1)->fetch_assoc();
                                                            echo $admin1['admin_name'] ; ?></td>
                                                <td><?php echo date("d-m-Y", strtotime($row['created_date'])); ?></td>
                                                <td><?php $sql_admin2 = "SELECT admin_name FROM admin WHERE admin_id = '".$row['admin_id2']."'";
                                                            $admin2 = mysqli_query($conn, $sql_admin2)->fetch_assoc();
                                                            if(isset($admin2)) echo $admin2['admin_name'] ; ?></td>
                                                <?php if($row['status_bill']){?>
                                                    <td class="text-success">Đã thanh toán</td>
                                                    <td></td><?php }else{?>
                                                        <td class="text-danger">Chưa thanh toán</td>
                                                        <td><button type="button" id="editbill-btn-open" class="btn btn-link btn-fw">Chỉnh sửa</button></td><?php }?>
                                            </tr>
                                            <?php }   } ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- modal edit roomtype room start-->
                        <div class="col-lg-6 grid-margin stretch-card" id="editroom-wrapper">
                            <div class="card" id="editroom-modal-container">
                                <div class="card-body">
                                    <!-- <div id="demo-wrapper">
                                        <div id="demo-modal-container"> -->
                                            <div class="editroom-modal" id="editroom-modal-demo">
                                                <div class="editroom-modal-header page-header" style="border-bottom: 2px solid #8e94a9; padding-bottom:10px">
                                                    <h3 class="page-title"> Chỉnh sửa thông tin phòng <?php echo $room['room_name']?></h3>
                                                    <button style="border:0px" id="editroom-btn-close"><i class="mdi mdi-close"></i></button>
                                                </div>
                                                <div class="editroom-body card-body" style="padding: 0rem 2.5rem;">
                                                    <form action="action/phong/edit_room.php?room_id=<?php echo $room_id;?>" method="POST">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label" style="color:black;" >Tên loại phòng</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control"  disabled name="roomtype_name" value="<?php echo $roomtype['room_type_name'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label" style="color:black;" >Giới tính</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control" required name="room_gender" <?php if($student != NULL) echo "disabled";?>>
                                                                    <option value="<?php echo $room['room_gender'];?>" style="display: none;"><?php echo $room['room_gender'] == 0 ?  "Nam" : "Nữ" ;?></option>
                                                                    <option value="0">Nam</option>
                                                                    <option value="1">Nữ</option>
                                                                    <!-- <option value=""><?php //if($student) echo "disabled";?></option> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label" style="color:black;">Tình trạng</label>
                                                            <div class="col-sm-9">
                                                                <select class="form-control"  required name="enable">
                                                                    <option value="<?php echo $room['enable'];?>" style="display: none;"><?php if($room['enable']) echo "Đang hoạt động"; else echo "Đang sửa chữa";?></option>
                                                                    <option value="1">Hoạt động tốt</option>
                                                                    <option value="0">Đang sửa chữa</option>
                                                                </select>
                                                            </div><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                                        </div>
                                                        
                                                        <div class="form-group row">
                                                            <div class="col-12 btn--seve" >
                                                                <button type="submit" class="btn btn-outline-success btn-fw "style=" float: right;"> Cập nhật </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <!-- </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- modal edit roomtype end-->
                    </div>
                    <div class="row">
                        <!-- modal add bill start-->
                        
                        <div class="col-lg-6 grid-margin stretch-card" id="addroom-wrapper">
                            <div class="card" id="addroom-modal-container">
                                <div class="card-body">
                                    <!-- <div id="demo-wrapper">
                                        <div id="demo-modal-container"> -->
                                            <div class="addroom-modal" id="addroom-modal-demo">
                                                <div class="addroom-modal-header page-header" style="border-bottom: 2px solid #8e94a9; padding-bottom:10px">
                                                    <h3 class="page-title"> Thêm hoá đơn điện nước </h3>
                                                    <button style="border:0px" id="addroom-btn-close"><i class="mdi mdi-close"></i></button>
                                                </div>
                                                <div class="addroom-modal-body card-body" style="padding: 0rem 2.5rem;">
                                                    <form action="action/dien_nuoc/add_bill.php?room_id=<?php echo $room['room_id'];?>" method="POST">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Tên phòng</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control chucvu" disabled name="room_name" value="<?php echo $room['room_name'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số điện đầu</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" readonly name="initial_electricity" value="<?php echo $initial_electricity;?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số điện cuối</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" required placeholder="Chỉ số phải lớn hơn chỉ số đầu" name="final_electricity">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số nước đầu</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" readonly name="initial_water" value="<?php echo $initial_water;?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số nước cuối</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" required placeholder="Chỉ số phải lớn hơn chỉ số đầu" name="final_water">
                                                            </div><br><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-12 btn--seve">
                                                                <button type="submit" class="btn btn-outline-success btn-fw"style=" float: right;"> Tạo hoá đơn </button>
                                                                <!-- <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <!-- </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- modal add bill end-->
                    </div>
                    <div class="row">
                        <!-- modal edit bill start-->
                        <div class="col-lg-6 grid-margin stretch-card" id="editbill-wrapper">
                            <div class="card" id="editbill-modal-container">
                                <div class="card-body">
                                    <!-- <div id="demo-wrapper">
                                        <div id="demo-modal-container"> -->
                                            <div class="editbill-modal" id="editbill-modal-demo">
                                                <div class="editbill-modal-header page-header" style="border-bottom: 2px solid #8e94a9; padding-bottom:10px">
                                                    <h3 class="page-title"> Chỉnh sửa hoá đơn điện nước </h3>
                                                    <button style="border:0px" id="editbill-btn-close"><i class="mdi mdi-close"></i></button>
                                                </div>
                                                <div class="editbill-modal-body card-body" style="padding: 0rem 2.5rem;">
                                                    <form action="action/dien_nuoc/edit_bill.php?bill_id=<?php echo $bill_before['bill_id'];?>" method="POST">
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Tên phòng</label>
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control chucvu" disabled name="room_name" value="<?php echo $room['room_name'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số điện đầu</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" readonly name="initial_electricity" value="<?php echo $bill_before['initial_electricity'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số điện cuối</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" required placeholder="Chỉ số phải lớn hơn chỉ số đầu" name="final_electricity" value="<?php echo $bill_before['final_electricity'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số nước đầu</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" readonly name="initial_water" value="<?php echo $bill_before['initial_water'];?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-sm-4 col-form-label" style="color:black;" required>Chỉ số nước cuối</label>
                                                            <div class="col-sm-8">
                                                                <input type="number" class="form-control chucvu" required placeholder="Chỉ số phải lớn hơn chỉ số đầu" name="final_water" value="<?php echo $bill_before['final_water'];?>">
                                                            </div><br><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-12 btn--seve">
                                                                <button type="submit" class="btn btn-outline-success btn-fw"style=" float: right;"> Cập nhật </button>
                                                                <!-- <button type="submit" class="btn btn-primary mr-2">Submit</button> -->
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        <!-- </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <!-- modal edit bill end-->
                    </div>
                </div>
            
        </div>
    </div>
    <script>
         // css money
         document.addEventListener('DOMContentLoaded', function () {
            function formatCurrency(number) {
                return number.toLocaleString('vi-VN');
            }

            var priceElements = document.querySelectorAll('.money');

            priceElements.forEach(function(priceElement) {
                var priceText = priceElement.textContent;
                var priceValue = parseInt(priceText.replace(' (VNĐ)', '').replace(/\./g, ''));

                if (!isNaN(priceValue)) {
                    priceElement.textContent = formatCurrency(priceValue) + ' (VNĐ)';
                }
            });
        });

        const open = document.getElementById('addroom-btn-open');
        // console.log(show);
        const close = document.getElementById('addroom-btn-close');
 
        const modal_container = document.getElementById('addroom-modal-container');
 
        open.addEventListener('click', ()=>{
            modal_container.classList.add('show');
        });
        close.addEventListener('click', ()=>{
            modal_container.classList.remove('show');
        });
        // script for modal editroom 

        const openeditroom = document.getElementById('editroom-btn-open');
        // console.log(show);
        const closeeditroom = document.getElementById('editroom-btn-close');
 
        const modal_container_editroom = document.getElementById('editroom-modal-container');
 
        openeditroom.addEventListener('click', ()=>{
            modal_container_editroom.classList.add('show');
        });
        closeeditroom.addEventListener('click', ()=>{
            modal_container_editroom.classList.remove('show');
        });
        // edit bill
        const openeditbill = document.getElementById('editbill-btn-open');
        // console.log(show);
        const closeeditbill = document.getElementById('editbill-btn-close');
 
        const modal_containereditbill = document.getElementById('editbill-modal-container');
 
        openeditbill.addEventListener('click', ()=>{
            modal_containereditbill.classList.add('show');
        });
        closeeditbill.addEventListener('click', ()=>{
            modal_containereditbill.classList.remove('show');
        });
        
       
        </script>

<?php require(__DIR__.'/layouts/footer.php'); ?> 