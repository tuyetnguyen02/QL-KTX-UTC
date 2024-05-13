<?php require(__DIR__.'/layouts/header.php'); ?> 

<?php
    $i = 1;
    $sql_loaiphong = "SELECT * FROM room_type ";
	$loaiphong = queryResult($conn,$sql_loaiphong);

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

    //$roomtype = "";
    
?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card" style="overflow: auto;">
            <!-- <div class="card"> -->
                <div class="card-body" id="ds_phong">
                    <div class="page-header">
                        <h3 class="page-title"> DANH SÁCH TOÀN BỘ PHÒNG </h3>
                    </div>
                    <?php while($row = $loaiphong->fetch_assoc()){ ?>
                    <div class="row">
                    <!-- modal list room in roomtype start-->
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Loại phòng : <?php echo $row['room_type_name'];?></h4>
                                    <table class="table table-bordered">
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
                                            <?php //$roomtype = $row['room_type_id']; 
                                                $sql_room = "SELECT * FROM room WHERE room_type_id = '".$row['room_type_id']."'"; 
                                                $room = queryResult($conn, $sql_room);
                                                if($room){
                                                while($row_room = $room->fetch_assoc()){ ?>
                                            <tr>
                                                <td><?php echo $i; $i++;?></td>
                                                <td><?php echo $row_room['room_name'];?></td>

                                                <td><?php // update current_quantity
                                                $sql_soluong = "SELECT COUNT(*) AS contract_count FROM contract c
                                                INNER JOIN semester sem ON sem.semester_id = c.semester_id
                                                WHERE room_id = '".$row_room['room_id']."' AND sem.status = true";
                                                $soluong = mysqli_query($conn, $sql_soluong)->fetch_assoc();
                                                //echo $soluong['contract_count'];
            
                                                $sql_update = "UPDATE `room` SET `current_quantity` = '".$soluong['contract_count']."' WHERE `room_id` = '".$row_room['room_id']."'";
                                                queryExecute($conn, $sql_update);
                                                
                                                echo $row_room['current_quantity']; echo '/'; echo $row['max_quantity'];?></td>

                                                <td><?php echo $row_room['room_gender'] == 0 ?  "Nam" : "Nữ" ; ?></td>
                                                <td><span class="legend-label <?php if($row_room['enable']) echo "text-success"; else echo "text-danger";?>"><?php if($row_room['enable']) echo "Đang hoạt động"; else echo "Đang sửa chữa";?></span></td>
                                                <td><li class="breadcrumb-item"><a href="chi_tiet_phong.php?room_id=<?php echo $row_room['room_id']; ?>">Chi tiết phòng</a></li></td>
                                            </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <!-- modal list room in roomtype end-->
                    </div>
                    <?php } ?>
                    <nav aria-label="Page navigation example">
                        <br>
                        <br>
                        <ul class="pagination" style="justify-content: center;">
                            <?php if(isset($_GET['trang'])){ ?>
                                <li class="page-item"><a class="page-link" href="./danh_sach_phong.php?trang=<?php echo $_GET['trang'] - 1; ?>">Trước</a></li>
                            <?php }else{ ?>
                                <li class="page-item"><a class="page-link" href="#">Trước</a></li>
                            <?php } ?>
                            <?php for($i = 1; $i <= $sotrang; $i++){ ?>
                                <?php if($i == 1){ ?>
                                    <li class="page-item" <?php //if($_GET['trang'] == $sotrang){echo 'style="font-weight: bold";';} ?>><a class="page-link" href="./danh_sach_phong.php"><?php echo $i; ?></a></li>
                                <?php }else{ ?>
                                    <li class="page-item" <?php //if($_GET['trang'] == $sotrang){echo 'style="font-weight: bold";';} ?>><a class="page-link" href="./danh_sach_phong.php?trang=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php } ?>
                            <?php } ?>
                            <?php if(isset($_GET['trang']) && $sotrang >= 2 && $sotrang != $_GET['trang']){ ?>
                                <li class="page-item"><a class="page-link" href="./danh_sach_phong.php?trang=<?php echo $_GET['trang'] + 1; ?>">Sau</a></li>
                            <?php }else{ ?>
                                <li class="page-item"><a class="page-link" href="#">Sau</a></li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
            <!-- </div> -->
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // sử lý tìm kiếm với ajax
        $(document).ready(function(){
            $("#timkiem").on('input', function(event){
                event.preventDefault();
                var giatri = $(this).val();
                $.ajax({
                    url: "ajax/search_room.php",
                    type: "GET",
                    data: { giatri: giatri },
                    success: function(data){
                        $("#ds_phong").html(data);
                    }
                });
                return false;
            });
        });
    </script>

<?php require(__DIR__.'/layouts/footer.php'); ?> 