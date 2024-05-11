<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$i=1;
$sql_student = "SELECT * FROM student s
                INNER JOIN contract c ON s.student_id = c.student_id
                INNER JOIN room r ON c.room_id = r.room_id
                INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id
                INNER JOIN semester sem ON sem.semester_id = c.semester_id
                WHERE c.status = 2 AND sem.status = true ";
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
                        <h3 class="page-title"> DANH SÁCH SV ĐĂNG KÝ PHÒNG </h3>
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
                                <td><?php echo $row['birthday'];?></td>
                                <td><?php echo $row['room_name']; echo '('; echo $row['room_type_name'].')';?></td>
                                <td><?php echo $row['major']; echo '('; echo $row['classroom'].')';?></td>
                                <td><?php echo $row['phone']?></td>
                                <td><?php echo $row['email'];?></td>
                                <td><?php echo $row['address']?></td>
                                <td><div class="dropdown">
                                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownMenuOutlineButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Tác vụ </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton5">
                                            <a class="dropdown-item" href="action/dang_ky/xac_nhan.php?contract_id=<?php echo $row['contract_id']?>">Xác nhận đơn ĐK</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="action/dang_ky/huy_don_dk.php?contract_id=<?php echo $row['contract_id']?>">Đơn không hợp lệ</a>
                                        </div>
                                    </div>
                                </td>
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