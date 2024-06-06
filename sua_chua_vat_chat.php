<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$number_student = $_SESSION['user']; // lấy id của student
//echo $number_student;
$sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
$sv = mysqli_query($conn, $sql_sv)->fetch_assoc();
$student_id = $sv['student_id'];

$sql_semester = "SELECT * FROM semester WHERE status = true";
$semester = mysqli_query($conn, $sql_semester)->fetch_assoc();

//$currentDate = new DateTime(); // lấy thời gian tại thời điểm hiện tại
$start_date = new DateTime($semester['start_date']);
$start_date->format('d-m-Y'); // đặt lại định dạng (Y-m-d) -> (d-m-Y)
$end_date = new DateTime($semester['end_date']);
$registration_startdate = new DateTime($semester['registration_startdate']);
$registration_enddate = new DateTime($semester['registration_enddate']);

$currentDate = $start_date->format('Y-m-d');
$new_time = (new DateTime())->format('Y-m-d');

/// hiển thị danh sách feedback
$sql_student = "SELECT * FROM student s
            INNER JOIN contract c ON s.student_id = c.student_id
            INNER JOIN room r ON c.room_id = r.room_id
            INNER JOIN semester sem ON sem.semester_id = c.semester_id
            WHERE s.student_id = '".$student_id."' AND c.status = true AND sem.status = true";
$result = mysqli_query($conn, $sql_student)->fetch_assoc();

if ($result != NULL) {
    $room_id = $result['room_id'];
    $sql_feedback = "SELECT * FROM feedback f INNER JOIN material m ON f.material_id = m.material_id 
                    INNER JOIN room r ON f.room_id = r.room_id
                    INNER JOIN student s ON s.student_id = f.student_id
                    WHERE send_date >= '".$currentDate."' AND r.room_id = '".$room_id."'";
    $feedback = mysqli_query($conn, $sql_feedback);
}

//echo $room_id;
//$room_id = $student['room_id'];

// hiển thị list thiết bị hư hỏng trng phòng
$sql_material = "SELECT * FROM material";
$material = mysqli_query($conn, $sql_material);

$new_time = (new DateTime())->format('Y-m-d');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if ($result != NULL){
        $material_id = $_POST['material'];
        
        $sql_insert = "INSERT INTO `feedback`(`student_id`,`material_id`,`room_id`,`send_date`,`status`)
                VALUES ('".$student_id."','".$material_id."','".$room_id."','".$new_time."', 0 )";
        $booking = mysqli_query($conn, $sql_insert);
        if(isset($booking)){
            echo '<script type="text/javascript">

                window.onload = function () { alert("Gửi thông báo đến ban quản lý thành công!");}
                setTimeout(function() {
                    window.location.href = "sua_chua_vat_chat.php";
                }, 1000); // Tải lại sau 1 giây
            </script>';
        }
    }else{
        echo '<script type="text/javascript">

                window.onload = function () { alert("Bạn cần đăng ký thành công ở KTX trước"); window.location.href = "thong_tin_ca_nhan.php";}
                
            </script>';
    }
     
}
?>

<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Sửa chữa thiết bị</li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="inner-page-sec-padding-bottom">
    <div class="container">
        <div class="shop-toolbar mb--30">
            <form method="POST">
              <div class="row">
                    <div class="col-sm-1"><span style="font-weight: bold">Học kỳ:</span> <br><br></div>
                    <div class="col-sm-4">
                      <span style="font-weight: bold"><?php echo $semester['semester'] . " " . $semester['school_year']?></span>
                    </div>
                    <div class="col-sm-2"><br><br></div>
                    <div class="col-sm-2"><span style="font-weight: bold">Thời gian sử dụng :</span> <br><br></div>
                    <div class="col-sm-3">
                      <span style="font-weight: bold"><?php echo $start_date->format('d-m-Y') . " đến " . $end_date->format('d-m-Y') ;?></span>
                    </div>
              </div>
            </form>
            
        </div>

        <div class="mb--30">
            <div class="row" style="display: flex; justify-content: space-between;">
                <div class="col-lg-4 service ">
                    <div class="card_item_roomtype text-black text-center">
                        
                        <form method="POST">
                            <br><br>
                            <div><span style="font-weight: bold">Tình trạng cần sửa chữa :</span> <br><br></div>
                            <!-- <label>Tình trạng cần sửa chữa </label> -->
                            <div class="col-sm-12">
                                <select class="form-control" required name="material">
                                    <option value="" style="display: none;"></option>
                                    <?php while($row = $material->fetch_assoc()){?>
                                    <option value="<?php echo $row['material_id']?>"><?php echo $row['material_name']?></option>
                                    <?php }?>
                                    
                                    <!-- <option value="0">Đang sửa chữa</option> -->
                                </select>
                            </div>
                            <button class="btn-dang-ki" type="submit">
                                Gửi đi
                            </button>
                        </form>
                        
                        

                    </div>
                </div>

                <div class="col-lg-8 col-12 service ">
                    <div class="card_item_roomtype text-black text-center">
                        <form >
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Nội dung</th>
                                        <th>Ngày gửi</th>
                                        <th>Sinh viên gửi</th>
                                        <th>Trạng thái</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i=1;
                                    if(isset($feedback)){
                                    while($row = $feedback->fetch_assoc()){ ?>
                                        <tr>    
                                            <td><?php echo $i; $i++;?></td>
                                            <td><?php echo $row['material_name'];?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row['send_date'])); ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <?php if($row['status']){?>
                                                <td class="text-success">Đã các nhận</td><?php }else{?>
                                                <td class="text-warning">Chờ xác nhận</td>
                                            <?php }?>
                                            <td></td>
                                        </tr>
                                        <?php }   } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require(__DIR__.'/layouts/footer.php'); ?>