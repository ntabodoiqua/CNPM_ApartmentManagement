<?php
include('../includes/connect.php');
if (isset($_POST['insert_resident_info'])) {
    $cccd = trim($_POST['cccd']);
    $lydo = trim($_POST['lydo']);
    $address = trim($_POST['address']);
    $start_date = date('Y-m-d', strtotime($_POST['start_date'])); // Định dạng lại start_date
    $end_date = date('Y-m-d', strtotime($_POST['end_date'])); // Định dạng lại end_date

    if (empty($cccd) || empty($lydo) || empty($address) || empty($start_date) || empty($end_date)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!')</script>";
    } else {
        // Truy vấn để lấy resident_id từ bảng residents theo cccd
        $resident_query = "SELECT resident_id FROM residents WHERE resident_phone = '$cccd' and resident_status='Đang sống'";
        $resident_result = mysqli_query($con, $resident_query);
        
        if (mysqli_num_rows($resident_result) > 0) {
            // Nếu tìm thấy resident_id, lấy nó
            $resident_data = mysqli_fetch_assoc($resident_result);
            $resident_id = $resident_data['resident_id'];

            // Chèn thông tin vào bảng tamvang, bao gồm resident_id
            $insert_query = "INSERT INTO tamvang (resident_id, cccd, lydo, tamvang_address, start_date, end_date) 
                             VALUES ('$resident_id', '$cccd', '$lydo', '$address', '$start_date', '$end_date')";
            $result = mysqli_query($con, $insert_query);
            
            if ($result) {
                // Cập nhật status trong bảng residents thành "Tạm vắng"
                $update_status_query = "UPDATE residents SET resident_status = 'Tạm vắng', resident_ngayden = NOW() WHERE resident_phone = '$cccd'";
                $update_status_result = mysqli_query($con, $update_status_query);
                // Cập nhật số người đang sống trong bảng apartments
                $update_apartment_query = "UPDATE apartments SET curr_living = curr_living - 1 WHERE apartment_id = (SELECT apartment_id FROM residents WHERE resident_phone = '$cccd')";
                $update_apartment_result = mysqli_query($con, $update_apartment_query);       
                if ($update_status_result) {
                    echo "<script>alert('Thông tin tạm vắng được thêm thành công và trạng thái người dân đã được cập nhật!')</script>";
                    echo "<script>window.open('index.php', '_self')</script>";
                } else {
                    echo "<script>alert('Đã xảy ra lỗi khi cập nhật trạng thái người dân trong bảng residents!')</script>";
                }
            } else {
                echo "<script>alert('Đã xảy ra lỗi khi thêm Tạm vắng!')</script>";
            }
        } else {
            // Nếu không tìm thấy cccd trong bảng residents
            echo "<script>alert('Không tìm thấy người dân với cccd này!')</script>";
        }
    }
}
?>

<body class="bg-light">
<div class="container mt-3">
    <h3 class="text-center text-success my-4">Khai báo tạm vắng</h3>
    <form action="" method="post" class="mx-auto" enctype="multipart/form-data">
        <table class="table table-bordered table-hover table-striped mt-3">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Thông tin</th>
                    <th>Nhập dữ liệu</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td><label for="cccd">CCCD Người tạm vắng</label></td>
                <td><input type="text" name="cccd" id="cccd" class="form-control" placeholder="Nhập CCCD" required></td>
            </tr>
            <tr>
                <td>Tên Người tạm vắng</td>
                <td><input type="text" name="name" id="name" class="form-control" placeholder="Tên sẽ tự động hiển thị" readonly></td>
            </tr>
            <tr>
                <td><label for="lydo">Lý do tạm vắng</label></td>
                <td><input type="text" name="lydo" id="lydo" class="form-control" placeholder="Nhập lý do" required></td>
            </tr>
            <tr>
                <td><label for="address">Địa chỉ tạm vắng</label></td>
                <td><input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ" required></td>
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
                    <button type="submit" name="insert_resident_info" class="btn btn-info px-4">Xác nhận</button>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#cccd').on('input', function() {
        let cccd = $(this).val();
        if (cccd.length >= 3) {
            $.ajax({
                url: 'fetch_resident.php',
                type: 'POST',
                data: { cccd: cccd },
                success: function(data) {
                    $('#name').val(data ? data : 'Không tìm thấy');
                },
                error: function() {
                    alert("Lỗi khi tìm kiếm dữ liệu.");
                }
            });
        } else {
            $('#name').val('');
        }
    });
});
</script>
</body>


