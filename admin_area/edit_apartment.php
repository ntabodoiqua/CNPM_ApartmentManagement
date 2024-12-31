<?php

// Kiểm tra nếu có ID căn hộ được truyền vào
if (!isset($_GET['edit_apartment'])) {
    die("Không tìm thấy căn hộ cần chỉnh sửa!");
}

$apartment_id = $_GET['edit_apartment'];

// Lấy thông tin căn hộ hiện tại
$apartment_query = "SELECT * FROM apartments WHERE apartment_id = ?";
$stmt = $con->prepare($apartment_query);
$stmt->bind_param("i", $apartment_id);
$stmt->execute();
$apartment_result = $stmt->get_result();
$apartment = $apartment_result->fetch_assoc();

if (!$apartment) {
    die("Căn hộ không tồn tại!");
}

// Xử lý cập nhật thông tin chủ hộ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_owner'])) {
    $owner_id = $_POST['owner_id']; // ID người dân được chọn làm chủ hộ
    $apartment_id = $_POST['apartment_id']; // ID căn hộ hiện tại

    // Cập nhật thông tin chủ hộ trong bảng `apartments`
    $update_apartment_query = "UPDATE apartments SET owner_id = ? WHERE apartment_id = ?";
    $stmt_apartment = $con->prepare($update_apartment_query);
    $stmt_apartment->bind_param("ii", $owner_id, $apartment_id);

    if ($stmt_apartment->execute()) {
        // Cập nhật `resident_relation_owner` thành "Chủ hộ" trong bảng `residents`
        $update_resident_query = "UPDATE residents SET resident_relation_owner = 'Chủ hộ' WHERE resident_id = ?";
        $stmt_resident = $con->prepare($update_resident_query);
        $stmt_resident->bind_param("i", $owner_id);

        if ($stmt_resident->execute()) {
            echo "<script>alert('Cập nhật thông tin thành công! Hãy sửa lại thông tin quan hệ của chủ hộ cũ');</script>";
            echo "<script>window.location.href = 'index.php?view_people';</script>";
            exit;
        } else {
            echo "<script>alert('Đã xảy ra lỗi khi cập nhật quan hệ với chủ hộ!');</script>";
        }
    } else {
        echo "<script>alert('Đã xảy ra lỗi khi cập nhật thông tin chủ hộ!');</script>";
    }
}

// Xử lý xóa căn hộ
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_apartment'])) {
    // Chuyển trạng thái của tất cả cư dân trong căn hộ và cập nhật ngày đi
    $update_residents_query = "
        UPDATE residents 
        SET resident_status = 'Đã chuyển đi', resident_ngaydi = NOW() 
        WHERE apartment_id = ?";
    $stmt_residents = $con->prepare($update_residents_query);
    $stmt_residents->bind_param("i", $apartment_id);

    if ($stmt_residents->execute()) {
        // Đánh dấu căn hộ là đã rời đi
        $delete_apartment_query = "UPDATE apartments SET is_left = TRUE, curr_living = 0, owner_id = NULL, apartment_ngayroi = NOW() WHERE apartment_id = ?";
        $stmt_delete_apartment = $con->prepare($delete_apartment_query);
        $stmt_delete_apartment->bind_param("i", $apartment_id);

        if ($stmt_delete_apartment->execute()) {
            echo "<script>alert('Căn hộ đã được xóa thành công!');</script>";
            echo "<script>window.location.href = 'index.php?view_apartments';</script>";
            exit;
        } else {
            echo "<script>alert('Đã xảy ra lỗi khi xóa căn hộ!');</script>";
        }
    } else {
        echo "<script>alert('Đã xảy ra lỗi khi cập nhật trạng thái cư dân!');</script>";
    }
}


// Lấy danh sách các thành viên trong căn hộ
$members_query = "
    SELECT residents.resident_id, residents.resident_name 
    FROM `residents` 
    WHERE residents.apartment_id = ? and resident_status='Đang sống'";
$stmt = $con->prepare($members_query);
$stmt->bind_param("i", $apartment_id);
$stmt->execute();
$members_result = $stmt->get_result();

?>

<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light text-center">
            <h3 class="text-success mb-0">Chỉnh sửa thông tin chủ hộ</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group mb-4">
                    <label for="apartment_name" class="form-label">Tên căn hộ</label>
                    <input type="text" class="form-control bg-light" id="apartment_name" name="apartment_name" 
                           value="<?php echo $apartment['apartment_name']; ?>" disabled>
                </div>

                <div class="form-group mb-4">
                    <label for="owner_id" class="form-label">Chọn chủ hộ</label>
                    <select class="form-control" id="owner_id" name="owner_id" required>
                        <option value="">-- Chọn thành viên --</option>
                        <?php while ($member = $members_result->fetch_assoc()): ?>
                            <option value="<?php echo $member['resident_id']; ?>" 
                                <?php echo ($apartment['owner_id'] == $member['resident_id']) ? 'selected' : ''; ?>>
                                <?php echo $member['resident_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group text-center">
                    <button type="submit" name="update_owner" class="btn btn-success px-4">Cập nhật</button>
                    <button type="submit" name="delete_apartment" class="btn btn-danger px-4" 
                            onclick="return confirm('Bạn có chắc chắn muốn xóa căn hộ này không?')">Xóa căn hộ</button>
                    <a href="index.php?view_apartments" class="btn btn-secondary px-4">Hủy</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Nhớ thêm liên kết FontAwesome để biểu tượng hiển thị đúng -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
