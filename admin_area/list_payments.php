<h3 class="text-center text-success my-4">Quản lý thu phí cư dân</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Tên hộ khẩu</th>
            <th>Tên khoản thu</th>
            <th>Loại khoản thu</th>
            <th>Đơn giá</th>
            <th>Đã thanh toán</th>
            <th>Ngày thanh toán</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody class="bg-secondary text-light">
        <?php
      

        $get_payments="SELECT * FROM `payments`";
        $result=mysqli_query($con,$get_payments);
        $row_count=mysqli_num_rows($result);

        if($row_count==0){
            echo "<tr><td colspan='9' class='bg-danger text-center'>Chưa có khoản phí nào!</td></tr>";
        } else {
            $number = 0;
            while($row_data=mysqli_fetch_assoc($result)){
                $payment_id=$row_data['payment_id'];
                $fee_id=$row_data['fee_id'];
                $apartment_id=$row_data['apartment_id'];
                $amount_due=$row_data['amount_due'];
                $amount_paid=$row_data['amount_paid'];
                if ($amount_paid!=0){
                    $payment_date=$row_data['payment_date'];
                } else {
                    $payment_date="Không có";
                }
                
                $status=$row_data['status'];
                $number++;

                // Lấy tên hộ khẩu từ bảng `residents` dựa trên `apartment_id`
                $query_apartment = "SELECT apartment_name FROM apartments WHERE apartment_id = $apartment_id LIMIT 1";
                $result_apartment = mysqli_query($con, $query_apartment);
                $row_apartment = mysqli_fetch_assoc($result_apartment);
                $apartment_name = $row_apartment['apartment_name'];

                // Lấy tên khoản thu từ bảng `fees` dựa trên `fee_id`
                $query_fees = "SELECT fee_name FROM fees WHERE fee_id = $fee_id LIMIT 1";
                $result_fees = mysqli_query($con, $query_fees);
                $row_fees = mysqli_fetch_assoc($result_fees);
                $fee_name = $row_fees['fee_name'];

                // Lấy loại khoản thu từ bảng `type_fee` dựa trên `fee_id`
                $query_type_fee = "SELECT type_name FROM type_fee WHERE type_id = (SELECT type_id FROM fees WHERE fee_id = $fee_id) LIMIT 1";
                $result_type_fee = mysqli_query($con, $query_type_fee);
                $row_type_fee = mysqli_fetch_assoc($result_type_fee);
                $type_name = $row_type_fee['type_name'];
        ?>
        <tr class="text-center">
            <td><?php echo $number; ?></td>
            <td><?php echo $apartment_name; ?></td>
            <td><?php echo $fee_name; ?></td>
            <td><?php echo $type_name; ?></td>
            <td><?php echo number_format($amount_due,0,',','.'); ?></td>
            <td><?php echo number_format($amount_paid,0,',','.'); ?></td>
            <td><?php echo $payment_date; ?></td>
            <td><?php echo $status; ?></td>
            <td><a href="index.php?edit_payment=<?php echo $payment_id ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i> Thanh toán</a></td>
        </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<!-- Modal Xác nhận Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>Bạn có chắc chắn muốn xóa đơn này?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><a href="./index.php?list_payments" class="text-decoration-none text-light">Không</a></button>
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
            var confirm_id = $(this).data('id');
            $('#confirmDeleteLink').attr('href', 'index.php?delete_payment=' + confirm_id);
            $('#deleteModal').modal('show');
        });
    });
</script>
