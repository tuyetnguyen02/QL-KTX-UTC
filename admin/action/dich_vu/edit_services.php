<?php

$services_id = $_GET['services_id'];
$sql_dichvu = "SELECT * FROM services WHERE services_id = '".$services_id."'";
$dichvu = queryResult($conn,$sql_dichvu)->fetch_assoc();

?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card" id="editroom-wrapper">
                <div class="card" id="editroom-modal-container">
                    <div class="card-body">
                        <div class="editroom-modal" id="editroom-modal-demo">
                            <div class="editroom-modal-header page-header" style="border-bottom: 2px solid #8e94a9; padding-bottom:10px">
                                <h3 class="page-title"> Chỉnh sửa thông tin dịch vụ </h3>
                                <button style="border:0px" id="editroom-btn-close"><i class="mdi mdi-close"></i></button>
                            </div>
                            <div class="editroom-body card-body" style="padding: 0rem 2.5rem;">
                                <form method="POST">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" style="color:black;" >Tên dịch vụ</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" disabled name="services_name" value="<?php echo $dichvu['services_name'];?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" style="color:black;">Giá tiền (VNĐ)</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control"  required name="price" value="<?php echo $dichvu['price']?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" style="color:black;">Mô tả </label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control"  required name="description" value="<?php echo $dichvu['description']?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label" style="color:black;">Tình trạng</label>
                                        <div class="col-sm-9">
                                            <select class="form-control" id="exampleSelectGender" required name="enable">
                                                <option value="" style="display: none;"><?php if(!$dichvu['enable']) echo "Đang hoạt động"; else echo "Đang sửa chữa";?></option>
                                                <option value="0">Hoạt động tốt</option>
                                                <option value="1">Đang sửa chữa</option>
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
                    </div>
                </div>
            </div>
            <!-- edit service end-->
        </div>
    </div>
    <!-- content-wrapper ends -->
    

<?php require(__DIR__.'/layouts/footer.php'); ?> 