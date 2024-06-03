<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
// echo $_POST["airConditioned"];

$start = 0;
$limit = 6;

$sql_soluongloaiphong = "SELECT * FROM room_type";
$tongloaiphong = queryResult($conn,$sql_soluongloaiphong)->num_rows;
$sotrang = ceil($tongloaiphong / $limit);


$sql_semester = "SELECT * FROM semester WHERE status = true";
$semester = mysqli_query($conn, $sql_semester)->fetch_assoc();
//echo $semester['start_date'];


$currentDate = new DateTime(); // lấy thời gian tại thời điểm hiện tại
$start_date = new DateTime($semester['start_date']);
$start_date->format('d-m-Y'); // đặt lại định dạng (Y-m-d) -> (d-m-Y)
$end_date = new DateTime($semester['end_date']);
$registration_startdate = new DateTime($semester['registration_startdate']);
$registration_enddate = new DateTime($semester['registration_enddate']);
//echo $end_date->format('d-m-Y');


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


?>

<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Loại phòng</li>
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
                <div class="col-sm-7">
                  <div class="row">
                    <div class="col-sm-3">
                      <span style="font-weight: bold">Học kỳ:</span> <br><br>
                      <span style="font-weight: bold"><?php echo $semester['semester'] . " " . $semester['school_year']?></span>
                    </div>
                    <!-- <div class="col-sm-2">
                      <span style="font-weight: bold">Năm học:</span>
                      <br />{{ sesmester.schoolYear }}
                    </div> -->
                    <div class="col-sm-4">
                      <span style="font-weight: bold">Thời gian đăng ký:</span> <br><br>
                      <span style="font-weight: bold"><?php echo $registration_startdate->format('d-m-Y') . " đến " . $registration_enddate->format('d-m-Y');?></span>
                    </div>
                    <div class="col-sm-4">
                      <span style="font-weight: bold">Thời gian ở:</span> <br><br>
                      <span style="font-weight: bold"><?php echo $start_date->format('d-m-Y') . " đến " . $end_date->format('d-m-Y') ;?></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="filter-group">
                    <label style="font-weight: bold"><i class="fa fa-bed"></i> Loại dãy</label>
                    <div id="checkboxContainer">
                        <div>
                            <input type="checkbox" name="airConditioned" value="1" id="AirConditioned" />
                            <label class="mx-4" for="AirConditioned">Có máy lạnh</label>
                        </div>
                        <div>
                            <input type="checkbox" name="cooked" value="1" id="Cooked" />
                            <label class="mx-4" for="Cooked">Cho phép nấu ăn</label>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="filter-group">
                    <label style="font-weight: bold">
                      <i class="fa fa-user-friends"></i> Số lượng
                    </label>
                    <select
                      class="form-control nice-select sort-select mr-0 select-filtera" id="loc_soluong"
                    >
                      <option value="">Tất cả</option>
                      <option value="4">4 người/phòng</option> 
                      <option value="6">6 người/phòng</option> 
                      <option value="8">8 người/phòng</i></option> 
                    </select>
                    
                  </div>
                </div>
              </div>
            </form>
            <div class="row mt-3">
              <div class="col-sm-5"></div>

              <div
                class="col-sm-4  <?php if($currentDate >= $start_date && $currentDate <= $end_date)
                        echo "text-success";
                      else  
                        echo "text-danger";
                ?>"
                style="font-style: italic; font-weight: bold"
              >
                <?php if($currentDate >= $start_date && $currentDate <= $end_date)
                        echo "Đây là thời gian đăng ký ở";
                      else  
                        echo "Đã hết hạn đăng ký ở";
                ?>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-sm-4"></div>
              <div class="col-sm-4"></div>
              <div style="font-style: italic; color: rgb(72, 62, 62)" class="col-sm-4">
                * Hình ảnh chỉ mang tinh chất minh họa*
              </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <!-- Product View Mode -->
                    <div class="product-view-mode">
                        <a href="#" class="sorting-btn active" data-target="grid"><i class="fas fa-th"></i></a>
                        <a href="#" class="sorting-btn" data-target="grid-four">
                            <span class="grid-four-icon">
                                <i class="fas fa-grip-vertical"></i><i class="fas fa-grip-vertical"></i>
                            </span>
                        </a>
                        <a href="#" class="sorting-btn" data-target="list "><i class="fas fa-list"></i></a>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-6  mt--10 mt-sm--0">
                    
                </div>
                <div class="col-lg-1 col-md-2 col-sm-6  mt--10 mt-md--0">
                    
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 mt--10 mt-md--0 ">
                    <!-- <div class="sorting-selection">
                        <span>Sắp xếp theo:</span>
                        <select class="form-control nice-select sort-select mr-0">
                            <option value="" >Mặc Định</option>
                            <option value="">
                                Theo tên: (A - Z)</option>
                            <option value="">
                                Theo tên: (Z - A)</option>
                            <option value="">
                                Theo giá: (Thấp &gt; Cao)</option>
                            <option value="">
                                Theo giá: (Thấp &gt; Cao)</option>
                            
                        </select>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border" id="ds_loaiphong">


            <?php while($row = $loaiphong->fetch_assoc()){ ?>

                <div class="col-lg-4 col-sm-6" href="danh_sach_phong.php?id=<?php echo $row['room_type_id']; ?>">
                    <a href="danh_sach_phong.php?id=<?php echo $row['room_type_id']; ?>">
                        <div class="card_item_roomtype text-black">
                            <i class="fa fa-home fa-lg pt-3 pb-1 px-3 mb-2"></i>
                            <div class="product-header">
                                <!-- <img src="image/roomtype/A1.jpg" alt=""> -->
                                <img src="<?php echo $row['url_image']; ?>" class="d-block w-100" alt="..." />
                            </div>

                            <div class="product-card--body">
                                <div class="text-center">
                                    <h5 class="card-title" style="font-weight: bolder">
                                    <?php echo $row['room_type_name']; ?>
                                    </h5>
                                </div>
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <span><i class="fa fa-snowflake"></i> Máy lạnh</span
                                        ><span><?php if($row['is_air_conditioned']) echo "Có"; else echo "Không";?></span>
                                        
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span><i class="fa fa-fish"></i> Nấu ăn</span
                                        ><span><?php if($row['is_cooked']) echo "Cho phép"; else echo "Không cho phép";?></span>
                                        
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span><i class="fa fa-user-friends"></i> Số lượng</span
                                        ><span><?php echo $row['max_quantity']; ?> </span>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-center <?php if($row['enable']) echo "text-success"; else echo "text-warning";?>" style="font-weight: bold">
                                        <?php if($row['enable']) echo "Hoạt động tốt"; else echo "Đang sửa chữa";?></span>
                                                                            
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between total font-weight-bold ">
                                    <span><i class="fa fa-money-check-alt"> </i> Giá</span
                                    ><span><?php echo $row['price']?>đ/tháng</span> 
                                </div>
                            </div>
                        
                        </div>
                    </a>
                </div>

            <?php } ?>
            
            
            
        </div>
        
    </div>
    <nav aria-label="Page navigation example">
        <br>
        <br>
        <ul class="pagination" style="justify-content: center;">
            <?php if(isset($_GET['trang'])){ ?>
                <li class="page-item"><a class="page-link" href="./loai_phong.php?trang=<?php echo $_GET['trang'] - 1; ?>">Trước</a></li>
            <?php }else{ ?>
                <li class="page-item"><a class="page-link" href="#">Trước</a></li>
            <?php } ?>
            <?php for($i = 1; $i <= $sotrang; $i++){ ?>
                <?php if($i == 1){ ?>
                    <li class="page-item"><a class="page-link" href="./loai_phong.php"><?php echo $i; ?></a></li>
                <?php }else{ ?>
                    <li class="page-item"><a class="page-link" href="./loai_phong.php?trang=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php } ?>
            <?php } ?>
            <?php if(isset($_GET['trang']) && $sotrang >= 2 && $sotrang != $_GET['trang']){ ?>
                <li class="page-item"><a class="page-link" href="./loai_phong.php?trang=<?php echo $_GET['trang'] + 1; ?>">Sau</a></li>
            <?php }else{ ?>
                <li class="page-item"><a class="page-link" href="#">Sau</a></li>
            <?php } ?>
        </ul>
    </nav>
    
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  // sử dụng AJAX lọc loại phòng
  // $(document).ready(function(){
  //   $("#loc_soluong").on('input', function(event){
  //       event.preventDefault();
  //       console.log("Sự kiện input đã được bắt!");
  //       var giatri = $(this).val();
  //       // var loc_khoa = $("#loc_khoa").val();
  //       // var loc_nganh = $("#loc_nganh").val();
  //       $.ajax({
  //           url: "ajax/loc_soluong.php",
  //           type: "GET",
  //           data: { giatri: giatri },//,loc_khoa:loc_khoa, loc_nganh: loc_nganh
  //           success: function(data){
  //               $("#ds_loaiphong").html(data);
  //               // $("#timkiem").val("");
  //           }
  //       });
  //       return false;
  //   });
  // });
  $(document).ready(function(){
    $("#loc_soluong").on('change', function(event){
        event.preventDefault();
        var giatri = $(this).val();
        var airConditioned = $("#AirConditioned").prop("checked") ? 1 : 0;
        var cooked = $("#Cooked").prop("checked") ? 1 : 0;
        // Kiểm tra nếu giá trị là tất cả
        if (giatri === "") {
            // Thực hiện AJAX request để lấy toàn bộ danh sách loại phòng
            $.ajax({
                url: "ajax/loc_soluong.php",
                type: "GET",
                success: function(data){
                    $("#ds_loaiphong").html(data);
                }
            });
        } else {
            // Nếu không, thực hiện AJAX request để lọc loại phòng theo số lượng
            $.ajax({
                url: "ajax/loc_soluong.php",
                type: "GET",
                data: { giatri: giatri, airConditioned: airConditioned, cooked: cooked },
                success: function(data){
                    $("#ds_loaiphong").html(data);
                }
            });
        }
    });
  });
  // lọc checkbox
  $(document).ready(function(){
    // Bắt sự kiện thay đổi của các checkbox
    $("#checkboxContainer input[type='checkbox']").on('change', function(){
        // Lấy giá trị của các checkbox
        var airConditioned = $("#AirConditioned").prop("checked") ? 1 : 0;
        var cooked = $("#Cooked").prop("checked") ? 1 : 0;
        var giatri = $("#loc_soluong").val();
        // Gửi yêu cầu AJAX với các giá trị checkbox
        $.ajax({
            url: "ajax/loc_checkbox.php",
            type: "GET",
            data: { airConditioned: airConditioned, cooked: cooked, giatri: giatri },
            success: function(data){
                // Cập nhật nội dung của phần tử hiển thị kết quả
                $("#ds_loaiphong").html(data);
            }
        });
    });
  });
</script>

<?php require(__DIR__.'/layouts/footer.php'); ?>