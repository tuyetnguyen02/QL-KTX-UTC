<?php require(__DIR__.'/layouts/header.php'); ?> 

<?php
    $roomtype_id = $_GET['id'];
    // echo $roomtype_id;

    // Check the student's gender with the room's gender
    $number_student = $_SESSION['user'];
    //echo $number_student;
    $sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
    $sv = mysqli_query($conn, $sql_sv)->fetch_assoc();
    // echo $sv['gender'];
    // $sv['gender'] = 1 ? $gender_student="1" : $gender_student="0";
    // echo $gender_student;
    $check_gender = false;

    $student_id = $_SESSION["student_id"];
    echo $student_id;

    // check student in contract
    $check_contract = false;
    $sql_contract = "SELECT * FROM contract WHERE student_id = '".$sv['student_id']."'";
    $contract = mysqli_query($conn, $sql_contract)->fetch_assoc();
    $contract == null ? $check_contract=false : $check_contract=true;
    //echo $check_contract;

    $sql_loaiphong = "SELECT * FROM room_type WHERE room_type_id = '".$roomtype_id."'";
	$roomtype = mysqli_query($conn, $sql_loaiphong)->fetch_assoc();

    $sql_room = "SELECT * FROM room WHERE room_type_id = '".$roomtype_id."'"; 
    $room = queryResult($conn, $sql_room);
?>


<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Trang Chủ</a></li>
                    <li class="breadcrumb-item"><a href="loai_phong.php">Loại phòng </a></li>
                    <li class="breadcrumb-item">Phòng loại : <?php echo $roomtype['room_type_name']; ?></li>
                </ol>
            </nav>
        </div>
    </div>
</section>
<main class="inner-page-sec-padding-bottom">
    <div class="container">
        <section>
            <div class="container1" >
                <div >
                <div style="font-style: italic; color: rgb(72, 62, 62)">
                    *Hình ảnh chỉ mang tinh chất minh họa
                </div>
                <div class="carousel">
                    <ul class="carousel__slides">
                        <li class="carousel__slide" >
                            <figure class="row">
                                <div class="col-lg-8">
                                    <img src="<?php echo $roomtype['url_image'] ?>" alt="" style="width: 100%; height: 400px" />
                                </div>
                                <figcaption>
                                    <div>
                                    <span style="font-weight: bold">Máy lạnh: </span>
                                    <?php if($roomtype['is_air_conditioned']) echo "Có"; else echo "Không";?>
                                    </div>
                                    <div>
                                    <span style="font-weight: bold">Nấu ăn: </span>
                                    <?php if($roomtype['is_cooked']) echo "Cho phép"; else echo "Không cho phép";?>
                                    </div>
                                    <div>
                                    <span style="font-weight: bold">Số lượng tối đa: </span>
                                    <?php echo $roomtype['max_quantity']; ?> 
                                    </div>
                                    <div>
                                    <span style="font-weight: bold">Giá: </span>
                                    <?php echo $roomtype['price']?>đ/tháng
                                    </div>
                                </figcaption>
                            </figure>
                        </li>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-sm-12" style="text-align: justify">
                        <b>Lưu ý:</b> <br />+ Kiểm tra kỹ trước khi đăng ký, không thể hoàn
                        tác khi đã đăng ký xong. Ngoại trừ, các quy định cụ thể về thời gian.
                        <br />+ Sau khi đăng ký phòng thành công, sẽ có mail thông báo. Đóng
                        tiền đúng thời gian đã quy định.
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-sm-8"></div>
                    <div class="col-sm-2" style="align-items: center;">
                        <div class="row">
                            <div class="col-sm-1" style=" border: 1 px #eeeeee; height: 30px; width: 30px; background-color: #eeeeee; "></div>
                            <div class="col-sm-8">Phòng hết chỗ</div>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="row">
                            <div class="col-sm-1" style="height: 30px; width: 30px; background: #faebcc"></div>
                            <div class="col-sm-9">Phòng sửa chữa</div>
                        </div>
                    </div>
                </div>

                <table class="table text-center">
                    <thead class="table-dark">
                    <tr>
                        <th>Số phòng</th>
                        <th>Giới tính</th>
                        <th>Số lượng hiện tại</th>
                        <th>Còn trống</th>
                        <th>Hoạt động</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php 
                        if($room == NULL){echo "***Chưa có phòng thuộc loại phòng này";}
                        else{
                            while($row = $room->fetch_assoc()){ ?>
                            <tr class="row-room  <?php    if($row['enable'] == 0) echo "editroom";
                                                else {if($roomtype['max_quantity'] - $row['current_quantity'] == 0)
                                                        echo "fullroom";}
                                            ?>">
                                <td>
                                    <?php echo $row['room_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['room_gender'] == 0 ?  "Nam" : "Nữ" ; ?>
                                </td>
                                <td>
                                    <?php //updata số lượng sinh viên hiện tại trong 1 phòng
                                    $sql_soluong = "SELECT COUNT(*) AS contract_count FROM contract c
                                    INNER JOIN semester sem ON sem.semester_id = c.semester_id
                                    WHERE room_id = '".$row['room_id']."' AND sem.status = true";
                                    $soluong = mysqli_query($conn, $sql_soluong)->fetch_assoc();
                                    //echo $soluong['contract_count'];

                                    $sql_update = "UPDATE `room` SET `current_quantity` = '".$soluong['contract_count']."' WHERE `room_id` = '".$row['room_id']."'";
                                    queryExecute($conn, $sql_update);

                                    echo $row['current_quantity']; ?>
                                </td>
                                <td>
                                    <?php echo $roomtype['max_quantity'] - $row['current_quantity']; ?>
                                </td>
                                <td>
                                    <?php echo $row['enable'] == 0 ?  "Đang sửa chữa" : "Hoạt động tốt" ; ?>
                                </td>
                                <td>
                                    <?php
                                        // echo $row['enable'];
                                        $row['room_gender']==$sv['gender'] ? $check_gender="1" : $check_gender="0"; // 1 : trùng gender --- 0 : khác gender
                                        //echo $check_gender;
                                        if($row['enable'] == 1 && ($roomtype['max_quantity'] - $row['current_quantity']) > 0)
                                            echo '<button class="btn-dang-ki" onclick="BookingRoom('.$row['room_id'] .', '.$check_gender.', '.$check_contract.')">
                                            Đăng ký ở
                                            </button>';
                                    ?>
                                </td>
                                
                            </tr>
                        <?php } }?>
                        
                    </tbody>
                </table>
                </div>
            </div>

        </section>
    </div>
    <script>
        function BookingRoom(roomID, check_gender, check_contract) {
            if(check_contract == 1){ //check_contract == 1 : đã tồn tại contract chứa studdent_id 
                alert("Mỗi sinh viên chỉ được đăng kí 1 phòng. Đi đến thông tin cá nhân của bạn?");
                window.location.href = 'thong_tin_ca_nhan.php';
            }else{
                if(check_gender != 1){ // check_gender = false đưa ra thông báo
                    alert("Phòng không phù hợp với giới tính của bạn. Vui lòng chọn phòng khác!");
                }else{
                    // Chuyển hướng đến trang khác với tham số truy vấn
                    window.location.href = 'action/dangky_phong.php?room_id=' + roomID;
                }
            }
        }
    </script>
</main>
<?php require(__DIR__.'/layouts/footer.php'); ?>