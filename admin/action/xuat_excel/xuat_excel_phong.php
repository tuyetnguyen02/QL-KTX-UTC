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
    'Loại phòng',
    'Tên phòng',
    'Số lượng hiện tại',
    'Số lượng tối đa',
    'Giới tính',
    'Trạng thái',
];
foreach($headers as $index => $value){
    $sheet->setCellValue([$index+1, 1], $value);
}

// Truy vấn SQL
$sql_phong =    "SELECT r.*, rt.*, r.enable AS status 
                FROM room r 
                INNER JOIN room_type rt ON r.room_type_id = rt.room_type_id 
                GROUP BY r.room_id, rt.room_type_name 
                ORDER BY `r`.`room_type_id` ASC";
$phong = queryResult($conn,$sql_phong);

if ($phong->num_rows > 0) {
    $rowNumber = 2; // Bắt đầu từ hàng thứ 2
    $stt = 1; // Số thứ tự
    while ($row = $phong->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $stt++);
        $sheet->setCellValue('B' . $rowNumber, $row['room_type_name']);
        $sheet->setCellValue('C' . $rowNumber, $row['room_name']);
        $sheet->setCellValue('D' . $rowNumber, $row['current_quantity'] );
        $sheet->setCellValue('E' . $rowNumber, $row['max_quantity'] );
        $sheet->setCellValue('F' . $rowNumber, $row['room_gender'] ? 'Nữ' : 'Nam');
        $sheet->setCellValue('G' . $rowNumber, $row['status'] ? 'Hoạt động tốt' : 'Đang sửa chữa');
        $rowNumber++;
    }
}

// Tự động điều chỉnh kích thước cột
foreach (range('A', 'G') as $columnID) {
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

