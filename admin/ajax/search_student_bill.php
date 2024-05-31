<?php
session_start();
require('../../database/connect.php');	
require('../../database/query.php');

if(isset($_SESSION['useradmin'])){
    if(isset($_GET['giatri'])){
        $giatri = $_GET['giatri'];
        $giatri = str_replace('\'', '\\\'', $giatri);
        $sql_student = "SELECT * FROM payment p
                        INNER JOIN student s ON s.student_id = p.student_id
                        WHERE s.number_student like '%$giatri%' OR s.name like '%$giatri%'
                        ORDER BY p.datetime DESC";
        $student = mysqli_query($conn, $sql_student);
        $kq = '';
        $i=0;
        if($student && $student->num_rows == 0){
            $kq = "Không tìm thấy dữ liệu";
        }else{
            while($row = $student->fetch_assoc()){
                $i++;
                $kq .= "
                <tr>
                    <td>" . $i . "</td>
                    <td>" . $row['payment_id'] . "</td>
                    <td>" . $row['number_student'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . ($row['contract_id'] != null ? "X" : "") . "</td>
                    <td>" . ($row['register_services_id'] != null ? "X" : "") . "</td>
                    <td>" . ($row['bill_id'] != null ? "X" : "") . "</td>
                    <td>" . $row['datetime'] . "</td>
                    <td>" . $row['method'] . "</td>
                    <td>" . $row['total_price'] . "</td>
                </tr>";
            }
        }
        
        echo $kq; // Xuất ra kết quả
    }
} else {
    header('location: ../dang_nhap.php');
}
?>