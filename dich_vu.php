<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
    $number_student = $_SESSION['user']; // lấy id của student
    //echo $number_student;
    $sql_sv = "SELECT * FROM student WHERE number_student = '".$number_student."'";
    $sv = mysqli_query($conn, $sql_sv)->fetch_assoc();
    $msv = $sv['student_id'];

    // check contract trước khi cấp phép đăng ký
    $sql_contract = "SELECT * FROM contract WHERE student_id = '".$msv."'";
    $result_contract = mysqli_query($conn, $sql_contract);
    
    if($result_contract && mysqli_num_rows($result_contract) > 0) {
        $contract = mysqli_fetch_assoc($result_contract);
        if($contract['status'] == 0 || $contract['status'] == 1){
            $check_contract = true;
        }else{
            $check_contract = false;
        }
        
    } else {
        $check_contract = false;
    }

    $sql_semester = "SELECT * FROM semester WHERE status = true";
    $semester = mysqli_query($conn, $sql_semester)->fetch_assoc();

    $currentDate = new DateTime(); // lấy thời gian tại thời điểm hiện tại
    $start_date = new DateTime($semester['start_date']);
    $start_date->format('d-m-Y'); // đặt lại định dạng (Y-m-d) -> (d-m-Y)
    $end_date = new DateTime($semester['end_date']);
    $registration_startdate = new DateTime($semester['registration_startdate']);
    $registration_enddate = new DateTime($semester['registration_enddate']);
    //echo $end_date->format('d-m-Y');

    $gui_xedap = "Gửi xe đạp";
    $sql_xedap = "SELECT * FROM services WHERE services_name = '".$gui_xedap."'";
    $xedap = mysqli_query($conn, $sql_xedap)->fetch_assoc();
    // echo $xedap['services_name'];
    $gui_xemay = "Gửi xe máy";
    $sql_xemay = "SELECT * FROM services WHERE services_name = '".$gui_xemay."'";
    $xemay = mysqli_query($conn, $sql_xemay)->fetch_assoc();

    $ve_sinh = "Vệ sinh khu vực";
    $sql_ve_sinh = "SELECT * FROM services WHERE services_name = '".$ve_sinh."'";
    $vesinh = mysqli_query($conn, $sql_ve_sinh)->fetch_assoc();

    // kiểm tra xem đã đăng kí dịch vụ gửi xe, vệ sinh hay chưa
    $sql_services_guixemay = "SELECT * FROM services WHERE services_name = 'Gửi xe máy'";
    $services_guixemay = mysqli_query($conn, $sql_services_guixemay)->fetch_assoc();
    $sql_services_guixedap = "SELECT * FROM services WHERE services_name = 'Gửi xe đạp'";
    $services_guixedap = mysqli_query($conn, $sql_services_guixedap)->fetch_assoc();
    $sql_services_vesinh = "SELECT * FROM services WHERE services_name = 'Vệ sinh khu vực'";
    $services_vesinh = mysqli_query($conn, $sql_services_vesinh)->fetch_assoc();

    $sql_guixemay = "SELECT * FROM register_services WHERE semester_id = '".$semester['semester_id']."' AND student_id = '".$msv."'AND services_id = '".$services_guixemay['services_id']."'";
    $guixe_may = mysqli_query($conn, $sql_guixemay)->fetch_assoc();
    $check_xemay = ($guixe_may == NULL ? false : true);
    echo $check_xemay;

    $sql_guixedap = "SELECT * FROM register_services WHERE semester_id = '".$semester['semester_id']."' AND student_id = '".$msv."'AND services_id = '".$services_guixedap['services_id']."'";
    $guixe_dap = mysqli_query($conn, $sql_guixedap)->fetch_assoc();
    $check_xedap = ($guixe_dap == NULL ? false : true);
    echo $check_xedap;

    $sql_vesinh = "SELECT * FROM register_services WHERE semester_id = '".$semester['semester_id']."' AND student_id = '".$msv."'AND services_id = '".$services_vesinh['services_id']."'";
    $DV_vesinh = mysqli_query($conn, $sql_vesinh)->fetch_assoc();
    $check_vesinh = ($DV_vesinh == NULL ? false : true);
    echo $check_vesinh;

