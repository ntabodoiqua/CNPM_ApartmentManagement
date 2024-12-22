<?php
include('../includes/connect.php'); // Kết nối database
if (isset($_POST['insert_fee'])) {
    $type_id = $_POST['type_fee'];
    $fee_name = $_POST['fee_name'];
    $additional_fee = isset($_POST['fee']) && !empty($_POST['fee']) ? $_POST['fee'] : 0; // Kiểm tra và gán giá trị khoản phí

    $start_date = date('Y-m-d', strtotime($_POST['start_date'])); // Định dạng lại ngày 
    $due_date = date('Y-m-d', strtotime($_POST['due_date'])); // Định dạng lại ngày

    // Xử lý ảnh
    $fee_image = $_FILES['fee_image']['name'];
    $temp_image = $_FILES['fee_image']['tmp_name'];

    // Kiểm tra các trường bắt buộc
    if ($type_id == '' || $fee_name == '' || $start_date == '' || $due_date == '' || $fee_image == '') {
        echo "<script>alert('Hãy điền hết các ô trống bắt buộc!')</script>";
        exit();
    }

    // Di chuyển ảnh vào thư mục
    move_uploaded_file($temp_image, "./fee_images/$fee_image");

    // Câu truy vấn chèn phí vào bảng `fees`
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

    // Nếu `additional_fee` là 0 (phí bắt buộc), tính phí dịch vụ chung cư
    if ($additional_fee == 0) {
        // Lấy danh sách các căn hộ
        $query_apartments = "SELECT apartment_id, apartment_area FROM apartments WHERE NOT curr_living = 0";
        $result_apartments = mysqli_query($con, $query_apartments);

        // Lấy mức phí từ bảng `type_fee`
        $query_type_fee = "SELECT type_rate FROM type_fee WHERE type_id = $type_id";
        $result_type_fee = mysqli_query($con, $query_type_fee);
        $row_type_fee = mysqli_fetch_assoc($result_type_fee);
        $type_rate = $row_type_fee['type_rate'];

        if (!$type_rate) {
            echo "<script>alert('Không tìm thấy mức phí tương ứng!')</script>";
            exit();
        }
        if ($type_id==1 || $type_id==2){    
            // Lặp qua từng căn hộ để tính phí
            while ($row_apartment = mysqli_fetch_assoc($result_apartments)) {
                $apartment_id = $row_apartment['apartment_id'];
                $apartment_area = $row_apartment['apartment_area'];
                $money = $type_rate * $apartment_area;

                // Cập nhật phí vào bảng `apartment_fees`
                $insert_apartment_fee = "
                    INSERT INTO apartment_fees (apartment_id, fee_id, money) 
                    VALUES ($apartment_id, $fee_id, $money)
                ";
                $result_insert = mysqli_query($con, $insert_apartment_fee);

                if (!$result_insert) {
                    echo "<script>alert('Có lỗi khi cập nhật phí cho căn hộ ID: $apartment_id')</script>";
                }

                // Cập nhật phí vào bảng `payments`
                $insert_payment = "
                    INSERT INTO payments (fee_id, apartment_id, amount_due, amount_paid, payment_date, status) 
                    VALUES ($fee_id, $apartment_id, $money, 0, NULL, 'Chưa thanh toán')
                ";
                $result_payment = mysqli_query($con, $insert_payment);

                if (!$result_payment) {
                    echo "<script>alert('Có lỗi khi cập nhật thanh toán cho căn hộ ID: $apartment_id')</script>";
                } else {
                    echo "<script>console.log('Thanh toán được cập nhật thành công cho căn hộ ID: $apartment_id')</script>";
                }
            }

            echo "<script>alert('Đã thêm khoản phí và cập nhật phí dịch vụ thành công!')</script>";
        }
        else if ($type_id == 5 || $type_id == 6) {
            // Tính phí gửi xe máy (type_id = 5) hoặc ô tô (type_id = 6)
            
            // Lấy mức phí từ bảng `type_fee` theo `type_id`
            $query_type_fee = "SELECT type_rate FROM type_fee WHERE type_id = $type_id";
            $result_type_fee = mysqli_query($con, $query_type_fee);
            $row_type_fee = mysqli_fetch_assoc($result_type_fee);
            $type_rate = $row_type_fee['type_rate'];
            if($type_id==5){
                $vehicle_type="Xe máy";
            }
            else {
                $vehicle_type="Oto";
            }
            // Đếm số xe máy hoặc ô tô của 1 căn hộ
            $query_vehicles = "
                SELECT COUNT(*) AS vehicle_count, apartment_id 
                FROM vehicles 
                join residents on vehicles.resident_id=residents.resident_id
                WHERE vehicle_type = '$vehicle_type' and (resident_status='Đang sống' or resident_status='Tạm trú')
                group by apartment_id;
            ";
            $result_vehicles = mysqli_query($con, $query_vehicles);

            $success_count = 0; // Biến đếm số căn hộ cập nhật thành công

            while($row_vehicles = mysqli_fetch_assoc($result_vehicles)){
                $money = $type_rate * $row_vehicles['vehicle_count'];
                $apartment_id = $row_vehicles['apartment_id'];
                
                // Cập nhật vào bảng `apartment_fees`
                $insert_apartment_fee = "
                    INSERT INTO apartment_fees (apartment_id, fee_id, money) 
                    VALUES ($apartment_id, $fee_id, $money)
                ";
                $result_insert = mysqli_query($con, $insert_apartment_fee);

                if (!$result_insert) {
                    echo "<script>alert('Có lỗi xảy ra khi cập nhật phí gửi xe cho căn hộ ID: $apartment_id')</script>";
                } else {
                    echo "<script>console.log('Gửi xe được cập nhật thành công cho căn hộ ID: $apartment_id')</script>";
                    $success_count++; // Tăng số lượng căn hộ thành công
                }

                // Cập nhật vào bảng `payments`
                $insert_payment = "
                    INSERT INTO payments (fee_id, apartment_id, amount_due, amount_paid, payment_date, status) 
                    VALUES ($fee_id, $apartment_id, $money, 0, NULL, 'Chưa thanh toán')
                ";
                $result_payment = mysqli_query($con, $insert_payment);

                if (!$result_payment) {
                    echo "<script>alert('Có lỗi khi cập nhật thanh toán cho căn hộ ID: $apartment_id')</script>";
                } else {
                    echo "<script>console.log('Thanh toán được cập nhật thành công cho căn hộ ID: $apartment_id')</script>";
                }
            }

            // Thông báo khi tất cả căn hộ đã được cập nhật thành công
            if ($success_count > 0) {
                echo "<script>alert('Cập nhật thành công cho $success_count căn hộ!')</script>";
            }
        }
           
    } else {
        // Lấy danh sách các căn hộ
        $query_apartments = "SELECT apartment_id, apartment_area FROM apartments WHERE NOT curr_living = 0";
        $result_apartments = mysqli_query($con, $query_apartments);
        // duyệt
        while ($row_apartment = mysqli_fetch_assoc($result_apartments)){
            $money = $additional_fee;
            $apartment_id = $row_apartment['apartment_id'];
            $insert_apartment_fee = "
                INSERT INTO apartment_fees (apartment_id, fee_id, money)
                VALUES ($apartment_id, $fee_id, $money)";
            $result_insert = mysqli_query($con, $insert_apartment_fee);
            if (!$result_insert){
                echo "<script>alert('Có lỗi xảy ra khi cập nhật phí cho căn hộ ID: $apartment_id')</script>";
            }
            $insert_payment = "
                    INSERT INTO payments (fee_id, apartment_id, amount_due, amount_paid, payment_date, status) 
                    VALUES ($fee_id, $apartment_id, $money, 0, NULL, 'Chưa thanh toán')
                ";
                $result_payment = mysqli_query($con, $insert_payment);
                if (!$result_payment) {
                    echo "<script>alert('Có lỗi khi cập nhật thanh toán cho căn hộ ID: $apartment_id')</script>";
                } else {
                    echo "<script>console.log('Thanh toán được cập nhật thành công cho căn hộ ID: $apartment_id')</script>";
                }
        }
        echo "<script>alert('Đã thêm thành công khoản phí!')</script>";
    }
} 
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân khẩu - Admin Dashboard</title>
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
    if (selectedType == '1' || selectedType == '2' || selectedType == '5' || selectedType == '6') {
        // Loại phí cố định -> ẩn trường và xóa thuộc tính required
        feeAmountInput.closest('tr').style.display = 'none';
        feeAmountInput.removeAttribute('required');
    } else {
        // Loại phí không cố định -> hiển thị trường và thêm thuộc tính required
        feeAmountInput.closest('tr').style.display = '';
        feeAmountInput.setAttribute('required', 'required');
    }
}

// Thêm sự kiện khi trang tải
window.onload = function() {
    var feeTypeSelect = document.getElementsByName('type_fee')[0];
    feeTypeSelect.addEventListener('change', checkFeeType);
    checkFeeType(); // Gọi lần đầu khi trang tải
};

    </script>
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h3 class="text-center text-success my-4">Thêm phí thu</h3>
        <table class="table table-bordered table-hover table-striped mt-5">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Thông tin</th>
                    <th>Nhập dữ liệu</th>
                </tr>
            </thead>
            <tbody>
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Tên người dân -->
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
                                    $type_rate=$row['type_rate'];
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
                        <td><input type="text" name="fee" id="fee" class="form-control" placeholder="Nhập khoản phí" required></td>
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
