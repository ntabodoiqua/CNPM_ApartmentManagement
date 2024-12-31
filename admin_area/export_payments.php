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
$query = "SELECT payments.*, apartments.apartment_name, apartments.apartment_num, fees.fee_name, type_fee.type_name, payments.amount_due, payments.amount_paid, payments.payment_date
FROM payments
INNER JOIN apartments ON payments.apartment_id = apartments.apartment_id
INNER JOIN fees ON payments.fee_id = fees.fee_id
INNER JOIN type_fee ON fees.type_id = type_fee.type_id";
$result = mysqli_query($con, $query);

// Tạo file Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Thiết lập tiêu đề cột
$sheet->setCellValue('A1', 'STT');
$sheet->setCellValue('B1', 'Tên hộ khẩu');
$sheet->setCellValue('C1', 'Số phòng');
$sheet->setCellValue('D1', 'Tên khoản thu');
$sheet->setCellValue('E1', 'Loại khoản thu');
$sheet->setCellValue('F1', 'Đơn giá');
$sheet->setCellValue('G1', 'Đã thanh toán');
$sheet->setCellValue('H1', 'Ngày thanh toán');
$sheet->setCellValue('I1', 'Trạng thái');

// Đổ dữ liệu vào bảng
$rowCount = 2;
$index = 1;

while ($row = mysqli_fetch_assoc($result)) {
    $status = $row['amount_due'] == $row['amount_paid'] ? 'Đã thanh toán' : 'Chưa thanh toán';
    $sheet->setCellValue("A$rowCount", $index++);
    $sheet->setCellValue("B$rowCount", $row['apartment_name']);
    $sheet->setCellValue("C$rowCount", $row['apartment_num']);
    $sheet->setCellValue("D$rowCount", $row['fee_name']);
    $sheet->setCellValue("E$rowCount", $row['type_name']);
    $sheet->setCellValue("F$rowCount", number_format($row['amount_due'], 0, '.', ','));
    $sheet->setCellValue("G$rowCount", number_format($row['amount_paid'], 0, '.', ','));
    $sheet->setCellValue("H$rowCount", $row['payment_date'] ?? 'N/A');
    $sheet->setCellValue("I$rowCount", $status);
    $rowCount++;
}

// Xuất file Excel
$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="thong_ke_thanh_toan.xlsx"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
