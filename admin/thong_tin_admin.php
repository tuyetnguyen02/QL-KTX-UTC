<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php

// $admin_id = $_SESSION["useradmin"];
// $sql_admin = "SELECT * FROM admin WHERE number_admin = '".$admin_id."'";
// $admin = queryResult($conn,$sql_admin);

$admin_id = $admin['admin_id'];
// echo $admin_id;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $chucvu = $_POST['chucvu'];
    $email = $_POST['email'];
    $dienthoai = $_POST['dienthoai'];
    $diachi = $_POST['diachi'];
    $matkhau1 = $_POST['matkhau1'];
    $matkhau2 = $_POST['matkhau2'];
    if($matkhau1 != NULL){
        if($matkhau1 == $matkhau2){
            $sql_update= "UPDATE `admin` SET `password`='".$matkhau1."', `position`='".$chucvu."', `address`='".$diachi."', `email`='".$email."', `phone`='".$dienthoai."' WHERE admin_id = ".$admin_id."";
            $capnhat = queryExecute($conn,$sql_update);
            echo '<script type="text/javascript">

                    window.onload = function () { alert("Cập nhật thành công!");}
                    //window.location.reload();
                    setTimeout(function() {
                       window.location.href = "thong_tin_admin.php";
                    }, 1000); // Tải lại sau 1 giây
                </script>';
        }
        else
            echo '<script type="text/javascript">

                    window.onload = function () { alert("Nhập sai mật khẩu"); }

                </script>';
    }else{
        $sql_update= "UPDATE `admin` SET `position`='".$chucvu."', `address`='".$diachi."', `email`='".$email."', `phone`='".$dienthoai."' WHERE admin_id = ".$admin_id."";
            $capnhat = queryExecute($conn,$sql_update);
            echo '<script type="text/javascript">

                    window.onload = function () { alert("Cập nhật thành công!");}
                    setTimeout(function() {
                        window.location.href = "thong_tin_admin.php";
                    }, 1000); // Tải lại sau 1 giây
                    //window.location.reload();
                </script>';
    }
    
}


?>
<div class="main-panel">
    <div class="content-wrapper">
    <div class="col-lg-12 grid-margin stretch-card" style="overflow: auto;">
            <div class="card-body">
                <div class="page-header">
                    <h3 class="page-title"> THÔNG TIN NHÂN VIÊN </h3>
                </div>
                <div class="row">
                    <div class="col-sm-4 grid-margin stretch-card">
                        <img src="<?php echo $admin['image'];?>" alt="" style="width: 100%; height: 550px">
                    </div>
                    <div class="col-md-8 grid-margin stretch-card">
                        <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Chi tiết</h4>
                            <form class="forms-sample" method="POST">
                                <div class="form-group row">
                                    <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Mã nhân viên</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="exampleInputUsername2" disabled value="<?php echo $admin['number_admin']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Họ và tên</label>
                                    <div class="col-sm-9">
                                    <input type="email" class="form-control" id="exampleInputEmail2" disabled value="<?php echo $admin['admin_name']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Ngày sinh</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" disabled value="<?php echo date("d-m-Y", strtotime($admin['birthday'])); ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Giới tính</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" disabled value="<?php if($admin['gender'] == 1) echo "Nữ";
                                                                                                                        else echo "Nam"; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Chức vụ</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" <?php if($admin['position'] != "Trưởng ban") echo "disabled";?> required name="chucvu" value="<?php echo $admin['position']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="email" value="<?php echo $admin['email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Số điện thoại</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="dienthoai" value="<?php echo $admin['phone']; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputMobile" class="col-sm-3 col-form-label">Địa chỉ</label>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control"  required name="diachi" value="<?php echo $admin['address']; ?>">
                                    <!-- <label style="" >*Nhập đủ xã/phường, huyện/quận, tỉnh/thành phố!</label> -->
                                    </div>
                                </div>
                                <h4 class="card-title">Thay đổi mật khẩu</h4>
                                <div class="form-group row">
                                    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Mật khẩu hiện tại</label>
                                    <div class="input-group col-sm-9" >
                                        <input type="password" class="form-control file-upload-info" id="ShowPassword" disabled value="<?php echo $admin['password']; ?>">
                                        <span class="input-group-append">
                                            <button type="button" style="height: 46.0px; border: 1px solid rgba(151, 151, 151, 0.3);" onclick="show_password()"><i id="icon-eye" class="mdi mdi-eye" ></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Nhập mật khẩu mới</label>
                                    <div class="col-sm-9">
                                    <input type="password" class="form-control" id="exampleInputConfirmPassword2"  name="matkhau1" placeholder="Nhập mật khẩu mới">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Nhập lại mật khẩu mới</label>
                                    <div class="col-sm-9">
                                    <input type="password" class="form-control" id="exampleInputConfirmPassword2"  name="matkhau2" placeholder="Nhập lại">
                                    </div>
                                </div>
                                <div class="form-group row">
                                <label  class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Cập nhật thông tin</button>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
                
            <!-- </div> -->
            
        </div>

    </div>
    <script>
        
        const class_eye = document.getElementById('icon-eye');
        const show = document.getElementById('ShowPassword');
        function show_password(){
            if (show.type === "password") {
                class_eye.classList.remove('mdi-eye');
                class_eye.classList.add('mdi-eye-off');
                show.type = "text";
            } else {
                class_eye.classList.remove('mdi-eye-off');
                class_eye.classList.add('mdi-eye');
                show.type = "password";
            }
        }
    </script>
<?php require(__DIR__.'/layouts/footer.php'); ?> 