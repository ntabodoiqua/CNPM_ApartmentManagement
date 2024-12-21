<?php
if(isset($_GET['edit_payment'])){
    $edit_payment=$_GET['edit_payment'];
    $get_payment="select * from `payments` where payment_id=$edit_payment";
    $result=mysqli_query($con,$get_payment);
    $row=mysqli_fetch_assoc($result);
    $payment_id=$row['payment_id']; 
    $fee_id=$row['fee_id'];
    $apartment_id=$row['apartment_id']; 
    $amount_due=$row['amount_due']; 
    $amount_paid=$row['amount_paid'];
    $need_to_pay=$amount_due-$amount_paid; 
    // Lấy tên hộ khẩu từ bảng `residents` dựa trên `apartment_id`
    $query_apartment = "SELECT apartment_name FROM apartments WHERE apartment_id = $apartment_id LIMIT 1";
    $result_apartment = mysqli_query($con, $query_apartment);
    $row_apartment = mysqli_fetch_assoc($result_apartment);
    $apartment_name = $row_apartment['apartment_name'];
    
    // Lấy tên khoản thu từ bảng `fees` dựa trên `fee_id`
    $query_fees = "SELECT fee_name FROM fees WHERE fee_id = $fee_id LIMIT 1";
    $result_fees = mysqli_query($con, $query_fees);
    $row_fees = mysqli_fetch_assoc($result_fees);
    $fee_name = $row_fees['fee_name'];
    
    // Lấy loại khoản thu từ bảng `type_fee` dựa trên `fee_id`
    $query_type_fee = "SELECT type_name FROM type_fee WHERE type_id = (SELECT type_id FROM fees WHERE fee_id = $fee_id) LIMIT 1";
    $result_type_fee = mysqli_query($con, $query_type_fee);
    $row_type_fee = mysqli_fetch_assoc($result_type_fee);
    $type_name = $row_type_fee['type_name'];
}

if(isset($_POST['edit_payment'])){
    $payment_amount=$_POST['payment_amount'];
    $update_query="update `payments` set amount_paid = amount_paid + $payment_amount, status='Thanh toán 1 phần'
                    where payment_id=$edit_payment";
    if($amount_paid+$payment_amount==$amount_due){
        $update_query_2="update `payments` set status='Đã thanh toán'
                    where payment_id=$edit_payment";
    }
    $result=mysqli_query($con, $update_query);
    if($result){
        echo "<script>alert('Thanh toán được cập nhật thành công!')</script>";
        echo "<script>window.open('./index.php?list_payments','_self')</script>";
    }
}
?>


<div class="container mt-3">
    <h1 class="text-center text-success">Xác nhận thanh toán</h1>
    <form action="" method="post" class="text-center" enctype="multipart/form-data" onsubmit="return validatePaymentOnSubmit()">
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="apartment_name" class="form-label">Tên hộ khẩu</label>
            <input type="text" name="apartment_name" id="apartment_name" class="form-control" value="<?php echo $apartment_name ?>" readonly>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="fee_name" class="form-label">Tên khoản thu</label>
            <input type="text" name="fee_name" id="fee_name" class="form-control" value="<?php echo $fee_name ?>" readonly>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="fee_type" class="form-label">Loại khoản thu</label>
            <input type="text" name="fee_type" id="fee_type" class="form-control" value="<?php echo $type_name ?>" readonly>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="fee_need_to_pay" class="form-label">Cần thanh toán</label>
            <input type="text" name="fee_need_to_pay" id="fee_need_to_pay" class="form-control" value="<?php echo number_format($need_to_pay,0,',','.') ?>" readonly>
        </div>
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="payment_amount" class="form-label">Nhập số tiền thanh toán (VNĐ)</label>
            <input type="text" name="payment_amount" id="payment_amount" class="form-control">
            <small id="paymentError" class="text-danger"></small>
        </div>
        <input type="submit" value="Cập nhật thanh toán" class="btn btn-info px-3" name="edit_payment">
    </form>
</div>

<script>
document.getElementById('payment_amount').addEventListener('input', validatePayment);

function validatePayment() {
    const needToPay = <?php echo $need_to_pay; ?>;
    const paymentAmountInput = document.getElementById('payment_amount');
    const errorElement = document.getElementById('paymentError');
    const paymentAmount = parseFloat(paymentAmountInput.value);

    if (isNaN(paymentAmount) || paymentAmount <= 0) {
        errorElement.textContent = "Số tiền thanh toán phải lớn hơn 0!";
        return false;
    }

    if (paymentAmount > needToPay) {
        errorElement.textContent = "Số tiền thanh toán không được lớn hơn số tiền cần thanh toán!";
        return false;
    }

    errorElement.textContent = ""; // Xóa thông báo lỗi nếu không có lỗi
    return true;
}

function validatePaymentOnSubmit() {
    return validatePayment(); // Kiểm tra lại khi nhấn nút gửi
}
</script>
