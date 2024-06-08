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
    'Mã hoá đơn',
    'Mã sinh viên',
    'Sinh viên',
    'Tiền phòng',
    'Tiền dịch vụ',
    'Tiền điện nước',
    'Thời gian',
    'Phương thức',
    'Tổng tiền',
];
foreach($headers as $index => $value){
    $sheet->setCellValue([$index+1, 1], $value);
}

$sql_hoadon = "SELECT * FROM payment p INNER JOIN student s ON s.student_id = p.student_id ORDER BY p.datetime DESC";
$hoadon = queryResult($conn,$sql_hoadon);

if ($hoadon->num_rows > 0) {
    $rowNumber = 2; // Bắt đầu từ hàng thứ 2
    $stt = 1; // Số thứ tự
    while ($row = $hoadon->fetch_assoc()) {
        $sheet->setCellValue('A' . $rowNumber, $stt++);
        $sheet->setCellValue('B' . $rowNumber, $row['payment_id']);
        $sheet->setCellValue('C' . $rowNumber, $row['number_student']);
        $sheet->setCellValue('D' . $rowNumber, $row['name']);
        $sheet->setCellValue('E' . $rowNumber, $row['contract_id'] != null ? 'X' : '');
        $sheet->setCellValue('F' . $rowNumber, $row['register_services_id'] != null ? 'X' : '');
        $sheet->setCellValue('G' . $rowNumber, $row['bill_id'] != null ? 'X' : '');
        $sheet->setCellValue('H' . $rowNumber, $row['datetime']);
        $sheet->setCellValue('I' . $rowNumber, $row['method']);
        $sheet->setCellValue('J' . $rowNumber, $row['total_price']);
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
$sheet->getColumnDimension('H')->setAutoSize(true);
$sheet->getColumnDimension('I')->setAutoSize(true);
$sheet->getColumnDimension('J')->setAutoSize(true);

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
