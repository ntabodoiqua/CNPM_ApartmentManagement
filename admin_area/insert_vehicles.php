<?php
include('../includes/connect.php');
if (isset($_POST['insert_vehicle'])) {
    $cccd = trim($_POST['cccd']);
    $vehicle_name = trim($_POST['vehicle_name']);
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_plate = trim($_POST['vehicle_plate']);

    if (empty($cccd) || empty($vehicle_name) || empty($vehicle_type) || empty($vehicle_plate)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!')</script>";
    } else {
        // Truy vấn để lấy resident_id từ bảng residents theo cccd
        $resident_query = "SELECT resident_id FROM residents WHERE resident_phone = '$cccd'";
        $resident_result = mysqli_query($con, $resident_query);
        
        if (mysqli_num_rows($resident_result) > 0) {
            // Nếu tìm thấy resident_id, lấy nó
            $resident_data = mysqli_fetch_assoc($resident_result);
            $resident_id = $resident_data['resident_id'];

            // Chèn thông tin vào bảng vehicles, bao gồm resident_id
            $insert_query = "INSERT INTO vehicles (resident_id, vehicle_name, vehicle_type, vehicle_plate) 
                             VALUES ($resident_id, '$vehicle_name', '$vehicle_type', '$vehicle_plate')";
            $result = mysqli_query($con, $insert_query);
            
            if ($result) {
                echo "<script>alert('Thông tin phương tiện được thêm thành công!')</script>";
                echo "<script>window.open('index.php', '_self')</script>";
            } else {
                echo "<script>alert('Đã xảy ra lỗi khi thêm phương tiện!')</script>";
            }
        } else {
            // Nếu không tìm thấy cccd trong bảng residents
            echo "<script>alert('Không tìm thấy người dân với cccd này!')</script>";
        }
    }
}
?>



</head>
<body class="bg-light">
<div class="container mt-3">
    <h3 class="text-center text-success my-4">Thêm phương tiện</h3>
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
                <td><label for="cccd">CCCD Chủ phương tiện</label></td>
                <td><input type="text" name="cccd" id="cccd" class="form-control" placeholder="Nhập CCCD" required></td>
            </tr>
            <tr>
                <td>Tên chủ phương tiện</td>
                <td><input type="text" name="name" id="name" class="form-control" placeholder="Tên sẽ tự động hiển thị" readonly></td>
            </tr>
            <tr>
                <td><label for="vehicle_name">Tên xe</label></td>
                <td><input type="text" name="vehicle_name" id="vehicle_name" class="form-control" placeholder="Nhập tên xe" required></td>
            </tr>
            <tr>
                        <td><label for="vehicle_type">Loại xe</label></td>
                        <td>
                            <select name="vehicle_type" id="vehicle_type" class="form-select">
                                <option value="Xe máy">Xe máy</option>
                                <option value="Oto">Oto</option>
                            </select>
                        </td>
            </tr>
            <tr>
                <td><label for="vehicle_plate">Biển số xe</label></td>
                <td><input type="text" name="vehicle_plate" id="vehicle_plate" class="form-control" placeholder="Nhập biển số" required></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="submit" name="insert_vehicle" class="btn btn-info px-4">Xác nhận</button>
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
                url: 'fetch_resident_phuongtien.php',
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


