<h3 class="text-center text-success my-4">Danh sách khoản phí đã đăng</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Tên khoản phí</th>
            <th>Ảnh khoản phí</th>
            <th>Tiền cần đóng</th>
            <th>Lịch bắt đầu</th>
            <th>Lịch hết hạn</th>
            <th>Xóa khoản phí</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include('../includes/connect.php'); // Kết nối cơ sở dữ liệu

    // Truy vấn để lấy thông tin phí
    $query_fees = "select * from `fees`";
    $result_fees = mysqli_query($con, $query_fees);
    if (mysqli_num_rows($result_fees) > 0) {
        $stt = 1;
        while ($row_fee = mysqli_fetch_assoc($result_fees)) {
            $fee_name = $row_fee['fee_name'];
            $fee_image = $row_fee['fee_image'];
            if(empty($row_fee['fee_additional_amount'])){
                $fee_additional_amount="Tính theo từng hộ";
            } else {
                $fee_additional_amount = $row_fee['fee_additional_amount'];
            }
            
            $fee_start_date = $row_fee['fee_start_date'];
            $fee_due_date = $row_fee['fee_due_date'];
            $fee_id = $row_fee['fee_id'];

            echo '<tr class="text-center">';
            echo "<td>$stt</td>";
            echo "<td>$fee_name</td>";
            echo "<td><img src='fee_images/$fee_image' alt='Ảnh khoản phí' class='product_img rounded' style='width: 80px; height: auto;'></td>";
            echo "<td>$fee_additional_amount</td>";
            echo "<td>$fee_start_date</td>";
            echo "<td>$fee_due_date</td>";
            echo "<td><button class='btn btn-sm btn-danger delete-btn' data-id=$fee_id>
                    <i class='fa-solid fa-trash'></i> Xóa
                </button></td>";
            echo '</tr>';

            $stt++;
        }
    } else {
        echo '<tr>';
        echo '<td colspan="7" class="text-center text-warning">Không có loại phí nào được tìm thấy!</td>';
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
                <h4>Bạn có chắc chắn muốn xóa khoản phí này?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><a href="./index.php?view_fees" class="text-decoration-none text-light">Không</a></button>
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
            var feeId = $(this).data('id');
            $('#confirmDeleteLink').attr('href', 'index.php?delete_fees=' + feeId);
            $('#deleteModal').modal('show');
        });
    });
</script>
