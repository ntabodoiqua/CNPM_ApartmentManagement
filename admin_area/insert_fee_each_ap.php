<?php
include('../includes/connect.php'); // Kết nối database

if (isset($_POST['insert_fee'])) {
    // Lấy dữ liệu từ form
    $type_id = $_POST['type_fee'];
    $fee_name = $_POST['fee_name'];
    $additional_fee = isset($_POST['fee']) && !empty($_POST['fee']) ? $_POST['fee'] : 0; // Giá trị khoản phí
    $apartment_id = $_POST['apartment_id']; // ID căn hộ được chọn

    $start_date = date('Y-m-d', strtotime($_POST['start_date'])); // Định dạng ngày bắt đầu
    $due_date = date('Y-m-d', strtotime($_POST['due_date'])); // Định dạng ngày kết thúc

    // Xử lý ảnh
    $fee_image = $_FILES['fee_image']['name'];
    $temp_image = $_FILES['fee_image']['tmp_name'];

    // Kiểm tra các trường bắt buộc
    if ($type_id == '' || $fee_name == '' || $start_date == '' || $due_date == '' || $fee_image == '' || $apartment_id == '') {
        echo "<script>alert('Hãy điền hết các ô trống bắt buộc!')</script>";
        exit();
    }

    // Di chuyển ảnh vào thư mục
    if (!move_uploaded_file($temp_image, "./fee_images/$fee_image")) {
        echo "<script>alert('Không thể tải ảnh lên!')</script>";
        exit();
    }

    // Chèn phí vào bảng `fees`
    $insert_fee = "
        INSERT INTO `fees` (type_id, fee_additional_amount, fee_name, fee_image, fee_start_date, fee_due_date) 
        VALUES ($type_id, $additional_fee, '$fee_name', '$fee_image', '$start_date', '$due_date')
    ";
    $result_query = mysqli_query($con, $insert_fee);

    if (!$result_query) {
        echo "<script>alert('Có lỗi khi thêm khoản phí!')</script>";
        exit();
    }

    // Lấy `fee_id` của khoản phí vừa thêm
    $fee_id = mysqli_insert_id($con);

    // Tính toán và cập nhật phí cho căn hộ có mã `$apartment_id`
    $money = $additional_fee;

    // Nếu `additional_fee` = 0, tính phí dựa trên loại phí
    if ($additional_fee == 0) {
        $query_type_fee = "SELECT type_rate FROM type_fee WHERE type_id = $type_id";
        $result_type_fee = mysqli_query($con, $query_type_fee);
        $row_type_fee = mysqli_fetch_assoc($result_type_fee);

        if (!$row_type_fee) {
            echo "<script>alert('Không tìm thấy loại phí phù hợp!')</script>";
            exit();
        }

        $type_rate = $row_type_fee['type_rate'];

        // Lấy diện tích căn hộ để tính phí
        $query_apartment = "SELECT apartment_area FROM apartments WHERE apartment_id = $apartment_id";
        $result_apartment = mysqli_query($con, $query_apartment);
        $row_apartment = mysqli_fetch_assoc($result_apartment);

        if (!$row_apartment) {
            echo "<script>alert('Không tìm thấy căn hộ với mã $apartment_id!')</script>";
            exit();
        }

        $apartment_area = $row_apartment['apartment_area'];
        $money = $type_rate * $apartment_area;
    }

    // Chèn phí vào bảng `apartment_fees`
    $insert_apartment_fee = "
        INSERT INTO apartment_fees (apartment_id, fee_id, money) 
        VALUES ($apartment_id, $fee_id, $money)
    ";
    $result_insert = mysqli_query($con, $insert_apartment_fee);

    if (!$result_insert) {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật phí cho căn hộ ID: $apartment_id')</script>";
        exit();
    }

    // Chèn phí vào bảng `payments`
    $insert_payment = "
        INSERT INTO payments (fee_id, apartment_id, amount_due, amount_paid, payment_date, status) 
        VALUES ($fee_id, $apartment_id, $money, 0, NULL, 'Chưa thanh toán')
    ";
    $result_payment = mysqli_query($con, $insert_payment);

    if (!$result_payment) {
        echo "<script>alert('Có lỗi khi cập nhật thanh toán cho căn hộ ID: $apartment_id')</script>";
    } else {
        echo "<script>alert('Đã thêm thành công khoản phí cho căn hộ ID: $apartment_id!')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phí cho từng căn hộ - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
    crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
    integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" 
    crossorigin="anonymous" 
    referrerpolicy="no-referrer" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../style.css">
    <script>
        function checkFeeType() {
    var feeTypeSelect = document.getElementsByName('type_fee')[0];
    var feeAmountInput = document.getElementById('fee');
    var selectedType = feeTypeSelect.value;

    // Kiểm tra loại phí
    if (selectedType === '3' || selectedType === '4') {
        // Loại phí cần nhập số tiền -> hiển thị trường và thêm thuộc tính required
        feeAmountInput.closest('tr').style.display = '';
        feeAmountInput.setAttribute('required', 'required');
    } else {
        // Loại phí không cần nhập số tiền -> ẩn trường và xóa thuộc tính required
        feeAmountInput.closest('tr').style.display = 'none';
        feeAmountInput.removeAttribute('required');
    }
}

// Thêm sự kiện khi trang tải
window.onload = function () {
    var feeTypeSelect = document.getElementsByName('type_fee')[0];
    feeTypeSelect.addEventListener('change', checkFeeType);
    checkFeeType(); // Gọi lần đầu khi trang tải
};

document.addEventListener('DOMContentLoaded', function () {
    var feeInput = document.getElementById('fee');
    var feeError = document.getElementById('fee-error');
    var form = document.querySelector('form');

    // Kiểm tra khi người dùng thay đổi giá trị
    feeInput.addEventListener('input', function () {
        validateFee();
    });

    // Kiểm tra khi gửi biểu mẫu
    form.addEventListener('submit', function (e) {
        var feeTypeSelect = document.getElementsByName('type_fee')[0];
        var selectedType = feeTypeSelect.value;

        // Chỉ kiểm tra phí nếu loại phí là 3 hoặc 4
        if ((selectedType === '3' || selectedType === '4') && !validateFee()) {
            e.preventDefault(); // Ngăn gửi biểu mẫu nếu không hợp lệ
        }
    });

    function validateFee() {
        var feeValue = feeInput.value;

        if (feeValue === '' || !Number.isInteger(Number(feeValue)) || Number(feeValue) <= 0) {
            feeError.style.display = 'block';
            feeError.textContent = 'Vui lòng nhập một số nguyên dương hợp lệ.';
            return false;
        } else {
            feeError.style.display = 'none';
            feeError.textContent = '';
            return true;
        }
    }
});


    </script>
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h3 class="text-center text-success my-4">Thêm phí cho từng căn hộ</h3>
        <table class="table table-bordered table-hover table-striped mt-5">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Thông tin</th>
                    <th>Nhập dữ liệu</th>
                </tr>
            </thead>
            <tbody>
                <form action="" method="post" enctype="multipart/form-data">
                    <tr>
                        <td>Chọn loại phí</td>
                        <td>
                            <select name="type_fee" class="form-select" required>
                                <option value="">Chọn loại phí</option>
                                <?php
                                $select_query="select * from `type_fee`";
                                $result_query=mysqli_query($con,$select_query);         
                                while($row=mysqli_fetch_assoc($result_query)){
                                    $type_name=$row['type_name'];
                                    $type_id=$row['type_id'];
                                    echo "<option value='$type_id'>$type_name</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="fee_name">Tên khoản phí</label></td>
                        <td><input type="text" name="fee_name" id="fee_name" class="form-control" placeholder="Nhập tên khoản phí" required></td>
                    </tr>
                    <tr>
                        <td><label for="fee_image">Ảnh khoản phí</label></td>
                        <td><input type="file" name="fee_image" id="fee_image" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label for="fee">Khoản phí (với các loại phí không cố định)</label></td>
                        <td>
                            <input type="text" name="fee" id="fee" class="form-control" placeholder="Nhập khoản phí">
                            <span id="fee-error" class="text-danger" style="display: none; font-size: 0.9em;"></span>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="start_date">Ngày bắt đầu</label></td>
                        <td><input type="date" name="start_date" id="start_date" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label for="due_date">Ngày hết hạn</label></td>
                        <td><input type="date" name="due_date" id="due_date" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Chọn căn hộ</td>
                        <td>
                        <select name="apartment_id" class="form-select" required>
                            <option value="">Chọn căn hộ</option>
                            <?php
                            $select_apartments = "SELECT apartment_id, apartment_name FROM apartments WHERE NOT curr_living = 0";
                            $result_apartments = mysqli_query($con, $select_apartments);
                            while ($row = mysqli_fetch_assoc($result_apartments)) {
                                $apartment_id = $row['apartment_id'];
                                $apartment_name = $row['apartment_name'];
                                echo "<option value='$apartment_id'>$apartment_name</option>";
                            }
                            ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <input type="submit" name="insert_fee" class="btn btn-info px-4" value="Thêm khoản phí">
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
</body>
</html>
