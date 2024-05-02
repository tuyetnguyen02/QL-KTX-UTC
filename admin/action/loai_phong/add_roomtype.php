<?php
    session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');

    $sql = "SELECT * FROM room_type";
    $roomtype = queryResult($conn, $sql);

        $room_type_name = $_POST['room_type_name'];
        $max_quantity = $_POST['max_quantity'];
        $price = $_POST['price'];
        $is_cooked = $_POST['is_cooked'];
        $is_air_conditioned = $_POST['is_air_conditioned'];
        $enable = $_POST['enable'];
        $url_image = 'image/roomtype/'. $_FILES['url_image']['name'];

        // if(isset($_FILES['url_image'])) {
        //     $url_image = 'image/roomtype/'. $_FILES['url_image']['name'];
        $check_roomtype_name = true;
        
        foreach($roomtype as $roomtype){
            if($roomtype['room_type_name'] == $room_type_name){
                $check_roomtype_name = false;
                break;
            }
        }
        if($check_roomtype_name == true){
            move_uploaded_file($_FILES['url_image']['tmp_name'], 'roomtype/'. $_FILES['url_image']['name']);
            // Sử dụng $_FILES['url_image']['name'] để lấy tên của tệp tin được tải lên và $_FILES['url_image']['tmp_name'] để lấy đường dẫn tạm thời của tệp tin.
            $created_date = date('Y-m-d');
            $sql_insert = "INSERT INTO `room_type`(`room_type_name`,`max_quantity`,`price`,`is_cooked`,`is_air_conditioned`,`enable`,`url_image`,`created_date`)
            VALUES ('".$room_type_name."','".$max_quantity."','".$price."','".$is_cooked."','".$is_air_conditioned."','".$enable."','".$url_image."','".$created_date."')";
            queryExecute($conn, $sql_insert);
            echo '<script type="text/javascript">

                window.onload = function () { 
                    
                    alert("Thêm thành công!");
                    setTimeout(function() {
                        window.location.href = "../../index.php";
                    }, 0);
                    window.location.href = "../../index.php";
                }

            </script>';
            // header("Location: index.php");
        }
        else{
            echo '<script type="text/javascript">

                window.onload = function () { 
                    alert("Tên loại phòng đã tồn tại!");
                    window.location.href = "../../index.php";
                }

            </script>';
        }
?>