<?php
include('../includes/connect.php');

if (isset($_POST['insert_apartments'])) {
    $apartment_name = trim($_POST['apartment_name']); // Loại bỏ khoảng trắng
    $apartment_num = trim($_POST['apartment_num']); // Loại bỏ khoảng trắng
    $apartment_area = trim($_POST['apartment_area']); // Loại bỏ khoảng trắng
    $apartment_type = trim($_POST['apartment_type']); // Loại bỏ khoảng trắng
    // Kiểm tra tên căn hộ/hộ khẩu
    if (empty($apartment_name) || empty($apartment_area) || empty($apartment_type)) {
        echo "<script>alert('Vui lòng nhập đủ thông tin!')</script>";
    } else {
        // Kiểm tra xem căn hộ/hộ khẩu đã tồn tại hay chưa
        $select_query = "SELECT * FROM `apartments` WHERE apartment_name='$apartment_name'";
        $result_select = mysqli_query($con, $select_query);
        $number = mysqli_num_rows($result_select);

        if ($number > 0) {
            echo "<script>alert('Tên căn hộ/hộ khẩu đã tồn tại!')</script>";
        } else {
            // Thêm căn hộ/hộ khẩu vào database
            $insert_query = "INSERT INTO `apartments` (apartment_name, apartment_num, apartment_area, apartment_type) VALUES ('$apartment_name', $apartment_num, $apartment_area, '$apartment_type')";
            $result = mysqli_query($con, $insert_query);
            if ($result) {
                echo "<script>alert('Căn hộ/hộ khẩu được thêm thành công!')</script>";
                echo "<script>window.open('index.php', '_self')</script>";
            } else {
                echo "<script>alert('Đã xảy ra lỗi khi thêm căn hộ/hộ khẩu!')</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hộ khẩu - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
          crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
          integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4p889k5T5Ju8fs4b1P5z/iB4nMfSQ==" 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer" />
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h3 class="text-center text-success my-4">Thêm hộ khẩu/căn hộ</h3>
        <table class="table table-bordered table-hover table-striped mt-5">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Thông tin</th>
                    <th>Nhập dữ liệu</th>
                </tr>
            </thead>
            <tbody>
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- Tên hộ khẩu -->
                    <tr>
                        <td><label for="apartment_name">Tên hộ khẩu</label></td>
                        <td>
                            <input type="text" name="apartment_name" id="apartment_name" class="form-control" placeholder="Nhập tên hộ khẩu" required>
                        </td>
                    </tr>
                    <!-- Tên hộ khẩu -->
                    <tr>
                        <td><label for="apartment_num">Nhập số phòng căn hộ (biển số phòng)</label></td>
                        <td>
                            <input type="text" name="apartment_num" id="apartment_num" class="form-control" placeholder="Nhập số phòng" required>
                        </td>
                    </tr>
                    <!-- Diện tích căn hộ -->
                    <tr>
                        <td><label for="apartment_area">Diện tích căn hộ</label></td>
                        <td>
                            <input type="text" name="apartment_area" id="apartment_area" class="form-control" placeholder="Nhập diện tích căn hộ" required>
                        </td>
                    </tr>
                    <!-- Tên chủ hộ -->
                    <tr>
                        <td><label for="apartment_owner">Tên chủ hộ</label></td>
                        <td>
                            <input type="text" name="apartment_owner" id="apartment_owner" class="form-control" placeholder="Trường này hãy sửa tại tab xem hộ khẩu" readonly>
                        </td>
                    </tr>
                    <!-- Loại căn hộ -->
                    <tr>
                        <td><label for="apartment_type">Loại căn hộ</label></td>
                        <td>
                            <select name="apartment_type" id="apartment_type" class="form-select">
                                <option value="Penhouse">Penhouse</option>
                                <option value="Nhà thường">Nhà thường</option>
                            </select>
                        </td>
                    </tr>
                    <!-- Nút gửi -->
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" name="insert_apartments" class="btn btn-info px-4">Thêm hộ khẩu/căn hộ</button>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
</body>

</html>
