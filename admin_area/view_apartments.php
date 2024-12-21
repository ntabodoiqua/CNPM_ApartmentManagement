<?php
// Kết nối cơ sở dữ liệu
include('../includes/connect.php');

// Kiểm tra xem có yêu cầu tìm kiếm hay không
if (isset($_GET['search_submit'])) {
    $search_data = mysqli_real_escape_string($con, trim($_GET['search_data']));

    // Truy vấn tìm kiếm theo mã hộ khẩu, tên hộ khẩu, tên chủ hộ khẩu hoặc số phòng
    $search_query = "
    SELECT a.*, r.resident_name, r.resident_relation_owner
    FROM apartments a
    left JOIN residents r ON a.owner_id = r.resident_id
    WHERE a.apartment_id LIKE '%$search_data%' 
    OR a.apartment_name LIKE '%$search_data%' 
    OR r.resident_name LIKE '%$search_data%' 
    OR r.resident_relation_owner LIKE '%$search_data%' 
    OR a.apartment_num LIKE '%$search_data%'  -- Thêm điều kiện tìm kiếm theo số phòng
    ";
} else {
    // Nếu không có tìm kiếm, hiển thị toàn bộ thông tin
    $search_query = "
    SELECT a.*, r.resident_name, r.resident_relation_owner
    FROM apartments a
    left JOIN residents r ON a.owner_id = r.resident_id
    ";
}

$result = mysqli_query($con, $search_query);
?>



<!-- Hiển thị danh sách hộ khẩu -->
<h3 class="text-center text-success my-4">Danh sách hộ khẩu</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>Mã hộ khẩu</th>
            <th>Tên hộ khẩu</th>
            <th>Số phòng</th>
            <th>Diện tích</th>
            <th>Tên chủ hộ</th>
            <th>Loại căn hộ</th>
            <th>Chỉnh sửa</th>
            <th>Xóa</th>
        </tr>
    </thead>
    <tbody class="bg-secondary text-light">
        <?php
        // Kiểm tra nếu có kết quả từ cơ sở dữ liệu
        if (mysqli_num_rows($result) > 0) {
            // Duyệt qua từng kết quả và hiển thị
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='text-center'>
                    <td>{$row['apartment_id']}</td>
                    <td>{$row['apartment_name']}</td>
                    <td>{$row['apartment_num']}</td>
                    <td>{$row['apartment_area']}</td>
                    <td>{$row['resident_name']}</td>
                    <td>{$row['apartment_type']}</td>
                    <td><a href='index.php?edit_apartment={$row['apartment_id']}' class='btn btn-sm btn-warning'><i class='fa-solid fa-pen-to-square'></i> Sửa</a></td>
                    <td><a href='index.php?delete_apartment={$row['apartment_id']}' class='btn btn-sm btn-danger'><i class='fa-solid fa-trash'></i> Xóa</a></td>
                </tr>";
            }
        } else {
            // Nếu không có kết quả, hiển thị thông báo không có dữ liệu
            echo "<tr><td colspan='8' class='text-center text-warning'>Không có dữ liệu!</td></tr>";
        }
        ?>
    </tbody>
</table>