?>
<section class="breadcrumb-section">
    <h2 class="sr-only">Site Breadcrumb</h2>
    <div class="container">
        <div class="breadcrumb-contents">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Trang Chủ</a></li>
                    <li class="breadcrumb-item active">Dịch vụ</li>
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
                <!-- <div class="col-sm-7">
                  <div class="row"> -->
                    <div class="col-sm-4">
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
                  <!-- </div>
                </div> -->
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
                        echo "Đây là thời gian đăng ký";
                      else  
                        echo "Đã hết hạn đăng ký";
                ?>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-sm-3"></div>
              <div class="col-sm-4"></div>
              <div style="font-style: italic; color: rgb(72, 62, 62)" class="col-sm-5">
                *Lưu ý : Bạn chỉ được đăng kí một trong hai dịch vụ gửi xe
              </div>
            </div>
        </div>

        <div class="shop-product-wrap grid with-pagination row space-db--30 shop-border">

                <div class="col-lg-4 col-sm-6 service ">
                    <div class="card_item_roomtype text-black text-center">
                        <div class="item-icon-dichvu">
                            <div class="icon-dichvu ">
                                <i class="fa fa-bicycle "></i>
                            </div>
                        </div>
                        
                        <h4 class="card-title " style="font-weight: bolder">
                            <a style="cursor: pointer"><?php echo $xedap['services_name'];?></a>
                        </h4>
                        <p style="font-size: 17px">
                            <b>Giá:</b><?php echo $xedap['price'];?> đ/tháng
                        </p>
                        <p>
                            <?php echo $xedap['description'];?>
                        </p>
                        <form style="opacity: 0; pointer-events: none;">
                        <input 
                            type="text"
                            
                            placeholder="Nhập biển số xe "
                        />
                        </form>
                        <button class="btn-dang-ki" onclick="GuiXedap('<?php echo $check_xedap;?>','<?php echo $check_xemay;?>'
                                                        ,'<?php echo $semester['semester_id'];?>','<?php echo $xedap['services_id'];?>'
                                                        ,'<?php echo $xedap['price'];?>','<?php echo $check_contract;?>')">
                            Đăng ký
                        </button>
                        

                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 service ">
                    <div class="card_item_roomtype text-black text-center">
                        <div class="item-icon-dichvu">
                            <div class="icon-dichvu ">
                                <i class="fa fa-motorcycle "></i>
                            </div>
                        </div>
                        
                        <h4 class="card-title " style="font-weight: bolder">
                            <a style="cursor: pointer"><?php echo $xemay['services_name'];?></a>
                        </h4>
                        <p style="font-size: 17px">
                            <b>Giá:</b><?php echo $xemay['price'];?> đ/tháng
                        </p>
                        <p>
                            <?php echo $xemay['description'];?>
                        </p>
                        <form style="opacity: 1; pointer-events: all;">
                        <input 
                            type="text"
                            id="bien_soxe"
                            placeholder="Nhập biển số(88A12345)"
                        />
                        </form>
                        
                        <button class="btn-dang-ki" onclick="GuiXemay('<?php echo $check_xedap;?>','<?php echo $check_xemay;?>'
                                                        ,'<?php echo $semester['semester_id'];?>','<?php echo $xemay['services_id'];?>'
                                                        ,'<?php echo $xemay['price'];?>','<?php echo $check_contract;?>')">
                            Đăng ký
                        </button>

                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 service ">
                    <div class="card_item_roomtype text-black text-center">
                        <div class="item-icon-dichvu">
                            <div class="icon-dichvu ">
                                <i class="fa fa-american-sign-language-interpreting "></i>
                            </div>
                        </div>
                        
                        <h4 class="card-title " style="font-weight: bolder">
                            <a style="cursor: pointer"><?php echo $vesinh['services_name'];?></a>
                        </h4>
                        <p style="font-size: 17px">
                            <b>Giá:</b><?php echo $vesinh['price'];?> đ/tháng
                        </p>
                        <p>
                            <?php echo $vesinh['description'];?>
                        </p>
                        <form style="opacity: 0; pointer-events: none;">
                        <input 
                            type="text"
                            
                            placeholder="Nhập biển số xe "
                        />
                        </form>
                        <button class="btn-dang-ki" onclick="VeSinh('<?php echo $check_vesinh;?>','<?php echo $semester['semester_id'];?>'
                                                                ,'<?php echo $vesinh['services_id'];?>','<?php echo $vesinh['price'];?>','<?php echo $check_contract;?>')">
                            Đăng ký
                        </button>
                        

                    </div>
                </div>

            
            
            
        </div>
    </div>
