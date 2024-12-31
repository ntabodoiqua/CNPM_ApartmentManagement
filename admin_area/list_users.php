<h3 class="text-center text-success my-4">Tất cả người dùng</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Username</th>
            <th>Tên người dùng</th>
            <th>Ảnh người dùng</th>
            <th>Tên hộ khẩu</th>
            <th>CCCD</th>
            <th>Xóa người dùng</th>
        </tr>
    </thead>
    <tbody class="bg-secondary text-light">
        <?php
        $get_users="SELECT * FROM `user_table`
                    join `residents` on user_table.resident_id = residents.resident_id
                    join `apartments` on apartments.apartment_id = residents.apartment_id";
        $result=mysqli_query($con,$get_users);
        $row_count=mysqli_num_rows($result);

        if($row_count==0){
            echo "<tr><td colspan='7' class='bg-danger text-center'>Chưa có người dùng nào!</td></tr>";
        } else {
            $number = 0;
            while($row_data=mysqli_fetch_assoc($result)){
                $resident_id=$row_data['resident_id'];
                $user_username=$row_data['user_username'];
                $resident_name=$row_data['resident_name'];
                $resident_image=$row_data['resident_image'];
                $apartment_name=$row_data['apartment_name'];
                $resident_phone=$row_data['resident_phone'];
                $number++;
        echo "
        <tr class='text-center'>
            <td>$number</td>
            <td>$user_username</td>
            <td>$resident_name</td>
            <td><img src='./people_images/$resident_image' alt='' class='admin_ava'></td>
            <td>$apartment_name</td>
            <td>$resident_phone</td>
            <td>
            <button class='btn btn-sm btn-danger delete-btn' data-id=$resident_id>
                    <i class='fa-solid fa-trash'></i> Xóa
                </button>
            </td>
        </tr>
        ";
        ?>
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
                <h4>Bạn có chắc chắn muốn xóa người dùng này?</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><a href="./index.php?list_users" class="text-decoration-none text-light">Không</a></button>
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
            var residentId = $(this).data('id');
            $('#confirmDeleteLink').attr('href', 'index.php?delete_user=' + residentId);
            $('#deleteModal').modal('show');
        });
    });
</script>
