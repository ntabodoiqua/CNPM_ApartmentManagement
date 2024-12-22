<?php
include('../includes/connect.php'); // Kết nối database
if(isset($_POST['insert_people'])){
    $resident_name=$_POST['resident_name'];
    $dob=$_POST['dob'];
    $dob = date('Y-m-d', strtotime($_POST['dob'])); // Định dạng lại ngày sinh
    $resident_phone=$_POST['resident_phone'];
    $resident_email=$_POST['resident_email'];
    $resident_apartment=$_POST['resident_apartment'];
    $resident_relation_owner=$_POST['resident_relation_owner'];
    $resident_status=$_POST['resident_status'];
    
    // Xử lý ảnh
    $resident_image=$_FILES['resident_image']['name'];
    $temp_image=$_FILES['resident_image']['tmp_name'];
    
    // Kiểm tra các trường trống
    if($resident_name =='' || $dob == '' || $resident_phone == '' || $resident_email == '' || 
    $resident_apartment == '' || $resident_relation_owner == '' || $resident_image == '' || $resident_status == ''){
        echo "<script>alert('Hãy điền hết các ô trống!')</script>";
        exit();
    } else {
        // Di chuyển ảnh vào thư mục
        move_uploaded_file($temp_image, "./people_images/$resident_image");

        // Câu truy vấn thêm cư dân vào bảng `residents`
        $insert_people = "
        INSERT INTO `residents` (resident_name, resident_dob, resident_phone, resident_email, apartment_id, 
                                 resident_relation_owner, resident_status, resident_image) 
        VALUES ('$resident_name', '$dob', '$resident_phone', '$resident_email', '$resident_apartment', 
                '$resident_relation_owner', '$resident_status', '$resident_image')
        ";
        $result_query = mysqli_query($con, $insert_people);

        // Lấy `resident_id` của người dân vừa thêm vào
        $resident_id = mysqli_insert_id($con);
        
        // Nếu người dân là "Chủ hộ", thực hiện thêm vào bảng `apartment_owner` và cập nhật `owner_id` trong bảng `apartments`
        if($resident_relation_owner == "Chủ hộ") {
            // Thêm vào bảng `apartment_owner`

            
            // Cập nhật trường `owner_id` trong bảng `apartments`
            $update_apartment = "
            UPDATE `apartments` 
            SET `owner_id` = '$resident_id' 
            WHERE `apartment_id` = '$resident_apartment'
            ";
            $result_update_apartment = mysqli_query($con, $update_apartment);

            if ($result_update_apartment) {
                echo "<script>alert('Đã thêm thành công người dân và cập nhật chủ hộ!')</script>";
            } else {
                echo "<script>alert('Lỗi khi cập nhật thông tin chủ hộ!')</script>";
            }
        } else {
            echo "<script>alert('Đã thêm thành công người dân!')</script>";
        }

        // Kiểm tra nếu truy vấn thêm thành công, chuyển hướng về trang danh sách
        if($result_query){
            echo "<script>window.open('index.php','_self')</script>";
        }
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
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h3 class="text-center text-success my-4">Thêm nhân khẩu</h3>
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
                        <td><label for="resident_name">Tên người dân</label></td>
                        <td><input type="text" name="resident_name" id="resident_name" class="form-control" placeholder="Nhập tên người dân" required></td>
                    </tr>
                    <tr>
                        <td><label for="dob">Ngày sinh</label></td>
                        <td><input type="date" name="dob" id="dob" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label for="resident_phone">CCCD người dân</label></td>
                        <td><input type="text" name="resident_phone" id="resident_phone" class="form-control" placeholder="Nhập CCCD người dân" required></td>
                    </tr>
                    <tr>
                        <td><label for="resident_email">Email người dân (không có hãy nhập không)</label></td>
                        <td><input type="text" name="resident_email" id="resident_email" class="form-control" placeholder="Nhập email" required></td>
                    </tr>
                    <tr>
                        <td>Chọn căn hộ</td>
                        <td>
                            <select name="resident_apartment" class="form-select" required>
                                <option value="">Chọn hộ khẩu</option>
                                <?php
                                $select_query="select * from `apartments`";
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
                        <td><label for="resident_relation_owner">Quan hệ với chủ hộ (nếu là chủ hộ, nhập chủ hộ)</label></td>
                        <td><input type="text" name="resident_relation_owner" id="resident_relation_owner" class="form-control" placeholder="Nhập quan hệ" required></td>
                    </tr>
                    <tr>
                        <td>Ảnh người dân</td>
                        <td><input type="file" name="resident_image" id="resident_image" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td>Chọn trạng thái</td>
                        <td>
                            <select name="resident_status" class="form-select" required>
                                <option value="Đang sống">Đang sống</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <input type="submit" name="insert_people" class="btn btn-info px-4" value="Thêm người dân">
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
</body>
</html>
