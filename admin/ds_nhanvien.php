<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$i=1;
$sql_admin = "SELECT * FROM admin WHERE status = true";
$admin = queryResult($conn, $sql_admin);

$admin_id = $_SESSION["useradmin"];
$sql_admin_login = "SELECT * FROM admin WHERE number_admin = '".$admin_id."'";
$admin_login = mysqli_query($conn, $sql_admin_login)->fetch_assoc();


?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-body"style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> DANH SÁCH NHÂN VIÊN - BAN QUẢN LÝ KTX </h3>
                        <?php if($admin_login['position'] == "Trưởng ban") echo '
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li><nav aria-label="breadcrumb">
                                            <button class="btn btn-link btn-rounded btn-fw" id="addroom-btn-open" style="font-size: 16px;"><i class="mdi mdi-plus-circle-outline" style="font-size: 16px;"></i>Thêm nhân viên mới</button>
                                        </nav></li>
                                </ol>
                            </nav>
                        ';?>
                        
                    </div>
                    
                    <!-- <h4 class="card-title">QUẢN LÝ LOẠI PHÒNG</h4>
                    <li class="breadcrumb-item"><a href="#">Thêm loại phòng</a></li> -->
                    <table class="table table-hover" >
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã nhân viên</th>
                                <th>Họ và Tên</th>
                                <th>Ngày sinh</th>
                                <th>Giới tính</th>
                                <th>Chức vụ</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <?php if($admin_login['position'] == "Trưởng ban") echo '
                                <th>Tác vụ</th>
                                ';?>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $admin->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $row['number_admin'];?></td>
                                <td><?php echo $row['admin_name'];?></td>
                                <td><?php echo date("d-m-Y", strtotime($row['birthday'])); ?></td>
                                <td><?php echo $row['gender'] == "0" ? "Nam" : "Nữ"; ?></td>
                                <td><?php echo $row['position'];?></td>
                                <td><?php echo $row['phone']?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['address']?></td>
                                <?php if($admin_login['position'] == "Trưởng ban") echo '
                                <td><li class="breadcrumb-item"><a href="action/nhan_vien/dung_hd.php?admin_id='.$row['admin_id'].'"><i class="mdi mdi-close" style="font-size: 18px;"></i>Dừng hoạt động</a></li></td>
                                ';?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>    
                </div>
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
                                        <h3 class="page-title"> Thêm nhân viên mới </h3>
                                        <button style="border:0px" id="addroom-btn-close"><i class="mdi mdi-close"></i></button>
                                    </div>
                                    <div class="addroom-modal-body card-body" style="padding: 0rem 2.5rem;">
                                        <form action="action/nhan_vien/them_nv.php" method="POST" enctype="multipart/form-data"><!--Thêm enctype="multipart/form-data" vào thẻ form để cho phép tải lên tệp tin. -->
                                            <div class="row">
                                                <div class="form-group col-sm-6 row">
                                                    <div class="form-group row col-sm-12 ">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required>Mã nhân viên</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" placeholder="NV000000" required name="number_admin">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-sm-12">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required>Họ và tên</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" placeholder="Nguyễn Văn A" required name="admin_name">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-sm-12">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required>Chức vụ</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" required name="position">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-sm-12">
                                                        <label class="col-sm-3 col-form-label" style="color:black;" required >Ảnh thẻ</label>
                                                        <div class="col-sm-9">
                                                            <!-- <input type="file" class="file-upload-default" > -->
                                                            <div class="input-group col-xs-12">
                                                                <!-- <input type="text" class="form-control file-upload-info" disabled placeholder="Tải ảnh lên" required name="url_image">
                                                                <span class="input-group-append">
                                                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                                                </span> -->
                                                                <input type="file" class="form-control form-control-line" required name="image">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 form-group row">
                                                    <div class="form-group row col-sm-12">
                                                        <label style="color:black;" class="col-sm-3 col-form-label">Giới tính</label>
                                                        <div class="col-sm-9">
                                                            <select class="form-control" required name="gender">
                                                                <option value="" style="display: none;"></option>
                                                                <option value="1">Nữ</option>
                                                                <option value="0">Nam</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-sm-12">
                                                        <label style="color:black;" class="col-sm-3 col-form-label">Ngày sinh</label>
                                                        <div class="col-sm-9">
                                                            <input type="date" class="form-control" required name="birthday">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-sm-12">
                                                        <label style="color:black;" class="col-sm-3 col-form-label">Số điện thoại</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" required name="phone">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-sm-12">
                                                        <label style="color:black;" class="col-sm-3 col-form-label">Email</label>
                                                        <div class="col-sm-9">
                                                            <input type="email" class="form-control" required name="email">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-sm-12">
                                                        <label style="color:black;" class="col-sm-3 col-form-label">Địa chỉ</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" required name="address">
                                                        </div><br><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <div class="col-12 btn--seve">
                                                    <button type="submit" class="btn btn-outline-success btn-fw"style=" float: right;"> Tạo tài khoản </button>
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