<?php
if (isset($_GET['delete_fees'])) {
    $delete_fees = $_GET['delete_fees'];
    
    // Xóa bản ghi liên quan trong bảng payments
    $delete_payments_query = "DELETE FROM `payments` WHERE fee_id = $delete_fees";
    $result_payments = mysqli_query($con, $delete_payments_query);

    // Xóa bản ghi liên quan trong bảng apartment_fees
    $delete_apartment_fees_query = "DELETE FROM `apartment_fees` WHERE fee_id = $delete_fees";
    $result_apartment_fees = mysqli_query($con, $delete_apartment_fees_query);

    // Xóa bản ghi trong bảng fees
    $delete_query_fee = "DELETE FROM `fees` WHERE fee_id = $delete_fees";
    $result_fee = mysqli_query($con, $delete_query_fee);

    // Kiểm tra kết quả
    if ($result_payments && $result_apartment_fees && $result_fee) {
        echo "<script>alert('Khoản phí và các dữ liệu liên quan đã được xóa thành công!')</script>";
        echo "<script>window.open('./index.php?view_fees', '_self')</script>";
    } else {
        echo "<script>alert('Xóa thất bại!')</script>";
        echo "<script>window.open('./index.php?view_fees', '_self')</script>";
    }
}
?>
