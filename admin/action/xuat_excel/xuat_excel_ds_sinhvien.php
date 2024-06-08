<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../../vendor/autoload.php';
require('../../../database/connect.php');    
require('../../../database/query.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Khởi tạo bảng tính và trang tính
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Đặt tiêu đề cột
$headers = [
    'STT',
    'Mã sinh viên',
    'Họ và tên',
    'Loại phòng',
    'Phòng',
    'Ngày sinh',
    'Ngành',
    'Lớp',
    'Số điện thoại',
    'Email',
    'Quê quán',
];
foreach($headers as $index => $value){
    $sheet->setCellValue([$index+1, 1], $value);
}

// Truy vấn SQL
$sql_student =  "SELECT *
                FROM student s
                INNER JOIN contract c ON s.student_id = c.student_id
                INNER JOIN room r ON c.room_id = r.room_id
                INNER JOIN room_type rtype ON rtype.room_type_id = r.room_type_id
                INNER JOIN semester sem ON sem.semester_id = c.semester_id
                WHERE c.status = true AND sem.status = true ";
$student = queryResult($conn,$sql_student);

if ($student->num_rows > 0) {
    $rowNumber = 2; // Bắt đầu từ hàng thứ 2
    $stt = 1; // Số thứ tự
    while ($row = $student->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $stt++);
        $sheet->setCellValue('B' . $rowNumber, $row['number_student']);
        $sheet->setCellValue('C' . $rowNumber, $row['name']);
        $sheet->setCellValue('D' . $rowNumber, $row['room_type_name'] );
        $sheet->setCellValue('E' . $rowNumber, $row['room_name'] );
        $sheet->setCellValue('F' . $rowNumber, $row['birthday'] );
        $sheet->setCellValue('G' . $rowNumber, $row['major'] );
        $sheet->setCellValue('H' . $rowNumber, $row['classroom'] );
        $sheet->setCellValue('I' . $rowNumber, $row['phone'] );
        $sheet->setCellValue('J' . $rowNumber, $row['email'] );
        $sheet->setCellValue('K' . $rowNumber, $row['address'] );
        $rowNumber++;
    }
}

// Tự động điều chỉnh kích thước cột
foreach (range('A', 'K') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Tạo đối tượng Writer
$writer = new Xlsx($spreadsheet);

// Lưu file Excel vào một tệp tạm
$tempFile = tempnam(sys_get_temp_dir(), 'excel');
$writer->save($tempFile);

// Gửi file Excel về trình duyệt
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="file_' . time() . '.xlsx"');
readfile($tempFile);

// Xóa file tạm sau khi gửi xong
unlink($tempFile);

?>

