<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$start = 0;
$limit = 10;
$sql_soluongfeedback = "SELECT * FROM feedback";
$tongfeedback = queryResult($conn,$sql_soluongfeedback)->num_rows;
$sotrang = ceil($tongfeedback / $limit);

$sql_semester = "SELECT * FROM semester WHERE status = true";
$semester = mysqli_query($conn, $sql_semester)->fetch_assoc();
//$currentDate = new DateTime(); // lấy thời gian tại thời điểm hiện tại
$start_date = (new DateTime($semester['start_date']))->format('Y-m-d');

// $sql_feedback = "SELECT * FROM feedback f 
//     INNER JOIN material m ON f.material_id = m.material_id 
//     INNER JOIN room r ON f.room_id = r.room_id
//     INNER JOIN student s ON s.student_id = f.student_id
//     LEFT JOIN admin a ON a.admin_id = f.admin_id
//     WHERE send_date >= '".$start_date."' 
//     ORDER BY send_date DESC ";
// $feedback = mysqli_query($conn, $sql_feedback);

if(isset($_GET['trang'])){
	if($_GET['trang'] <= 0){
		$_GET['trang'] = 1;
	}

	$start = ($_GET['trang'] - 1) * $limit; 
	// $sql_loaiphong = "SELECT * FROM room_type LIMIT ".$start.",".$limit;

    $sql_feedback = "SELECT * FROM feedback f 
    INNER JOIN material m ON f.material_id = m.material_id 
    INNER JOIN room r ON f.room_id = r.room_id
    INNER JOIN student s ON s.student_id = f.student_id
    LEFT JOIN admin a ON a.admin_id = f.admin_id
    WHERE send_date >= '".$start_date."' 
    ORDER BY send_date DESC LIMIT ".$start.",".$limit;
    
	$feedback = queryResult($conn,$sql_feedback);
}else{
	$sql_feedback = "SELECT * FROM feedback f 
    INNER JOIN material m ON f.material_id = m.material_id 
    INNER JOIN room r ON f.room_id = r.room_id
    INNER JOIN student s ON s.student_id = f.student_id
    LEFT JOIN admin a ON a.admin_id = f.admin_id
    WHERE send_date >= '".$start_date."' 
    ORDER BY send_date DESC LIMIT ".$start.",".$limit;
    
	$feedback = queryResult($conn,$sql_feedback);
}

?>
<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-body"style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> Thông báo sửa chữa từ sinh viên </h3>
                        <!-- <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Thêm học kỳ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Basic tables</li>
                            </ol>
                        </nav> -->
                    </div>
                    <!-- <h4 class="card-title">QUẢN LÝ LOẠI PHÒNG</h4>
                    <li class="breadcrumb-item"><a href="#">Thêm loại phòng</a></li> -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Phòng</th>
                                <th>Nội dung</th>
                                <th>Ngày gửi</th>
                                <th>Sinh viên gửi</th>
                                <th>Nhân viên phản hồi</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i=1;
                            if(isset($feedback)){
                                while($row = $feedback->fetch_assoc()){?>
                                    <tr>
                                        <td><?php echo $i; $i++;?></td>
                                        <td><?php echo $row['room_name'];?></td>
                                        <td><?php echo $row['material_name'];?></td>
                                        <td><?php echo $row['send_date'];?></td>
                                        <td><?php echo $row['name'];?></td>
                                        <td><?php echo $row['admin_name']; ?></td>
                                        <?php if($row['status']){?>
                                            <td class="text-success">Đã phản hồi</td><?php }else{?>
                                            <td class="text-danger">Chờ xác nhận</td><?php } ?>
                                        <td><?php if(!$row['status']){?>
                                            <button type="button" class="btn btn-link btn-fw" onclick="Phan_hoi('<?php echo $row['feedback_id'];?>')">Phản hồi SV</button>
                                            <?php } ?></td>
                                    </tr>
                                <?php } } ?>
                        </tbody>
                    </table>  
                    <nav aria-label="Page navigation example">
                        <br>
                        <br>
                        <ul class="pagination" style="justify-content: center;">
                            <?php if(isset($_GET['trang'])){ ?>
                                <li class="page-item"><a class="page-link" href="./sua_chua_vat_chat.php?trang=<?php echo $_GET['trang'] - 1; ?>">Trước</a></li>
                            <?php }else{ ?>
                                <li class="page-item"><a class="page-link" href="#">Trước</a></li>
                            <?php } ?>
                            <?php for($i = 1; $i <= $sotrang; $i++){ ?>
                                <?php if($i == 1){ ?>
                                    <li class="page-item" <?php //if($_GET['trang'] == $sotrang){echo 'style="font-weight: bold";';} ?>><a class="page-link" href="./sua_chua_vat_chat.php"><?php echo $i; ?></a></li>
                                <?php }else{ ?>
                                    <li class="page-item" <?php //if($_GET['trang'] == $sotrang){echo 'style="font-weight: bold";';} ?>><a class="page-link" href="./sua_chua_vat_chat.php?trang=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php } ?>
                            <?php } ?>
                            <?php if(isset($_GET['trang']) && $sotrang >= 2 && $sotrang != $_GET['trang']){ ?>
                                <li class="page-item"><a class="page-link" href="./sua_chua_vat_chat.php?trang=<?php echo $_GET['trang'] + 1; ?>">Sau</a></li>
                            <?php }else{ ?>
                                <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                            <?php } ?>
                        </ul>
                    </nav>  
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
                                            <h3 class="page-title"> Phản hồi hẹn ngày sửa chữa tới sinh viên </h3>
                                            <button style="border:0px" id="addroom-btn-close"><i class="mdi mdi-close"></i></button>
                                        </div>
                                        <div class="addroom-modal-body card-body" style="padding: 0rem 2.5rem;">
                                            <form action="" method="POST">
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label" style="color:black;" required>Chọn ngày</label>
                                                    <div class="col-sm-9">
                                                        <input type="date" class="form-control" required id="send_date">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12 btn--seve">
                                                        <button type="button" onclick="Update()" class="btn btn-outline-success btn-fw" style=" float: right;"> Gửi đi </button>
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
    <script>
        // const open = document.getElementById('addroom-btn-open');
        // // console.log(show);
         const close = document.getElementById('addroom-btn-close');
        const modal_container = document.getElementById('addroom-modal-container');
        var id;
        function Phan_hoi(feedback_id) {
            modal_container.classList.add('show');
            id = feedback_id;
        }
        function Update(){ // có thể lấy ngày để đi đến trang update
            var sendDate = document.getElementById("send_date").value;
            if(sendDate === ''){
                //modal_container.classList.remove('show');
                alert("Bạn cần chọn ngày hẹn với sinh viên!");
            }else{
                window.location.href = "action/update_suachua.php?feedback_id=" + id + "&send_date=" + sendDate;
            }
            //alert("Gửi thông báo thành công! " + sendDate);
            
        }
        close.addEventListener('click', ()=>{
            modal_container.classList.remove('show');
        });
    </script>
<?php require(__DIR__.'/layouts/footer.php'); ?> 