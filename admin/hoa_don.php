<?php require(__DIR__.'/layouts/header.php'); ?> 
<?php
$i=1;
$sql_hoadon = "SELECT * FROM payment p INNER JOIN student s ON s.student_id = p.student_id ORDER BY p.datetime DESC";
$hoadon = queryResult($conn,$sql_hoadon);

?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body" style="overflow: auto;">
                    <div class="page-header">
                        <h3 class="page-title"> THÔNG TIN HOÁ ĐƠN THANH TOÁN</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <button class="btn btn-link btn-rounded btn-fw" 
                                        id="addroom-btn-open" style="font-size: 16px;">
                                        In danh sách
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
                                <th>Mã hoá đơn</th>
                                <th>Mã sinh viên</th>
                                <th>Sinh viên</th>
                                <th>Tiền phòng</th>
                                <th>Tiền dịch vụ</th>
                                <th>Tiền điện nước</th>
                                <th>Thời gian</th>
                                <th>Phương thức</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody id="ds_sinhvien">
                            <?php while($row = $hoadon->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $i; $i++;?></td>
                                <td><?php echo $row['payment_id'];?></td>
                                <td><?php echo $row['number_student'];?></td>
                                <td><?php echo $row['name'];?></td>
                                <td><?php if($row['contract_id'] != null) echo "X";?></td>
                                <td><?php if($row['register_services_id'] != null) echo "X";?></td>
                                <td><?php if($row['bill_id'] != null) echo "X";?></td>
                                <td><?php echo $row['datetime'];?></td>
                                <td><?php echo $row['method'];?></td>
                                <td><?php echo $row['total_price'];?></td>
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
                                        <form action="action/edit_roomtype.php?id=<?php echo $roomtype_id;?>" method="POST">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" >Tên dịch vụ</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="services_name" disabled name="services_name">
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
 
//         $(document).ready(function(){
//             $('.editroom-btn-open').click(function(){
//                 // var serviceId = $(this).database('services_id');
//                 //var serviceId = $(this).data('service-id');
//                 var serviceName = $(this).data('services_name');
//                 var serviceDescription = $(this).data('description');
//                 var servicePrice = $(this).data('price');
//                 var serviceStatus = $(this).data('enable');
// 9
//                 // $('#services_id').val(serviceId);
//                 $('#services_name').val(serviceName);
//                 $('#description').val(serviceDescription);
//                 $('#price').val(servicePrice);
//                 $('#enable').val(serviceStatus);
//             });
//         });

        openeditroom.addEventListener('click', ()=>{
            modal_container_editroom.classList.add('show');
        });
        closeeditroom.addEventListener('click', ()=>{
            modal_container_editroom.classList.remove('show');
        });

        
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // sử lý tìm kiếm với ajax
        $(document).ready(function(){
            $("#timkiem").on('input', function(event){
                event.preventDefault();
                var giatri = $(this).val();
                $.ajax({
                    url: "ajax/search_student_bill.php",
                    type: "GET",
                    data: { giatri: giatri },
                    success: function(data){
                        $("#ds_sinhvien").html(data);
                        $("#loc_khoa, #loc_nganh, #loc_gioitinh").val("");
                    }
                });
                return false;
            });
        });
    </script>

<?php require(__DIR__.'/layouts/footer.php'); ?> 