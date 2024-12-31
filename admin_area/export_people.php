<?php
require '../vendor/autoload.php'; // Đảm bảo autoload được sử dụng

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Kết nối CSDL
$con = mysqli_connect("localhost", "root", "", "apartment_control");

// Kiểm tra kết nối
if (!$con) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Truy vấn dữ liệu
$query = "SELECT * FROM residents";
$result = mysqli_query($con, $query);

// Tạo file Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Thiết lập tiêu đề cột
$sheet->setCellValue('A1', 'STT');
$sheet->setCellValue('B1', 'Mã cư dân');
$sheet->setCellValue('C1', 'Họ tên');
$sheet->setCellValue('D1', 'CCCD');
$sheet->setCellValue('E1', 'Email');
$sheet->setCellValue('F1', 'Mã căn hộ');
$sheet->setCellValue('H1', 'Trạng thái');
$sheet->setCellValue('I1', 'Ngày đến');
$sheet->setCellValue('J1', 'Ngày đi');
$sheet->setCellValue('K1', 'Ngày sinh');
$sheet->setCellValue('L1', 'Quan hệ với chủ hộ');

// Đổ dữ liệu vào bảng
$rowCount = 2;
$index = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['resident_status'];
    $sheet->setCellValue("A$rowCount", $index++);
    $sheet->setCellValue("B$rowCount", $row['resident_id']);
    $sheet->setCellValue("C$rowCount", $row['resident_name']);
    $sheet->setCellValue("D$rowCount", $row['resident_phone']);
    $sheet->setCellValue("E$rowCount", $row['resident_email']);
    $sheet->setCellValue("F$rowCount", $row['apartment_id']);
    $sheet->setCellValue("H$rowCount", $status);
    $sheet->setCellValue("I$rowCount", $row['resident_ngayden'] ?? 'N/A');
    $sheet->setCellValue("J$rowCount", $row['resident_ngaydi'] ?? 'N/A');
    $sheet->setCellValue("K$rowCount", $row['resident_dob'] ?? 'N/A');
    $sheet->setCellValue("L$rowCount", $row['resident_relation_owner']);
    $rowCount++;
}

// Xuất file Excel
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="thong_tin_cu_dan.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
