<h3 class="text-center text-success my-4">Lịch sử tạm vắng</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Tên người dân</th>
            <th>Số CCCD</th>
            <th>Lý do</th>
            <th>Địa chỉ tạm vắng</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $select_tamvang = "SELECT * FROM `tamvang`";
        $result_tamvang = mysqli_query($con, $select_tamvang);
        $num = 0;
        while ($row = mysqli_fetch_assoc($result_tamvang)) {
            $tamvang_id = $row['tamvang_id'];
            $resident_id = $row['resident_id'];
            $cccd = $row['cccd'];
            $fetch_name_query="select * from `residents` where resident_phone = '$cccd'";
            $result_fetch_name=mysqli_query($con,$fetch_name_query);
            if ($result_fetch_name) {
                $fetch_name=mysqli_fetch_assoc($result_fetch_name);
                $resident_name=$fetch_name['resident_name'];
            }
            $lydo = $row['lydo'];
            $address = $row['tamvang_address'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $num++;
        ?>
        <tr class="text-center">
            <td><?php echo $num; ?></td>
            <td><?php echo $resident_name; ?></td>
            <td><?php echo $cccd; ?></td>
            <td><?php echo $lydo; ?></td>
            <td><?php echo $address; ?></td>
            <td><?php echo $start_date; ?></td>
            <td><?php echo $end_date; ?></td>
        </tr>
        <?php
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
