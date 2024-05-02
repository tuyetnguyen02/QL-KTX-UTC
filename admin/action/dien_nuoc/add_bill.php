<?php
    session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');

    $number_admin = $_SESSION["useradmin"]; // mã nhân viên , ko phải id
    $sql_admin = "SELECT * FROM admin WHERE number_admin = '".$number_admin."'";
    $admin = mysqli_query($conn, $sql_admin)->fetch_assoc();
    $admin_id = $admin['admin_id'];

    $room_id = $_GET['room_id'];
    $jsVar = json_encode($room_id);

    $initial_electricity = $_POST['initial_electricity'];
    $final_electricity = $_POST['final_electricity'];
    $initial_water = $_POST['initial_water'];
    $final_water = $_POST['final_water'];
    
    if($final_electricity <= $initial_electricity || $final_water <= $initial_water){
        
        echo '<script type="text/javascript">
                    var jsVar = ' . $jsVar . ';
                    window.onload = function () { 
                        alert("Thêm hoá đơn thất bại. Chỉ số cuối phải lớn hơn chỉ số đầu!");
                        window.location.href = "../../chi_tiet_phong.php?room_id="+ jsVar;
                    }
    
                </script>';
        
    }else{
        $current_time = (new DateTime())->format('Y-m-d');
        $sql_services_dien = "SELECT * FROM services WHERE services_name = 'Điện'";
        $services_dien = mysqli_query($conn, $sql_services_dien)->fetch_assoc();
        $price_dien = $services_dien['price'];
        $sql_services_nuoc = "SELECT * FROM services WHERE services_name = 'Nước'";
        $services_nuoc = mysqli_query($conn, $sql_services_nuoc)->fetch_assoc();
        $price_nuoc = $services_nuoc['price'];

        $total_price = ($final_electricity - $initial_electricity) * $price_dien + ($final_water - $initial_water) * $price_nuoc;
        // echo $total_price;
        $sql_insert = "INSERT INTO `bill`(`admin_id1`,`room_id`,`created_date`,`initial_electricity`,`final_electricity`,`initial_water`,`final_water`,`price`,`status`)
                            VALUES ('".$admin_id."','".$room_id."','".$current_time."','".$initial_electricity."','".$final_electricity."','".$initial_water."','".$final_water."','".$total_price."', 0)";
        $insert = queryExecute($conn, $sql_insert);
        if(isset($insert)){
            echo '<script type="text/javascript">
                        window.onload = function () { 
                            var jsVar = ' . $jsVar . ';
                            window.location.href = "../../chi_tiet_phong.php?room_id="+ jsVar;
                            alert("Thêm thêm hoá đơn điện nước thành công!");
                            
                        }
        
                    </script>';
        }
    }
?>