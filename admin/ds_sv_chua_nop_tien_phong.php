<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$i=1;
$sql_student = "SELECT * FROM student s
                INNER JOIN contract c ON s.student_id = c.student_id
                INNER JOIN room r ON c.room_id = r.room_id
                INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id
                INNER JOIN semester sem ON sem.semester_id = c.semester_id
                WHERE c.status = 0 AND sem.status = true ";
$student = queryResult($conn, $sql_student);


// Lọc chuyên ngành
$sql_major = "SELECT major FROM student GROUP BY major";
$major = mysqli_query($conn, $sql_major);

?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-body"style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> DANH SÁCH SV CHƯA ĐÓNG TIỀN PHÒNG </h3>
                    </div>
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
                            </tr>
                        </thead>
                        <tbody id="ds_sinhvien">
                            <?php if(!$student){ echo '<span class="text-success"></i>Chưa có sinh viên đăng ký!</span>';}
                                else{ while($row = $student->fetch_assoc()){ ?>
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
                                <td><li class="breadcrumb-item"><a href="admin_send_email.php?student_id=<?php echo $row['student_id']; ?>&text=tien phong">Nhắc nhở</a></li></td>
                            </tr>
                            <?php }  } ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    

<?php require(__DIR__.'/layouts/footer.php'); ?> 