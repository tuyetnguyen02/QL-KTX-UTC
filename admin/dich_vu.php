<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$i=1;
$sql_dichvu = "SELECT * FROM services ";
$dichvu = queryResult($conn,$sql_dichvu);

?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> QUẢN LÝ DỊCH VỤ </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <button class="btn btn-link btn-rounded btn-fw" 
                                        id="addroom-btn-open" style="font-size: 16px;">
                                        <i class="mdi mdi-plus-circle-outline" style="font-size: 16px;"></i>Thêm dịch vụ
                                </button>
                            </ol>
                        </nav>
                    </div>
                    <!-- <h4 class="card-title">QUẢN LÝ LOẠI PHÒNG</h4>
                    <li class="breadcrumb-item"><a href="#">Thêm loại phòng</a></li> -->
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên dịch vụ</th>
                                <th>Mô tả</th>
                                <th>Giá tiền (VNĐ)</th>
                                <th>Trạng thái</th>
                                <th>Tác vụ</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $dichvu->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $row['services_name'];?></td>
                                <td><?php echo $row['description'];?></td>
                                <td><?php echo $row['price']?> đ/<?php  if($row['services_name'] == "Điện" || $row['services_name'] == "Nước") echo "số"; else echo "tháng";?></td>
                                <td style="color : <?php if($row['enable']) echo "green"; else echo "red";?>"><?php if($row['enable']) echo "Hoạt động tốt"; else echo "Đang sửa chữa";?></span></td>
                                <!-- <td><li class="breadcrumb-item" id="editroom-btn-open"><a href="">Sửa</a></li></td> -->
                                <!-- <td><button class="btn btn-link " id="editroom-btn-open" style="font-size: 14px; "> Sửa</button></td> -->
                                <td><button class="btn btn-link" id="editroom-btn-open" style="font-size: 14px;">Sửa</button></td>
                                <td><li class="breadcrumb-item"><a href="action/dich_vu/delete_services.php?services_id=<?php echo $row['services_id'];?>">Xoá</a></li></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>  
                      
                </div>
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
                                        <h3 class="page-title"> Thêm dịch vụ </h3>
                                        <button style="border:0px" id="addroom-btn-close"><i class="mdi mdi-close"></i></button>
                                    </div>
                                    <div class="addroom-modal-body card-body" style="padding: 0rem 2.5rem;">
                                        <form action="action/dich_vu/addservices.php" method="POST">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" required>Tên dịch vụ</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control chucvu" required name="services_name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" required>Mô tả</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control chucvu" id="exampleInputMobile" required name="description">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" required>Giá tiền</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control chucvu" id="exampleInputMobile" required name="price">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" required>Tình trạng</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="exampleSelectGender" required name="enable">
                                                        <option value="" style="display: none;"></option>
                                                        <option value="1">Hoạt động tốt</option>
                                                        <option value="0">Đang sửa chữa</option>
                                                    </select><br><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12 btn--seve">
                                                    <button type="submit" class="btn btn-outline-success btn-fw"style=" float: right;"> Tạo dịch vụ </button>
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

        <!-- lỗi sửa  -->
        <div class="row">
            <!-- modal edit roomtype room start-->
            <div class="col-lg-6 grid-margin stretch-card" id="editroom-wrapper">
                <div class="card" id="editroom-modal-container">
                    <div class="card-body">
                        <!-- <div id="demo-wrapper">
                            <div id="demo-modal-container"> -->
                                <div class="editroom-modal" id="editroom-modal-demo">
                                    <div class="editroom-modal-header page-header" style="border-bottom: 2px solid #8e94a9; padding-bottom:10px">
                                        <h3 class="page-title"> Chỉnh sửa thông tin dịch vụ </h3>
                                        <button style="border:0px" id="editroom-btn-close"><i class="mdi mdi-close"></i></button>
                                    </div>
                                    <div class="editroom-body card-body" style="padding: 0rem 2.5rem;">
                                        <form action="action/dich_vu/edit_services.php" method="POST">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" >Tên dịch vụ</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="services_name" placeholder="services_name" readonly name="services_name">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" >Mô tả</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="description" name="description">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;">Giá tiền (VNĐ)</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="price" required name="price" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;">Tình trạng</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="enable" required name="enable">
                                                        <option value="" style="display: none;"></option>
                                                        <option value="1">Hoạt động tốt</option>
                                                        <option value="0">Đang sửa chữa</option>
                                                    </select>
                                                </div><label style="color:red;" >*Lưu ý : Hãy luôn đảm bảo thông tin là chính xác nhất!</label>
                                            </div>
                                            
                                            <div class="form-group row">
                                                <div class="col-12 btn--seve" >
                                                    <button type="submit" class="btn btn-outline-success btn-fw "style=" float: right;"> Cập nhật </button>
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
            <!-- modal edit roomtype end-->
        </div>
    </div>
    <!-- content-wrapper ends -->
    <script>
        const open = document.getElementById('addroom-btn-open');
        // console.log(show);
        const close = document.getElementById('addroom-btn-close');
 
        const modal_container = document.getElementById('addroom-modal-container');
 
        open.addEventListener('click', ()=>{
            modal_container.classList.add('show');
        });
        close.addEventListener('click', ()=>{
            modal_container.classList.remove('show');
        });

        // script for modal editroom

        const openeditroom = document.getElementById('editroom-btn-open');
        // console.log(show);
        const closeeditroom = document.getElementById('editroom-btn-close');
 
        const modal_container_editroom = document.getElementById('editroom-modal-container');

        openeditroom.addEventListener('click', ()=>{
            modal_container_editroom.classList.add('show');
        });
        closeeditroom.addEventListener('click', ()=>{
            modal_container_editroom.classList.remove('show');
        });

        
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Xử lý sự kiện khi nhấn vào nút "Sửa"
            $("button#editroom-btn-open").click(function(){
                // Lấy dữ liệu từ các ô trong hàng (tr) tương ứng
                var services_name = $(this).closest("tr").find("td:eq(1)").text();
                var description = $(this).closest("tr").find("td:eq(2)").text();
                var price = $(this).closest("tr").find("td:eq(3)").text().split(' ')[0];
                var enable = $(this).closest("tr").find("td:eq(4)").text().trim() == "Hoạt động tốt" ? "1" : "0";

                // Đổ dữ liệu lấy được lên modal
                $("#services_name").val(services_name);
                $("#description").val(description);
                $("#price").val(price);
                $("#enable").val(enable);
                
                // Hiển thị modal
                $("#editroom-modal-demo").show();
            });

            // Xử lý sự kiện khi nhấn nút đóng modal
            $("button#editroom-btn-close").click(function(){
                // Ẩn modal
                $("#editroom-modal-demo").hide();
            });
        });
    </script>
<?php require(__DIR__.'/layouts/footer.php'); ?> 