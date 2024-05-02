<?php
    session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');


    $services_name = $_POST['services_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $enable = $_POST['enable'];


    $sql_insert = "INSERT INTO `services`(`services_name`,`description`,`price`,`enable`)
    VALUES ('".$services_name."','".$description."','".$price."','".$enable."')";
    queryExecute($conn, $sql_insert);

    echo '<script type="text/javascript">
                window.onload = function () { 
                    window.location.href = "../../dich_vu.php";
                    alert("Thêm thành công!");
                    
                }

            </script>';
?>