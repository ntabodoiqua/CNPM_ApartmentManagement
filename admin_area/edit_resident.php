<?php
include('../includes/connect.php'); // Kết nối database

// Lấy thông tin người dân cần chỉnh sửa dựa trên ID
if (isset($_GET['edit_resident'])) {
    $resident_id = $_GET['edit_resident'];
    $select_resident = "SELECT * FROM `residents` WHERE resident_id = '$resident_id'";
    $result = mysqli_query($con, $select_resident);
    $resident = mysqli_fetch_assoc($result);
}

// Xử lý cập nhật thông tin
if (isset($_POST['update_resident'])) {
    $resident_name = $_POST['resident_name'];
    $dob = date('Y-m-d', strtotime($_POST['dob'])); // Định dạng lại ngày sinh
    $resident_phone = $_POST['resident_phone'];
    $resident_email = $_POST['resident_email'];
    $resident_apartment = $_POST['resident_apartment'];
    $resident_relation_owner = $_POST['resident_relation_owner'];
    $resident_status = $_POST['resident_status'];

    // Xử lý ảnh (nếu có thay đổi)
    $resident_image = $_FILES['resident_image']['name'];
    $temp_image = $_FILES['resident_image']['tmp_name'];

    if (!empty($resident_image)) {
        move_uploaded_file($temp_image, "./people_images/$resident_image");
        $image_query = "resident_image = '$resident_image',";
    } else {
        $image_query = "";
    }

    // Câu truy vấn cập nhật thông tin cư dân
    $update_resident = "
        UPDATE `residents` 
        SET 
            resident_name = '$resident_name', 
            resident_dob = '$dob', 
            resident_phone = '$resident_phone', 
            resident_email = '$resident_email', 
            apartment_id = '$resident_apartment', 
            resident_relation_owner = '$resident_relation_owner', 
            $image_query
            resident_status = '$resident_status' 
        WHERE resident_id = '$resident_id'
    ";

    $result_update = mysqli_query($con, $update_resident);

    // Xử lý nếu người dân là chủ hộ
    if ($resident_relation_owner == "Chủ hộ") {
        $update_apartment = "
            UPDATE `apartments` 
            SET `owner_id` = '$resident_id' 
            WHERE `apartment_id` = '$resident_apartment'
        ";
        mysqli_query($con, $update_apartment);
    }

    if ($result_update) {
        echo "<script>alert('Cập nhật thông tin người dân thành công!');</script>";
        echo "<script>window.open('index.php','_self')</script>";
    } else {
        echo "<script>alert('Cập nhật thông tin thất bại!');</script>";
    }
}
?>


    <div class="container mt-3">
        <h3 class="text-center text-success my-4">Chỉnh sửa nhân khẩu</h3>
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
                        <td><input type="text" name="resident_name" id="resident_name" class="form-control" 
                                   value="<?php echo $resident['resident_name']; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="dob">Ngày sinh</label></td>
                        <td>
                            <input type="date" 
                                name="dob" 
                                id="dob" 
                                class="form-control" 
                                value="<?php echo date('Y-m-d', strtotime($resident['resident_dob'])); ?>" 
                                required>
                        </td>
                    </tr>
                                        <tr>
                        <td><label for="resident_phone">CCCD người dân</label></td>
                        <td><input type="text" name="resident_phone" id="resident_phone" class="form-control" 
                                   value="<?php echo $resident['resident_phone']; ?>" required></td>
                    </tr>
                    <tr>
                        <td><label for="resident_email">Email người dân (không có hãy nhập không)</label></td>
                        <td><input type="text" name="resident_email" id="resident_email" class="form-control" 
                                   value="<?php echo $resident['resident_email']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Chọn căn hộ</td>
                        <td>
                            <select name="resident_apartment" class="form-select" required>
                                <?php
                                $select_query = "SELECT * FROM `apartments`";
                                $result_query = mysqli_query($con, $select_query);
                                while ($row = mysqli_fetch_assoc($result_query)) {
                                    $apartment_name = $row['apartment_name'];
                                    $apartment_id = $row['apartment_id'];
                                    $selected = ($resident['apartment_id'] == $apartment_id) ? 'selected' : '';
                                    echo "<option value='$apartment_id' $selected>$apartment_name</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="resident_relation_owner">Quan hệ với chủ hộ</label></td>
                        <td><input type="text" name="resident_relation_owner" id="resident_relation_owner" class="form-control" 
                                   value="<?php echo $resident['resident_relation_owner']; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Ảnh người dân</td>
                        <td><input type="file" name="resident_image" id="resident_image" class="form-control">
                            <small>Ảnh hiện tại: <img src="./people_images/<?php echo $resident['resident_image']; ?>" alt="resident image" width="100"></small>
                        </td>
                    </tr>
                    <tr>
                        <td>Chọn trạng thái</td>
                        <td>
                            <select name="resident_status" class="form-select" required>
                                <option value="Đang sống">Đang sống</option>
                                <option value="Đã chuyển đi">Đã chuyển đi</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <input type="submit" name="update_resident" class="btn btn-success px-4" value="Cập nhật thông tin">
                            <a href="index.php?view_people" class="btn btn-secondary px-4">Hủy</a>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>
