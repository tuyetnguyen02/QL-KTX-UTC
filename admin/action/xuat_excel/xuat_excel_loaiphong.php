<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../../vendor/autoload.php';
require('../../../database/connect.php');	
require('../../../database/query.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$headers = [
    'STT',
    'Loại phòng',
    'Máy lạnh',
    'Nấu ăn',
    'Số lượng tối đa',
    'Giá phòng',
    'TRạng thái hoạt động',
];
foreach($headers as $index => $value){
    $sheet->setCellValue([$index+1, 1], $value);
}

$sql_loaiphong = "SELECT * FROM room_type";
$loaiphong = queryResult($conn,$sql_loaiphong);

if ($loaiphong->num_rows > 0) {
    $rowNumber = 2; // Bắt đầu từ hàng thứ 2
    $stt = 1; // Số thứ tự
    while ($row = $loaiphong->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $stt++);
        $sheet->setCellValue('B' . $rowNumber, $row['room_type_name']);
        $sheet->setCellValue('C' . $rowNumber, $row['is_air_conditioned'] != false ? 'Có' : '');
        $sheet->setCellValue('D' . $rowNumber, $row['is_cooked'] != false ? 'Có' : '');
        $sheet->setCellValue('E' . $rowNumber, $row['max_quantity']);
        $sheet->setCellValue('F' . $rowNumber, $row['price']);
        $sheet->setCellValue('G' . $rowNumber, $row['enable'] != false ? 'Hoạt động tốt' : 'Đang sửa chữa');
        $rowNumber++;
    }
}
$sheet->getColumnDimension('A')->setAutoSize(true);
$sheet->getColumnDimension('B')->setAutoSize(true);
$sheet->getColumnDimension('C')->setAutoSize(true);
$sheet->getColumnDimension('D')->setAutoSize(true);
$sheet->getColumnDimension('E')->setAutoSize(true);
$sheet->getColumnDimension('F')->setAutoSize(true);
$sheet->getColumnDimension('G')->setAutoSize(true);

$writer = new Xlsx($spreadsheet);

// Lưu file Excel vào một tệp tạm
$tempFile = tempnam(sys_get_temp_dir(), 'excel');
$writer->save($tempFile);

// Gửi file Excel về trình duyệt
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename=file_' . time() . '.xlsx');
readfile($tempFile);

// Xóa file tạm sau khi gửi xong
unlink($tempFile);

?>
