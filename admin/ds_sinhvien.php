<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$i=1;
$sql_student = "SELECT * FROM student s
INNER JOIN contract c ON s.student_id = c.student_id
INNER JOIN room r ON c.room_id = r.room_id
INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id
INNER JOIN semester sem ON sem.semester_id = c.semester_id
WHERE c.status = true AND sem.status = true ";
$student = queryResult($conn, $sql_student);


// Lọc chuyên ngành
$sql_major = "SELECT major FROM student GROUP BY major";
$major = mysqli_query($conn, $sql_major);

if(isset($_POST['btn_Export'])){
    echo '<script>window.location.href = "action/xuat_excel/xuat_excel_ds_sinhvien.php";</script>';
}
?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-body"style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> QUẢN LÝ SINH VIÊN </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <form method="POST">
                                    <button class="btn btn-link btn-rounded btn-fw" 
                                            name="btn_Export" type="Submit" style="font-size: 16px;">
                                            In danh sách
                                    </button>    
                                </form>
                                
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <!-- Lọc danh dách sinh viên theo từng loại tiêu chí -->
                        <!-- <form action="" id="loc_dssv"> -->
                            <div class="col-sm-3">
                                <div class="filter-group">
                                    <label style="font-weight: bold">
                                        <i class="fa fa-user-friends">Khoá : </i> 
                                    </label>
                                    <select id="loc_khoa" style="width: 135px;">
                                        <option value="" style="display: none;"></option>
                                        <option value="K60">K60</option> 
                                        <option value="K61">K61</option> 
                                        <option value="K62">K62</option>
                                        <option value="K63">K63</option> 
                                        <option value="K64">K64</option> 
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="filter-group">
                                    <label style="font-weight: bold">
                                        <i class="fa fa-user-friends">Chuyên ngành : </i> 
                                    </label>
                                    <select id="loc_nganh" style="width: 135px;">
                                        <option value="" style="display: none;"></option>
                                        <?php while($row = $major->fetch_assoc()){ ?>
                                            <option value="<?php echo $row['major'];?>"><?php echo $row['major'];?></option> 
                                            <?php } ?>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="filter-group">
                                    <label style="font-weight: bold">
                                        <i class="fa fa-user-friends">Giới tính : </i> 
                                    </label>
                                    <select id="loc_gioitinh" style="width: 135px;">
                                        <option value="" style="display: none;"></option>
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                    </select>
                                    
                                </div>
                            </div>    
                        <!-- </form> -->
                        
                    </div>
                    <!-- <h4 class="card-title">QUẢN LÝ LOẠI PHÒNG</h4>
                    <li class="breadcrumb-item"><a href="#">Thêm loại phòng</a></li> -->
                    <table class="table table-hover" >
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã sinh viên</th>
                                <th>Họ và Tên</th>
                                <th>Ngày sinh</th>
                                <th>Phòng (Loại phòng)</th>
                                <th>Ngành (Lớp)</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Quê quán</th>
                                <th>Tác vụ</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody id="ds_sinhvien">
                            <?php while($row = $student->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $row['number_student'];?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo date("d-m-Y", strtotime($row['birthday'])); ?></td>
                                <td><?php echo $row['room_name']; echo '('; echo $row['room_type_name'].')';?></td>
                                <td><?php echo $row['major']; echo '('; echo $row['classroom'].')';?></td>
                                <td><?php echo $row['phone']?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['address']?></td>
                                <td><li class="breadcrumb-item"><a href="chi_tiet_phong.php?room_id=<?php echo $row['room_id'];?>">Đi đến phòng ở</a></li></td>
                                <td><li class="breadcrumb-item"><a href="">ADD to blacklist</a></li></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // sử lý tìm kiếm với ajax
        $(document).ready(function(){
            $("#timkiem").on('input', function(event){
                event.preventDefault();
                var giatri = $(this).val();
                $.ajax({
                    url: "ajax/search_student.php",
                    type: "GET",
                    data: { giatri: giatri },
                    success: function(data){
                        $("#ds_sinhvien").html(data);
                        $("#loc_khoa, #loc_nganh, #loc_gioitinh").val("");
                    }
                });
                return false;
            });
        });

        //AJAX XỬ LÍ LỌC SV THEO TIÊU CHÍ
        $(document).ready(function(){
            $("#loc_khoa").on('input', function(event){
                event.preventDefault();
                var giatri = $(this).val();
                var loc_nganh = $("#loc_nganh").val();
                var loc_gioitinh = $("#loc_gioitinh").val();
                $.ajax({
                    url: "ajax/loc_khoa.php",
                    type: "GET",
                    data: { giatri: giatri ,loc_nganh:loc_nganh, loc_gioitinh: loc_gioitinh},// 
                    success: function(data){
                        $("#ds_sinhvien").html(data);
                        $("#timkiem").val("");
                    }
                });
                return false;
            });
        });
        $(document).ready(function(){
            $("#loc_nganh").on('input', function(event){
                event.preventDefault();
                var giatri = $(this).val();
                var loc_khoa = $("#loc_khoa").val();
                var loc_gioitinh = $("#loc_gioitinh").val();
                $.ajax({
                    url: "ajax/loc_nganh.php",
                    type: "GET",
                    data: { giatri: giatri ,loc_khoa:loc_khoa, loc_gioitinh: loc_gioitinh},
                    success: function(data){
                        $("#ds_sinhvien").html(data);
                        $("#timkiem").val("");
                    }
                });
                return false;
            });
        });
        $(document).ready(function(){
            $("#loc_gioitinh").on('input', function(event){
                event.preventDefault();
                var giatri = $(this).val();
                var loc_khoa = $("#loc_khoa").val();
                var loc_nganh = $("#loc_nganh").val();
                $.ajax({
                    url: "ajax/loc_gioitinh.php",
                    type: "GET",
                    data: { giatri: giatri ,loc_khoa:loc_khoa, loc_nganh: loc_nganh},
                    success: function(data){
                        $("#ds_sinhvien").html(data);
                        $("#timkiem").val("");
                    }
                });
                return false;
            });
        });
    </script>

<?php require(__DIR__.'/layouts/footer.php'); ?> 