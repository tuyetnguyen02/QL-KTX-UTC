<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php

    $i=1;
    $roomtype_id = $_GET['id'];

    $sql_loaiphong = "SELECT * FROM room_type WHERE room_type_id = '".$roomtype_id."'";
	$roomtype = mysqli_query($conn, $sql_loaiphong)->fetch_assoc();

    $sql_room = "SELECT * FROM room WHERE room_type_id = '".$roomtype_id."'"; 
    $room = queryResult($conn, $sql_room);
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($room == NULL){
            // $sql_delete = "DELETE FROM room_type WHERE room_type_id = '".$roomtype_id."'";
            // $room = mysqli_query($conn, $sql_delete);
            echo '<script type="text/javascript">

                    var result = confirm("Bạn có chắc chắn muốn xoá không?");
                    if (result) {
                        //ok
                        window.location.href = "action/delete_roomtype.php?id=" + ' . $roomtype_id . ';
                    } else {
                        //cancel
                        alert("Hủy bỏ việc xoá?");
                        setTimeout(function() {
                            window.location.href = "chi_tiet_loai_phong.php?id=" + ' . $roomtype_id . ';
                        }, 0);
                    }

            </script>';
        }else{
            echo '<script type="text/javascript">
                    window.onload = function () { 
                    
                    alert("Xoá loại phòng không thành công, tồn tại phòng thuộc loại phòng này!");
                    setTimeout(function() {
                        window.location.href = "chi_tiet_loai_phong.php?id=" + ' . $roomtype_id . ';
                    }, 50); // Tải lại sau 1 giây
                }

            </script>';
        }
    }
