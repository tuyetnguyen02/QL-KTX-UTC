<?php
    // session_start();
    // if(!isset($_SESSION['loginadmin'])){
    //     echo "<script>window.location.href = 'dang-nhap.php';</script>";
    // }
    // require('../database/connect.php');	
    // require('../database/query.php');
?>

<?php require(__DIR__.'/layouts/header.php'); ?> 

<?php
     $i = 1;
    // $sql_loaiphong = "SELECT * FROM room_type ";
	// $loaiphong = queryResult($conn,$sql_loaiphong);
// $i = ($i-1)*$_GET['trang'] + 1;
$start = 0;
$limit = 5;

$sql_soluongloaiphong = "SELECT * FROM room_type";
$tongloaiphong = queryResult($conn,$sql_soluongloaiphong)->num_rows;
$sotrang = ceil($tongloaiphong / $limit);

if(isset($_GET['trang'])){
	if($_GET['trang'] <= 0){
		$_GET['trang'] = 1;
	}
    
	$start = ($_GET['trang'] - 1) * $limit; 
	$sql_loaiphong = "SELECT * FROM room_type LIMIT ".$start.",".$limit;
	$loaiphong = queryResult($conn,$sql_loaiphong);
}else{
	$sql_loaiphong = "SELECT * FROM room_type LIMIT ".$start.",".$limit;
	$loaiphong = queryResult($conn,$sql_loaiphong);
}


