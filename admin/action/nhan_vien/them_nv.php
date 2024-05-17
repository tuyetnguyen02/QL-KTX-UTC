<?php
    session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');

    $sql = "SELECT * FROM admin";
    $admin = queryResult($conn, $sql);

        $number_admin = $_POST['number_admin'];
        $admin_name = $_POST['admin_name'];
        $position = $_POST['position'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $birthday = $_POST['birthday'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $image = '../image/face/'. $_FILES['image']['name'];

        // if(isset($_FILES['url_image'])) {
        //     $url_image = 'image/roomtype/'. $_FILES['url_image']['name'];
        $check_number_admin = true;
        
        foreach($admin as $admin){
            if($admin['number_admin'] == $number_admin){
                $check_number_admin = false;
                break;
            }
        }
        if($check_number_admin == true){
            // move_uploaded_file($_FILES['image']['tmp_name'], '../image/face/'. $_FILES['url_image']['name']);
            // Sử dụng $_FILES['url_image']['name'] để lấy tên của tệp tin được tải lên và $_FILES['url_image']['tmp_name'] để lấy đường dẫn tạm thời của tệp tin.
            $status = 1;
            $password = "123456";
            $sql_insert = "INSERT INTO `admin`(`number_admin`,`admin_name`,`position`,`phone`,`gender`,`birthday`,`email`,`address`,`image`,`status`,`password`)
            VALUES ('".$number_admin."','".$admin_name."','".$position."','".$phone."','".$gender."','".$birthday."','".$email."','".$address."','".$image."','".$status."','".$password."')";
            queryExecute($conn, $sql_insert);
            echo '<script type="text/javascript">

                window.onload = function () { 
                    
                    alert("Thêm tài khoản thành công!");
                    setTimeout(function() {
                        window.location.href = "../../ds_nhanvien.php";
                    }, 0);
                    window.location.href = "../../ds_nhanvien.php";
                }

            </script>';
            // header("Location: index.php");
        }
        else{
            echo '<script type="text/javascript">

                window.onload = function () { 
                    alert("Mã nhân viên đã tồn tại!");
                    window.location.href = "../../ds_nhanvien.php";
                }

            </script>';
        }
?>