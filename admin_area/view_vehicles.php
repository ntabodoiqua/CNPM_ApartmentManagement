

<h3 class="text-center text-success my-4">Danh sách phương tiện</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Tên người dân</th>
            <th>Số CCCD</th>
            <th>Tên phương tiện</th>
            <th>Loại xe</th>
            <th>Biển số xe</th>
            <th>Trạng thái chủ xe</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include('../includes/connect.php'); // Kết nối cơ sở dữ liệu

    // Truy vấn để lấy thông tin phương tiện và cư dân
    $query_vehicles = "
        SELECT 
            v.vehicle_id,
            v.vehicle_name,
            v.vehicle_type,
            v.vehicle_plate,
            r.resident_name,
            r.resident_phone,
            r.resident_status
        FROM vehicles AS v
        JOIN residents AS r ON v.resident_id = r.resident_id
        ORDER BY r.resident_name, v.vehicle_type
    ";
    $result_vehicles = mysqli_query($con, $query_vehicles);

    if (mysqli_num_rows($result_vehicles) > 0) {
        $stt = 1;
        while ($row_vehicle = mysqli_fetch_assoc($result_vehicles)) {
            $vehicle_name = $row_vehicle['vehicle_name'];
            $vehicle_type = $row_vehicle['vehicle_type'];
            $vehicle_plate = $row_vehicle['vehicle_plate'];
            $resident_name = $row_vehicle['resident_name'];
            $resident_phone = $row_vehicle['resident_phone'];
            $resident_status = $row_vehicle['resident_status'];

            echo '<tr class="text-center">';
            echo "<td>$stt</td>";
            echo "<td>$resident_name</td>";
            echo "<td>$resident_phone</td>";
            echo "<td>$vehicle_name</td>";
            echo "<td>$vehicle_type</td>";
            echo "<td>$vehicle_plate</td>";
            echo "<td>$resident_status</td>";
            echo '</tr>';

            $stt++;
        }
    } else {
        echo '<tr>';
        echo '<td colspan="7" class="text-center text-warning">Không có phương tiện nào được tìm thấy!</td>';
        echo '</tr>';
    }
    ?>
</tbody>

</table>

<!-- Modal Xác nhận Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Bạn có chắc chắn muốn xóa hãng này?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><a href="./index.php?view_brands" class="text-decoration-none text-light">Không</a></button>
                <a href="#" id="confirmDeleteLink" class="btn btn-danger">Có</a>
            </div>
        </div>
    </div>
</div>

<!-- Thêm JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function () {
        $('.delete-btn').on('click', function () {
            var brandId = $(this).data('id');
            $('#confirmDeleteLink').attr('href', 'index.php?delete_brand=' + brandId);
            $('#deleteModal').modal('show');
        });
    });
</script>
