<h3 class="text-center text-success my-4">Tất cả loại khoản thu</h3>
<table class="table table-bordered table-hover table-striped mt-5">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Tên loại khoản thu</th>
            <th>Mức giá</th>
            <th>Chỉnh sửa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $select_type = "SELECT * FROM `type_fee`";
        $result_type = mysqli_query($con, $select_type);
        $num = 0;
        while ($row = mysqli_fetch_assoc($result_type)) {
            $type_id = $row['type_id'];
            $type_name = $row['type_name'];
            $type_rate = $row['type_rate'];
            $num++;
        ?>
        <tr class="text-center">
            <td><?php echo $num; ?></td>
            <td><?php echo $type_name; ?></td>
            <td><?php echo $type_rate; ?></td>
            <td>
                <a href='index.php?edit_fee_type=<?php echo $type_id?>' class="btn btn-sm btn-warning">
                    <i class="fa-solid fa-pen-to-square"></i> Sửa
                </a>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>

