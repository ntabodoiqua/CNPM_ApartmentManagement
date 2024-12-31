<h3 class="text-center text-success my-4">Lịch sử tạm trú</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Tên người dân</th>
            <th>Số CCCD</th>
            <th>Lý do</th>
            <th>Địa chỉ thường trú</th>
            <th>Địa chỉ tạm trú (tên căn hộ)</th>
            <th>Ngày bắt đầu</th>
            <th>Ngày kết thúc</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $select_tamtru = "SELECT * FROM `tamtru`";
        $result_tamtru = mysqli_query($con, $select_tamtru);
        $num = 0;
        while ($row = mysqli_fetch_assoc($result_tamtru)) {
            $tamtru_id = $row['tamtru_id'];
            $resident_id = $row['resident_id'];
            $fetch_name_query="select * from `residents` where resident_id = '$resident_id'";
            $result_fetch_name=mysqli_query($con,$fetch_name_query);
            if ($result_fetch_name) {
                $fetch_name=mysqli_fetch_assoc($result_fetch_name);
                $resident_name=$fetch_name['resident_name'];
                $cccd = $fetch_name['resident_phone'];
                $tamtru_address = $fetch_name['apartment_id'];
            }
            $fetch_canho_query="select * from `apartments` where apartment_id = '$tamtru_address'";
            $result_fetch_canho=mysqli_query($con,$fetch_canho_query);
            if ($result_fetch_canho) {
                $fetch_canho=mysqli_fetch_assoc($result_fetch_canho);
                $resident_canho=$fetch_canho['apartment_name'];
            }
            $lydo = $row['lydo'];
            $thuongtru_address = $row['tamtru_thuongtru'];
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $num++;
        ?>
        <tr class="text-center">
            <td><?php echo $num; ?></td>
            <td><?php echo $resident_name; ?></td>
            <td><?php echo $cccd; ?></td>
            <td><?php echo $lydo; ?></td>
            <td><?php echo $thuongtru_address; ?></td>
            <td><?php echo $resident_canho; ?></td>
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
