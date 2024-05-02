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
            <div class="container">
                <h1>KÍ TÚC XÁ UTC</h2>

                <h3><?php echo $_SESSION["user"]; ?></h3> <!-- test -->
                <h3><?php echo $_SESSION["fullname"]; ?></h3> <!-- test -->
                <h3><?php if($_SESSION["student_id"]) echo $_SESSION["student_id"]; else echo "Không tồn tại session student_id";?></h3> <!-- test -->
                
                <div class="row">
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="text">
                                <h5>Giao Hàng</h5>
                                <p> Miễn phí giao hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-redo-alt"></i>
                            </div>
                            <div class="text">
                                <h5>Đổi Trả</h5>
                                <p>Trong vòng 1 tuần</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-piggy-bank"></i>
                            </div>
                            <div class="text">
                                <h5>Thanh Toán </h5>
                                <p>Thanh toán khi nhận hàng</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt--30">
                        <div class="feature-box h-100">
                            <div class="icon">
                                <i class="fas fa-life-ring"></i>
                            </div>
                            <div class="text">
                                <h5>Hỗ Trợ</h5>
                                <p>Tổng đài: 0988.888.999</p>
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
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                    <div class="single-slide">
                        <img src="image/background/background_login.png" alt="">
                    </div>
                </div>
            </div>
        </section>

    </div>

    
    <!--=================================
    Footer Area
    ===================================== -->
    <?php require(__DIR__.'/layouts/footer.php'); ?>
