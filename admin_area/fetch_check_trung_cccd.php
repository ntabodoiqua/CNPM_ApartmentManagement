<?php
include('../includes/connect.php'); // Kết nối database

if (isset($_POST['cccd'])) {
    $cccd = $_POST['cccd'];

    // Kiểm tra CCCD trong cơ sở dữ liệu
    $check_cccd_query = "SELECT * FROM `residents` WHERE resident_phone = '$cccd' and (resident_status = 'Đang sống' OR resident_status = 'Tạm trú' or resident_status = 'Tạm vắng')";
    $check_cccd_result = mysqli_query($con, $check_cccd_query);

    if (mysqli_num_rows($check_cccd_result) > 0) {
        echo "exists"; // Trả về "exists" nếu CCCD đã tồn tại
    } else {
        echo "not_exists"; // Trả về "not_exists" nếu CCCD chưa tồn tại
    }
}
if (isset($_POST['apartment_num'])) {
    $apartment_num = $_POST['apartment_num'];

    // Kiểm tra số phòng trong cơ sở dữ liệu
    $check_num_query = "SELECT * FROM `apartments` WHERE apartment_num = '$apartment_num' and (is_left = FALSE)";
    $check_num_result = mysqli_query($con, $check_num_query);

    if (mysqli_num_rows($check_num_result) > 0) {
        echo "exists"; // Trả về "exists" nếu so phong đã tồn tại
    } else {
        echo "not_exists"; // Trả về "not_exists" nếu so phong chưa tồn tại
    }
}

?>
