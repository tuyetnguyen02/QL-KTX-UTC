<?php
    session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');

    $services_name = $_POST['services_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $enable = $_POST['enable'];    


    echo $services_name .'/'. $description .'/'. $price .'/'. $enable;
    

    $sql_update = "UPDATE `services` SET `services_name` = '".$services_name."',`description` = '".$description."',`price` = '".$price."',`enable` = '".$enable."' 
                    WHERE `services`.`services_name` = '".$services_name."';";
    queryExecute($conn, $sql_update);
    echo '<script type="text/javascript">
                window.onload = function () { 
                    window.location.href = "../../dich_vu.php";
                    alert("Cập nhật thành công!");
                    
                }

            </script>';
?>