</main>
<script>
    function GuiXedap(check_xedap, check_xemay, semester_id, services_id, price, check_contract){
        if(check_contract == true){
            if(check_xemay){
                alert("Đăng kí thất bại. Bạn đã đăng kí gửi xe máy rồi");
                window.location.href = 'thong_tin_ca_nhan.php';
            }else{
                if(check_xedap){
                    alert("Đăng kí thất bại. Bạn đã đăng kí gửi xe đạp rồi");
                    window.location.href = 'thong_tin_ca_nhan.php';
                }else{
                    window.location.href = 'action/dangky_dichvu.php?semester_id='+semester_id + '&services_id='+services_id +'&price=' + price ;
                }
            }
        }else{
            alert("Bạn cần đăng ký thành công ở KTX trước");
            window.location.href = 'thong_tin_ca_nhan.php';
        }
    }
    function GuiXemay(check_xedap, check_xemay, semester_id, services_id, price, check_contract){
        if(check_contract == true){
            if(check_xedap){
                alert("Đăng kí thất bại. Bạn đã đăng kí dịch vụ gửi xe đạp!");
                window.location.href = 'thong_tin_ca_nhan.php';
            }else{
                if(check_xemay){
                    alert("Đăng kí thất bại. Bạn đã đăng kí dịch vụ gửi xe máy!");
                    window.location.href = 'thong_tin_ca_nhan.php';
                }else{
                    var bien_soxe = document.getElementById("bien_soxe").value;
                    //alert("Đăng kí thất bại" + bien_soxe);
                    var regex = /^[0-9]{2}[A-Z][0-9]{5}$/; // Biểu thức chính quy để kiểm tra định dạng
                    if (regex.test(bien_soxe)) {
                        window.location.href = 'action/dangky_dichvu.php?semester_id='+semester_id + '&services_id='+services_id +'&price=' + price + '&bien_soxe=' + bien_soxe ;
                    } else {
                        alert("Định dạng biển số không đúng");
                    }
                    
                }
            }
        }else{
            alert("Bạn cần đăng ký thành công ở KTX trước");
            window.location.href = 'thong_tin_ca_nhan.php';
        }
    }
    function VeSinh(check_vesinh, semester_id, services_id, price, check_contract){
        if(check_contract == true){
            if(check_vesinh){
                alert("Đăng kí thất bại. Bạn đã đăng kí dịch vụ vệ sinh!");
                window.location.href = 'thong_tin_ca_nhan.php';
            }else{
                //alert("Đăng kí thành công!"+price);
                window.location.href = 'action/dangky_dichvu.php?semester_id='+semester_id + '&services_id='+services_id +'&price=' + price ;
            }
        }else{
            alert("Bạn cần đăng ký thành công ở KTX trước");
            window.location.href = 'thong_tin_ca_nhan.php';
        }
    }
</script>

<?php require(__DIR__.'/layouts/footer.php'); ?>