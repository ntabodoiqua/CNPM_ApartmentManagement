<?php
// Kết nối cơ sở dữ liệu
include('../includes/connect.php');

// Kiểm tra xem type_id có được truyền qua URL hay không
if (isset($_GET['edit_fee_type'])) {
    $type_id = intval($_GET['edit_fee_type']);

    // Lấy thông tin loại khoản thu dựa trên type_id
    $query = "SELECT * FROM `type_fee` WHERE type_id = $type_id";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);

    // Nếu không tìm thấy loại khoản thu
    if (!$row) {
        echo "<div class='alert alert-danger'>Không tìm thấy loại khoản thu!</div>";
        exit;
    }

    // Lấy dữ liệu loại khoản thu
    $type_name = $row['type_name'];
    $type_rate = $row['type_rate'];

    // Xử lý khi form được gửi
    if (isset($_POST['update_fee_type'])) {
        $new_rate = floatval($_POST['new_rate']);

        // Cập nhật mức giá mới
        $update_query = "UPDATE `type_fee` SET type_rate = $new_rate WHERE type_id = $type_id";
        $result_update = mysqli_query($con, $update_query);

        // Kiểm tra và phản hồi
        if ($result_update) {
            echo "<script>alert('Cập nhật mức giá thành công!');</script>";
            echo "<script>window.location.href = 'index.php';</script>"; // Quay lại trang danh sách
            exit;
        } else {
            echo "<div class='alert alert-danger'>Có lỗi xảy ra khi cập nhật mức giá!</div>";
        }
    }
} else {
    echo "<div class='alert alert-danger'>Không có ID loại khoản thu được cung cấp!</div>";
    exit;
}
?>

<!-- Giao diện chỉnh sửa mức giá -->
<h3 class="text-center text-success my-4">Chỉnh sửa mức giá</h3>
<div class="container">
    <form method="POST" class="border p-4 bg-light shadow">
        <div class="mb-3">
            <label for="type_name" class="form-label">Tên loại khoản thu</label>
            <input type="text" class="form-control" id="type_name" value="<?php echo $type_name; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="new_rate" class="form-label">Mức giá mới (VNĐ)</label>
            <input type="number" class="form-control" id="new_rate" name="new_rate" value="<?php echo $type_rate; ?>" required>
        </div>
        <div class="text-center">
            <button type="submit" name="update_fee_type" class="btn btn-success">Cập nhật</button>
            <a href="index.php" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>
