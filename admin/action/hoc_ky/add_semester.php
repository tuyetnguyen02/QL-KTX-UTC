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


    $sql_insert = "INSERT INTO `semester`(`semester`,`school_year`,`start_date`,`end_date`,`registration_startdate`,`registration_enddate`,`status`)
    VALUES ('".$semester."','".$school_year."','".$start_date."','".$end_date."','".$registration_startdate."','".$registration_enddate."','".$status."')";
    queryExecute($conn, $sql_insert);


    echo '<script type="text/javascript">
                window.onload = function () { 
                    window.location.href = "../../hoc_ky.php";
                    alert("Thêm học kỳ thành công!");
                    
                }

            </script>';
?>