?>

 <div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-body" style="overflow: auto;"> <!-- overflow: auto; tạo thanh quận ngang - setcss cho thẻ div chứa table -->
                    <div class="page-header">
                        <h3 class="page-title"> QUẢN LÝ LOẠI PHÒNG </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li><nav aria-label="breadcrumb">
                                        <button class="btn btn-link btn-rounded btn-fw" id="addroom-btn-open" style="font-size: 16px;"><i class="mdi mdi-plus-circle-outline" style="font-size: 16px;"></i>Thêm loại phòng</button>
                                    </nav></li>
                            </ol>
                        </nav>
                    </div>
                    <!-- <h4 class="card-title">QUẢN LÝ LOẠI PHÒNG</h4>
                    <li class="breadcrumb-item"><a href="#">Thêm loại phòng</a></li> -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Loại phòng</th>
                                <th>Máy lạnh</th>
                                <th>Nấu ăn</th>
                                <th>Số lượng SV</th>
                                <th>Giá phòng</th>
                                <th>Hình ảnh</th>
                                <th>Hoạt động</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody id="ds_loaiphong">
                            <?php while($row = $loaiphong->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $row['room_type_name'];?></td>
                                <td><?php if(!$row['is_air_conditioned']) echo "Có"; else echo "Không";?></td>
                                <td><?php if(!$row['is_cooked']) echo "Cho phép"; else echo "Không cho phép";?></td>
                                <td><?php echo $row['max_quantity']; ?></td>
                                <td><?php echo $row['price']?> đ/tháng</td>
                                <td class="img_admin"><img src="../<?php echo $row['url_image'];?>" alt="product" /></td>
                                <td style="color : <?php if($row['enable']) echo "green"; else echo "red";?>"><?php if($row['enable']) echo "Hoạt động tốt"; else echo "Đang sửa chữa";?></span></td>
                                <td><li class="breadcrumb-item"><a href="chi_tiet_loai_phong.php?id=<?php echo $row['room_type_id']; ?>">Chi tiết</a></li></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Loại phòng</th>
                                <th>Máy lạnh</th>
                                <th>Nấu ăn</th>
                                <th>Số lượng SV</th>
                                <th>Giá phòng</th>
                                <th>Hình ảnh</th>
                                <th>Hoạt động</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                    </table>
                    <!-- phân trang cho table -->
                    <nav aria-label="Page navigation example">
                        <br>
                        <br>
                        <ul class="pagination" style="justify-content: center;">
                            <?php if(isset($_GET['trang'])){ ?>
                                <li class="page-item"><a class="page-link" href="./index.php?trang=<?php echo $_GET['trang'] - 1; ?>">Trước</a></li>
                            <?php }else{ ?>
                                <li class="page-item"><a class="page-link" href="#">Trước</a></li>
                            <?php } ?>
                            <?php for($i = 1; $i <= $sotrang; $i++){ ?>
                                <?php if($i == 1){ ?>
                                    <li class="page-item"><a class="page-link" href="./index.php"><?php echo $i; ?></a></li>
                                <?php }else{ ?>
                                    <li class="page-item"><a class="page-link" href="./index.php?trang=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php } ?>
                            <?php } ?>
                            <?php if(isset($_GET['trang']) && $sotrang >= 2 && $sotrang != $_GET['trang']){ ?>
                                <li class="page-item"><a class="page-link" href="./index.php?trang=<?php echo $_GET['trang'] + 1; ?>">Sau</a></li>
                            <?php }else{ ?>
                                <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                    
                </div>
            </div>
            <div class="row">
                    <!-- modal add roomtype on roomtype start-->
                    
                    <div class="col-lg-6 grid-margin stretch-card" id="addroom-wrapper">
                        <div class="card" id="addroom-modal-container">
                            <div class="card-body">
                                <!-- <div id="demo-wrapper">
                                    <div id="demo-modal-container"> -->
                                        <div class="addroom-modal addroomtype-nodal" id="addroom-modal-demo">
                                            <div class="addroom-modal-header page-header" style="border-bottom: 2px solid #8e94a9; padding-bottom:10px">
                                                <h3 class="page-title"> Thêm loại phòng </h3>
                                                <button style="border:0px" id="addroom-btn-close"><i class="mdi mdi-close"></i></button>
                                            </div>
                                            <div class="addroom-modal-body card-body" style="padding: 0rem 2.5rem;">
                                                <form action="action/loai_phong/add_roomtype.php" method="POST" enctype="multipart/form-data"><!--Thêm enctype="multipart/form-data" vào thẻ form để cho phép tải lên tệp tin. -->
                                                    <div class="row">
                                                        <div class="form-group col-sm-6 row">
                                                            <div class="form-group row col-sm-12 ">
                                                                <label class="col-sm-3 col-form-label" style="color:black;" required>Tên loại phòng</label>
                                                                <div class="col-sm-9">
                                                                    <input type="text" class="form-control" placeholder="Tên loại phòng" required name="room_type_name">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-sm-12">
                                                                <label class="col-sm-3 col-form-label" style="color:black;" required>Số lượng sinh viên tối đa</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control" required name="max_quantity">
                                                                        <!-- <option value=""></option> -->
                                                                        <option value="4">4</option>
                                                                        <option value="6">6</option>
                                                                        <option value="8">8</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-sm-12">
                                                                <label class="col-sm-3 col-form-label" style="color:black;" required>Giá tiền phòng</label>
                                                                <div class="col-sm-9">
                                                                    <input type="number" class="form-control" placeholder="Giá tiền" required name="price">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-sm-12">
                                                                <label class="col-sm-3 col-form-label" style="color:black;" required >Hình ảnh</label>
                                                                <div class="col-sm-9">
                                                                    <!-- <input type="file" class="file-upload-default" > -->
                                                                    <div class="input-group col-xs-12">
                                                                        <!-- <input type="text" class="form-control file-upload-info" disabled placeholder="Tải ảnh lên" required name="url_image">
                                                                        <span class="input-group-append">
                                                                            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                                        </span> -->
                                                                        <input type="file" class="form-control form-control-line" required name="url_image">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 form-group row">
                                                            <div class="form-group row col-sm-12">
                                                                <label style="color:black;" class="col-sm-3 col-form-label">Nấu ăn</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control" id="exampleSelectGender" required name="is_cooked">
                                                                        <!-- <option value=""></option> -->
                                                                        <option value="1">Được phép</option>
                                                                        <option value="0">Không được phép</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-sm-12">
                                                                <label style="color:black;" class="col-sm-3 col-form-label">Trang bị điều hoà</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control" id="exampleSelectGender" required name="is_air_conditioned">
                                                                        <!-- <option value=""></option> -->
                                                                        <option value="1">Có trang bị</option>
                                                                        <option value="0">Không trạng bị</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row col-sm-12">
                                                                <label style="color:black;" class="col-sm-3 col-form-label">Trạng thái phòng</label>
                                                                <div class="col-sm-9">
                                                                    <select class="form-control" id="exampleSelectGender" required name="enable">
                                                                        <!-- <option value=""></option> -->
                                                                        <option value="1">Hoạt động tốt</option>
                                                                        <option value="0">Đang sửa chữa</option>
                                                                    </select><br><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                                                </div>
                                                            </div>
                                                        </div>
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
        </div>

    </div>
    <!-- content-wrapper ends -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

        // sử lý tìm kiếm với ajax
        $(document).ready(function(){
            $("#timkiem").on('input', function(event){
                event.preventDefault();
                var giatri = $(this).val();
                $.ajax({
                    url: "ajax/search_roomtype.php",
                    type: "GET",
                    data: { giatri: giatri },
                    success: function(data){
                        $("#ds_loaiphong").html(data);
                    }
                });
                return false;
            });
        });
    </script>

<?php require(__DIR__.'/layouts/footer.php'); ?> 