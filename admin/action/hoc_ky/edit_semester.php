<?php
    session_start();
    require('../../../database/connect.php');	
    require('../../../database/query.php');
   
    $semester = $_POST['semester'];
    $school_year = $_POST['school_year'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $registration_startdate = $_POST['registration_startdate'];
    $registration_enddate = $_POST['registration_enddate'];
    $status = $_POST['status'];


    $sql_update = "UPDATE `semester` SET `start_date` = '".$start_date."',`end_date` = '".$end_date."',`registration_startdate` = '".$registration_startdate."',`registration_enddate` = '".$registration_enddate."',`status` = '".$status."' 
                    WHERE `semester`.`semester` = '".$semester."' AND `semester`.`school_year` = '".$school_year."'";
    queryExecute($conn, $sql_update);
    echo '<script type="text/javascript">
                window.onload = function () { 
                    window.location.href = "../../hoc_ky.php";
                    alert("Cập nhật thành công!");
                    
                }

            </script>';
?>