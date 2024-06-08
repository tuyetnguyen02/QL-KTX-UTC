<?php 
require(__DIR__.'/layouts/header.php'); 
require 'vendor/autoload.php';
?> 
<?php
$i=1;
$sql_hoadon = "SELECT * FROM payment p INNER JOIN student s ON s.student_id = p.student_id ORDER BY p.datetime DESC";
$hoadon = queryResult($conn,$sql_hoadon);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if(isset($_POST['btn_Export'])){
    echo '<script>window.location.href = "action/xuat_excel/xuat_excel_hoadon.php";</script>';
}
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
                                <form method="POST">
                                    <button class="btn btn-link btn-rounded btn-fw" 
                                            name="btn_Export" type="Submit" style="font-size: 16px;">
                                            In danh sách
                                    </button>    
                                </form>
                                
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