?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" style="overflow: auto;">
            <div class="card-body">
                <div class="page-header">
                    <h3 class="page-title"> THÔNG TIN LOẠI PHÒNG : <?php echo $roomtype['room_type_name'];?></h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class=""><a href="index.php">Quay lại <i class="mdi mdi-arrow-right-bold-circle"></i></a></li>
                        </ol>
                    </nav>
                </div>
                <!-- <h4 class="card-title">QUẢN LÝ LOẠI PHÒNG</h4>
                <li class="breadcrumb-item"><a href="#">Thêm loại phòng</a></li> -->
                <div class="row">
                    <div class="col-sm-6 grid-margin stretch-card">
                        <img src="../<?php echo $roomtype['url_image'];?>" alt="" style="width: 100%; height: 400px">
                    </div>
                    <div class="col-sm-6  grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-2">
                                    <form method="POST">
                                        <h4>Chi tiết</h4>
                                        <li>
                                            <span class="legend-label text-dark">Loại phòng : <?php echo $roomtype['room_type_name'];?></span>
                                        </li>
                                        <li>
                                            <span class="legend-label text-dark">Máy lạnh : <?php if($roomtype['is_air_conditioned']) echo "Có"; else echo "Không";?></span>
                                        </li>
                                        <li>
                                            <span class="legend-label text-dark">Nấu ăn : <?php if($roomtype['is_cooked']) echo "Cho phép"; else echo "Không cho phép";?></span>
                                        </li>
                                        <li>
                                            <span class="legend-label text-dark">Số lượng tối đa : <?php echo $roomtype['max_quantity']; ?> sinh viên</span>
                                        </li>
                                        <li>
                                            <span class="legend-label text-dark" >Giá tiền : <?php echo $roomtype['price']?> đ/tháng</span>
                                        </li>
                                        <li>
                                            <span class="legend-label <?php if($roomtype['enable']) echo "text-success"; else echo "text-danger";?>"><?php if($roomtype['enable']) echo "Đang hoạt động"; else echo "Đang sửa chữa";?></span>
                                        </li>
                                        <br>
                                        <button type="button" class="btn btn-inverse-success btn-fw" id="editroom-btn-open">Chỉnh sửa</button>
                                        <button type="submit" class="btn btn-inverse-danger btn-fw" >Xoá loại phòng này</button>
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="page-header">
                                    <h3 class="page-title"> Danh sách phòng </h3> 
                                    <nav aria-label="breadcrumb">
                                        <button class="btn btn-link btn-rounded btn-fw" id="addroom-btn-open" style="font-size: 16px;"><i class="mdi mdi-plus-circle-outline" style="font-size: 16px;"></i>Thêm phòng</button>
                                    </nav>
                                </div>
                                <?php 
                                        if(!$room){ echo '<span class="text-success"></i>Hiện chưa có phòng!</span>';}
                                        else{ ?>
                                <table class="table table-hover">
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
                                    <tbody>
                                        <?php while($row = $room->fetch_assoc()){ ?>
                                        <tr>
                                            <td><?php echo $i; $i++;?></td>
                                            <td><?php echo $row['room_name'];?></td>
                                            <td><?php echo $row['current_quantity']; echo '/'; echo $roomtype['max_quantity'];?></td>
                                            <td><?php echo $row['room_gender'] == 0 ?  "Nam" : "Nữ" ; ?></td>
                                            <td><?php echo $row['enable'] == 0 ?  "Không" : "Có" ; ?></td>
                                            <td><li class="breadcrumb-item"><a href="chi_tiet_phong.php?room_id=<?php echo $row['room_id']; ?>">Chi tiết phòng</a></li></td>
                                        </tr>
                                        <?php }   } ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- modal add room on roomtype start-->
                    
                    <div class="col-lg-6 grid-margin stretch-card" id="addroom-wrapper">
                        <div class="card" id="addroom-modal-container">
                            <div class="card-body">
                                <!-- <div id="demo-wrapper">
                                    <div id="demo-modal-container"> -->
                                        <div class="addroom-modal" id="addroom-modal-demo">
                                            <div class="addroom-modal-header page-header" style="border-bottom: 2px solid #8e94a9; padding-bottom:10px">
                                                <h3 class="page-title"> Thêm phòng </h3>
                                                <button style="border:0px" id="addroom-btn-close"><i class="mdi mdi-close"></i></button>
                                            </div>
                                            <div class="addroom-modal-body card-body" style="padding: 0rem 2.5rem;">
                                                <form action="action/addroom.php?id=<?php echo $roomtype_id;?>" method="POST">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required>Tên phòng</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control chucvu" required name="roomname" placeholder="Nhập tên phòng (VD: 101-C1)">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required>Giới tính</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control"required name="gender">
                                                                <option value="" style="display: none;"></option>
                                                                <option value="1">Nữ</option>
                                                                <option value="0">Nam</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required>Tình trạng</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" required name="enable">
                                                                <option value="" style="display: none;"></option>
                                                                <option value="1">Hoạt động tốt</option>
                                                                <option value="0">Đang sửa chữa</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required >Loại phòng</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" disabled name="roomtype" value="<?php echo $roomtype['room_type_name'];?>">
                                                        </div><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-12 btn--seve">
                                                            <button type="submit" class="btn btn-outline-success btn-fw"style=" float: right;"> Tạo phòng </button>
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
                    <!-- modal add room on roomtype end-->
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
                                                <h3 class="page-title"> Chỉnh sửa thông tin loại phòng </h3>
                                                <button style="border:0px" id="editroom-btn-close"><i class="mdi mdi-close"></i></button>
                                            </div>
                                            <div class="editroom-body card-body" style="padding: 0rem 2.5rem;">
                                                <form action="action/edit_roomtype.php?id=<?php echo $roomtype_id;?>" method="POST">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" >Tên loại phòng</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" disabled name="roomtype_name" value="<?php echo $roomtype['room_type_name'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" >Máy lạnh</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control"  required name="is_air_conditioned">
                                                                <option value="<?php echo $roomtype['is_air_conditioned'];?>" style="display: none;"><?php if($roomtype['is_air_conditioned']) echo "Có"; else echo "Không";?></option>
                                                                <option value="1">Có</option>
                                                                <option value="0">Không</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" >Nấu ăn</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control"  required name="is_cooked">
                                                                <option value="<?php if($roomtype['is_cooked']) echo 1 ; else echo 0 ;?>"  style="display: none;"><?php if($roomtype['is_cooked']) echo "Cho phép"; else echo "Không cho phép";?></option>
                                                                <option value="1">Cho phép</option>
                                                                <option value="0">Không cho phép</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" >Số lượng sv tối đa</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" required name="max_quantity">
                                                                <option value="" style="display: none;"><?php echo $roomtype['max_quantity'];?></option>
                                                                <option value="4">4</option>
                                                                <option value="6">6</option>
                                                                <option value="8">8</option>    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;">Giá tiền (VNĐ)</label>
                                                        <div class="col-sm-9">
                                                            <input type="number" class="form-control"  required name="price" value="<?php echo $roomtype['price']?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label" style="color:black;">Tình trạng</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" id="exampleSelectGender" required name="enable">
                                                                <option value="<?php if($roomtype['enable']) echo 1; else echo 0;?>" style="display: none;"><?php if($roomtype['enable']) echo "Đang hoạt động"; else echo "Đang sửa chữa";?></option>
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
            </div>
            
        </div>
        
        
    </div>
    
    <script>
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

    </script>

    <!-- content-wrapper ends -->

<?php require(__DIR__.'/layouts/footer.php'); ?> 