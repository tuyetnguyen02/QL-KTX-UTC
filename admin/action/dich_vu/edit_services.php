<?php require(__DIR__.'../../../layouts/header.php'); ?> 
<?php
$i=1;
$sql_dichvu = "SELECT * FROM services ";
$dichvu = queryResult($conn,$sql_dichvu);

?>

<div class="main-panel"><!--style="padding : 20px 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);" -->
    <div class="content-wrapper" >
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
                                        <form action="action/dich_vu/edit_services.php?id=<?php echo $roomtype_id;?>" method="POST">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" >Tên loại phòng</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="exampleInputMobile" disabled name="roomtype_name" value="<?php echo $roomtype['room_type_name'];?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" >Máy lạnh</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="exampleSelectGender" required name="is_air_conditioned">
                                                        <option value="<?php echo $roomtype['is_air_conditioned'];?>" style="display: none;"><?php if(!$roomtype['is_air_conditioned']) echo "Có"; else echo "Không";?></option>
                                                        <option value="0">Có</option>
                                                        <option value="1">Không</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" >Nấu ăn</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="exampleSelectGender" required name="is_cooked">
                                                        <option value=""  style="display: none;"><?php if(!$roomtype['is_cooked']) echo "Cho phép"; else echo "Không cho phép";?></option>
                                                        <option value="0">Cho phép</option>
                                                        <option value="1">Không cho phép</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;" >Số lượng sv tối đa</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="exampleSelectGender" required name="max_quantity">
                                                        <option value="" style="display: none;"><?php echo $roomtype['max_quantity'];?></option>
                                                        <option value="4">4</option>
                                                        <option value="6">6</option>
                                                        <option value="8">8</option>    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;">Giá tiền (VNĐ)</label>
                                                <div class="col-sm-9">
                                                    <input type="number" class="form-control" id="exampleInputMobile" required name="price" value="<?php echo $roomtype['price']?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label" style="color:black;">Tình trạng</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" id="exampleSelectGender" required name="enable">
                                                        <option value="" style="display: none;"><?php if(!$roomtype['enable']) echo "Đang hoạt động"; else echo "Đang sửa chữa";?></option>
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
                            <!-- </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- modal edit roomtype end-->
        </div>
    </div>
    <!-- content-wrapper ends -->
    

<?php require(__DIR__.'/layouts/footer.php'); ?> 