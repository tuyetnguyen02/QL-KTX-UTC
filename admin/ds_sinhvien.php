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

?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-body"style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> QUẢN LÝ SINH VIÊN </h3>
                        <!-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Thêm học kỳ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Basic tables</li>
                            </ol>
                        </nav> -->
                    </div>
                    <!-- <h4 class="card-title">QUẢN LÝ LOẠI PHÒNG</h4>
                    <li class="breadcrumb-item"><a href="#">Thêm loại phòng</a></li> -->
                    <table class="table table-hover" id="ds_sinhvien">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã sinh viên</th>
                                <th>Họ và Tên</th>
                                <th>Ngày sinh</th>
                                <th>Phòng (Loại phòng)</th>
                                <th>Lớp (Ngành)</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Quê quán</th>
                                <th>Tác vụ</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $student->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $row['number_student'];?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php echo $row['birthday'];?></td>
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
                    }
                });
                return false;
            });
        });
    </script>

<?php require(__DIR__.'/layouts/footer.php'); ?> 