<?php require(__DIR__.'/layouts/header.php'); ?> 


<?php 

// $sql_slide = "SELECT * FROM sanpham WHERE loaisanpham = 0 ORDER BY masanpham DESC";
// $slide = queryResult($conn,$sql_slide);

// $sql_noibat = "SELECT * FROM sanpham WHERE loaisanpham = 2 ORDER BY masanpham DESC";
// $noibat = queryResult($conn,$sql_noibat);

// $sql_moi = "SELECT * FROM sanpham WHERE loaisanpham = 3 ORDER BY masanpham DESC";
// $moi = queryResult($conn,$sql_moi);

// $sql_danhchoban = "SELECT * FROM sanpham ORDER BY RAND() LIMIT 7";
// $danhchoban = queryResult($conn,$sql_danhchoban);
$sql_loaiphong = "SELECT * FROM room_type ";
$loaiphong = queryResult($conn,$sql_loaiphong);
 ?>

        <!--=================================
        Hero Area
        ===================================== -->
        <!-- <div class="sectiontop">
            <h2>day là div sectiontop</h2>
        </div>
        <section class="hero-area hero-slider-1" >
            <h1>day là section1</h1>
                     <img src="image/background/background_login.png" alt="ảnh background">
            
        </section> -->
        <!--=================================
        Home Features Section
        ===================================== -->
        <section class="section-margin mb--30-index">
            <div class="container container_index">
                <h1>Chúng tôi là gia đình,</h1>
                <h1>không chỉ là nơi ở.</h1>
                <h5>Tạo kỉ niệm tại kí túc xá - Nơi bạn gọi là nhà</h5>
                <h3><?php //echo $_SESSION["user"]; ?></h3> <!-- test -->
                <h3><?php //echo $_SESSION["fullname"]; ?></h3> <!-- test -->
                <h3><?php //if($_SESSION["student_id"]) echo $_SESSION["student_id"]; else echo "Không tồn tại session student_id";?></h3> <!-- test -->
                <br></br>
                <div class="row">
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="text">
                                <h4>Nơi ở</h4>
                                <p>Đầy đủ trang thiết bị </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="text">
                                <h4>Thân thiện</h4>
                                <p>Đầy đủ cá dịch vụ tiện ích</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div class="text">
                                <h4>Tiết kiệm </h4>
                                <p>Chi phí thuê phòng thấp</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="text">
                                <h4>An toàn</h4>
                                <p>Ra vào được kiểm soát chặt</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=================================
        Promotion Section One
        ===================================== -->
        <section class="section-margin">
            <h2 class="sr-only">Brand Slider</h2>
            <div class="container">
                <div class="brand-slider sb-slick-slider border-top border-bottom" data-slick-setting='{
                                                "autoplay": true,
                                                "autoplaySpeed": 8000,
                                                "slidesToShow": 6
                                                }' data-slick-responsive='[
                    {"breakpoint":992, "settings": {"slidesToShow": 4} },
                    {"breakpoint":768, "settings": {"slidesToShow": 3} },
                    {"breakpoint":575, "settings": {"slidesToShow": 3} },
                    {"breakpoint":480, "settings": {"slidesToShow": 2} },
                    {"breakpoint":320, "settings": {"slidesToShow": 1} }
                ]'>
                    <?php while($row = $loaiphong->fetch_assoc()){ ?>
                        <div class="single-slide">
                            <img src="<?php echo $row['url_image']; ?>" alt="">
                        </div>
                    <?php } ?>
                    <!-- <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div> -->
                </div>
            </div>
        </section>

    </div>

    
    <!--=================================
    Footer Area
    ===================================== -->
    <?php require(__DIR__.'/layouts/footer.php'); ?>
