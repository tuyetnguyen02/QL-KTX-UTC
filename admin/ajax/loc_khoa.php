<?php
session_start();
require('../../database/connect.php');	
require('../../database/query.php');

if(isset($_SESSION['useradmin'])){
    if(isset($_GET['giatri']) && isset($_GET['loc_nganh']) && isset($_GET['loc_gioitinh'])){//
        $giatri = $_GET['giatri'];
        $giatri = str_replace('\'', '\\\'', $giatri);
        $loc_nganh = $_GET['loc_nganh'];
        $loc_nganh = str_replace('\'', '\\\'', $loc_nganh);
        $loc_gioitinh = $_GET['loc_gioitinh'];
        $loc_gioitinh = str_replace('\'', '\\\'', $loc_gioitinh);

        $sql_student = "SELECT s.*, c.*, r.*, rtype.*, sem.* FROM student s
                        INNER JOIN contract c ON s.student_id = c.student_id
                        INNER JOIN room r ON c.room_id = r.room_id
                        INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id
                        INNER JOIN semester sem ON sem.semester_id = c.semester_id
                        WHERE c.status = true AND sem.status = true AND s.classroom like '%$giatri%' ";
        if($loc_nganh != ''){
            $sql_student .= " AND s.major like '$loc_nganh'";
        }
        if($loc_gioitinh != ''){
            $sql_student .= " AND s.gender like '$loc_gioitinh'";
        }
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
                    <td>$i</td>
                    <td>{$row['number_student']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['birthday']}</td>
                    <td>{$row['room_name']} ({$row['room_type_name']})</td>
                    <td>{$row['major']} ({$row['classroom']})</td>
                    <td>{$row['phone']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['address']}</td>
                    <td><li class='breadcrumb-item'><a href='chi_tiet_phong.php?room_id={$row['room_id']}'>Đi đến phòng ở</a></li></td>
                    <td><li class='breadcrumb-item'><a href=''>ADD to blacklist</a></li></td>
                </tr>";
            }
        }
        
        echo $kq; // Xuất ra kết quả
    }
} else {
    header('location: ../dang_nhap.php');
}
?>