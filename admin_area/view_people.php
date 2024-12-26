<?php
// Kiểm tra giá trị của checkbox và trường tìm kiếm
$include_left = isset($_GET['include_left']); // Kiểm tra nếu checkbox được chọn
$search_data = isset($_GET['search_data']) ? mysqli_real_escape_string($con, trim($_GET['search_data'])) : '';

// Truy vấn tìm kiếm
$search_query = "
    SELECT r.*, a.apartment_name 
    FROM residents r 
    JOIN apartments a ON r.apartment_id = a.apartment_id 
    WHERE (r.resident_id LIKE '%$search_data%' 
    OR r.resident_name LIKE '%$search_data%' 
    OR a.apartment_name LIKE '%$search_data%')
";

// Nếu checkbox không được chọn, chỉ hiển thị người dân "Đang sống"
if (!$include_left) {
    $search_query .= " AND r.resident_status IN ('Đang sống', 'Tạm trú', 'Tạm vắng')";
}

$result = mysqli_query($con, $search_query);
?>
<a href="export_people.php" class="btn btn-success">Tải file Excel</a>
<!-- Hiển thị kết quả -->
<h3 class="text-center text-success my-4">Danh sách người dân</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>Mã người dân</th>
            <th>Tên hộ khẩu</th>
            <th>Tên người dân</th>
            <th>Ngày sinh</th>
            <th>Ảnh</th>
            <th>CCCD</th>
            <th>Quan hệ</th>
            <th>Trạng thái</th>
            <th>Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody class="bg-secondary text-light">
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='text-center'>
                    <td>{$row['resident_id']}</td>
                    <td>{$row['apartment_name']}</td>
                    <td>{$row['resident_name']}</td>
                    <td>{$row['resident_dob']}</td>
                    <td><img src='./people_images/{$row['resident_image']}' class='product_img rounded' alt='Ảnh người dân' style='width: 80px; height: auto;'></td>
                    <td>{$row['resident_phone']}</td>
                    <td>{$row['resident_relation_owner']}</td>
                    <td><span class='badge ".($row['resident_status'] === 'Đang sống' ? 'bg-success' : 'bg-danger')."'>{$row['resident_status']}</span></td>
                    <td><a href='index.php?edit_resident={$row['resident_id']}' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i> Sửa</a></td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='text-center text-warning'>Không có dữ liệu!</td></tr>";
        }
        ?>
    </tbody>
</table>
