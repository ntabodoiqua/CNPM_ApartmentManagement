<?php
include('../includes/connect.php');
if (isset($_POST['insert_tamtru'])) {
    $tamtru_name = trim($_POST['name']);
    $tamtru_cccd = trim($_POST['CCCD']);
    $tamtru_dob = date('Y-m-d', strtotime($_POST['dob'])); // Định dạng lại ngày sinh
    $tamtru_email = trim($_POST['email']);
    $tamtru_lydo = trim($_POST['lydo']);
    $tamtru_thuongtru = trim($_POST['thuongtru_address']);
    $tamtru_apartment = $_POST['resident_apartment'];
    $tamtru_image = $_FILES['tamtru_image']['name'];
    $temp_image = $_FILES['tamtru_image']['tmp_name'];
    
    // Kiểm tra tên người
    if (empty($tamtru_name)) {
        echo "<script>alert('Vui lòng nhập đủ thông tin!')</script>";
    } else {
        // Kiểm tra xem người đã tồn tại hay chưa
        $select_query = "SELECT * FROM `residents` WHERE resident_phone='$tamtru_cccd'";
        $result_select = mysqli_query($con, $select_query);
        $number = mysqli_num_rows($result_select);

        if ($number > 0) {
            echo "<script>alert('Người dân đã tồn tại!')</script>";
        } else {
            move_uploaded_file($temp_image, "./people_images/$tamtru_image");
            $insert_query = "INSERT INTO `residents` (resident_name, resident_phone, resident_dob, resident_email, resident_image, apartment_id, resident_status, resident_relation_owner) 
                             VALUES ('$tamtru_name', '$tamtru_cccd', '$tamtru_dob', '$tamtru_email', '$tamtru_image', $tamtru_apartment, 'Tạm trú', 'Không có')";
            $result_insert = mysqli_query($con, $insert_query);
            if ($result_insert) {
                $resident_id = mysqli_insert_id($con); // Lấy resident_id vừa được chèn vào
            } else {
                echo "<script>alert('Đã xảy ra lỗi khi thêm người dân!')</script>";
                exit();
            }
        }
        
        // Thêm thông tin vào bảng tamtru với resident_id
        $start_date = date('Y-m-d', strtotime($_POST['start_date']));
        $end_date = date('Y-m-d', strtotime($_POST['end_date']));

        $insert_tamtru_query = "INSERT INTO `tamtru` (resident_id, lydo, tamtru_thuongtru, start_date, end_date) 
                                VALUES ('$resident_id', '$tamtru_lydo', '$tamtru_thuongtru', '$start_date', '$end_date')";
        $result_tamtru = mysqli_query($con, $insert_tamtru_query);

        // Tính toán số người đang sống
        $cal_num_living = "SELECT count(*) as curr_living from `residents` where apartment_id = $tamtru_apartment and (resident_status='Tạm trú' or resident_status='Đang sống')";
        $result_cal = mysqli_query($con, $cal_num_living);
        $row_cal = mysqli_fetch_assoc($result_cal);
        $curr_living = $row_cal['curr_living'];

        // Cập nhật số người đang sống vào bảng apartments
        $update_apartment = "UPDATE `apartments` SET `curr_living` = $curr_living WHERE `apartment_id` = $tamtru_apartment";
        mysqli_query($con, $update_apartment);

        if ($result_tamtru && $result_cal) {
            echo "<script>alert('Thông tin tạm trú đã được thêm thành công!')</script>";
            echo "<script>window.open('index.php', '_self')</script>";
        } else {
            echo "<script>alert('Đã xảy ra lỗi khi thêm thông tin tạm trú!')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tạm vắng - Admin Dashboard</title>
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
        <h3 class="text-center text-success my-4">Khai báo tạm trú</h3>
        <form action="" method="post" class="mx-auto" enctype="multipart/form-data" style="">
            <table class="table table-bordered table-hover table-striped mt-3">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>Thông tin</th>
                        <th>Nhập dữ liệu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><label for="name">Tên người tạm trú</label></td>
                        <td><input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên" required></td>
                    </tr>
                    <tr>
                        <td><label for="CCCD">Căn cước công dân người tạm trú</label></td>
                        <td><input type="text" name="CCCD" id="CCCD" class="form-control" placeholder="Nhập CCCD" required></td>
                    </tr>
                    <tr>
                        <td><label for="dob">Ngày sinh người tạm trú</label></td>
                        <td><input type="date" name="dob" id="dob" class="form-control" placeholder="Nhập ngày sinh" required></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email người tạm trú</label></td>
                        <td><input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required></td>
                    </tr>
                    <tr>
                        <td><label for="tamtru_image">Ảnh người tạm trú</label></td>
                        <td><input type="file" name="tamtru_image" id="tamtru_image" class="form-control" placeholder="Nhập email" required></td>
                    </tr>
                    <tr>
                        <td><label for="lydo">Lý do tạm trú</label></td>
                        <td><input type="text" name="lydo" id="lydo" class="form-control" placeholder="Nhập lý do" required></td>
                    </tr>
                    <tr>
                        <td><label for="thuongtru_address">Địa chỉ thường trú</label></td>
                        <td><input type="text" name="thuongtru_address" id="thuongtru_address" class="form-control" placeholder="Nhập địa chỉ" required></td>
                    </tr>
                    <tr>
                        <td>Địa chỉ tạm trú</td>
                        <td>
                            <select name="resident_apartment" class="form-select" required>
                                <option value="">Chọn địa chỉ (căn hộ)</option>
                                <?php
                                $select_query="select * from `apartments` where is_left=0";
                                $result_query=mysqli_query($con,$select_query);         
                                while($row=mysqli_fetch_assoc($result_query)){
                                    $apartment_name=$row['apartment_name'];
                                    $apartment_id=$row['apartment_id'];
                                    echo "<option value='$apartment_id'>$apartment_name</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="start_date">Ngày bắt đầu</label></td>
                        <td><input type="date" name="start_date" id="start_date" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label for="end_date">Ngày kết thúc</label></td>
                        <td><input type="date" name="end_date" id="end_date" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" name="insert_tamtru" class="btn btn-info px-4">Xác nhận</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</body>

</html>
