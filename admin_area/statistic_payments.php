<h3 class="text-center text-success my-4">Quản lý thu phí cư dân</h3>
<div class="d-flex justify-content-between mb-4">
    <!-- Thanh tìm kiếm -->
    <form class="form-inline" method="GET" action="index.php">
        <input type="hidden" name="statistic_payments" value="1">
        <input type="text" name="search" class="form-control mr-2" placeholder="Tìm kiếm hộ khẩu hoặc khoản thu" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="width: 300px">
        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
    <!-- Bộ lọc tháng -->
    <form method="GET" action="index.php">
    <input type="hidden" name="statistic_payments" value="1">
    <select name="month_filter" class="form-control" onchange="this.form.submit()">
        <option value="">Chọn tháng</option>
        <?php
        for ($m=1; $m<=12; $m++) {
            $month = str_pad($m, 2, '0', STR_PAD_LEFT);
            $selected = (isset($_GET['month_filter']) && $_GET['month_filter'] == $month) ? 'selected' : '';
            echo "<option value='$month' $selected>$month</option>";
        }
        ?>
    </select>
    <select name="year_filter" class="form-control" onchange="this.form.submit()">
        <option value="">Chọn năm</option>
        <?php
        for ($y=date('Y') - 1; $y<=date('Y') + 1; $y++) { // Lọc từ năm trước đến năm sau
            $selected = (isset($_GET['year_filter']) && $_GET['year_filter'] == $y) ? 'selected' : '';
            echo "<option value='$y' $selected>$y</option>";
        }
        ?>
    </select>
</form>

</div>
<table class="table table-bordered table-hover table-striped mt-3">
    <thead class="table-dark">
        <tr class="text-center">
            <th>STT</th>
            <th>Tên hộ khẩu</th>
            <th>Số phòng</th>
            <th>Tên khoản thu</th>
            <th>Loại khoản thu</th>
            <th>Đơn giá</th>
            <th>Đã thanh toán</th>
            <th>Ngày thanh toán</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody class="bg-secondary text-light">
        <?php
        $query_conditions = "";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = mysqli_real_escape_string($con, $_GET['search']);
            $query_conditions .= " AND (apartments.apartment_name LIKE '%$search%' OR fees.fee_name LIKE '%$search%')";
        }

        if (isset($_GET['month_filter']) && !empty($_GET['month_filter'])) {
            $month = mysqli_real_escape_string($con, $_GET['month_filter']);
            $query_conditions .= " AND MONTH(fees.fee_due_date) = '$month'";
        }

        if (isset($_GET['year_filter']) && !empty($_GET['year_filter'])) {
            $year = mysqli_real_escape_string($con, $_GET['year_filter']);
            $query_conditions .= " AND YEAR(fees.fee_due_date) = '$year'";
        }
        $get_payments="SELECT payments.*, apartments.apartment_name, apartments.apartment_num, fees.fee_name, fees.fee_due_date, type_fee.type_name 
                        FROM payments 
                        INNER JOIN apartments ON payments.apartment_id = apartments.apartment_id 
                        INNER JOIN fees ON payments.fee_id = fees.fee_id 
                        INNER JOIN type_fee ON fees.type_id = type_fee.type_id 
                        WHERE 1=1 $query_conditions";

        $result=mysqli_query($con,$get_payments);
        $row_count=mysqli_num_rows($result);

        if($row_count==0){
            echo "<tr><td colspan='9' class='bg-danger text-center'>Không có dữ liệu phù hợp!</td></tr>";
        } else {
            $number = 0;
            while($row_data=mysqli_fetch_assoc($result)){
                $number++;
                $status = "";
                $due_date = $row_data['fee_due_date'];
                $amount_due = $row_data['amount_due'];
                $amount_paid = $row_data['amount_paid'];
                $payment_date = $amount_paid ? $row_data['payment_date'] : "Không có";

                if ($amount_paid == $amount_due) {
                    $status = "Đã thanh toán";
                    $status_class = "green"; // Biểu tượng hoặc màu xanh khi đã thanh toán
                } else if (strtotime($due_date) < strtotime(date('Y-m-d'))) {
                    $status = "Quá hạn";
                    $status_class = "red"; // Biểu tượng hoặc màu đỏ khi quá hạn
                } else if ($amount_paid == 0){
                    $status = "Chưa thanh toán";
                    $status_class = "red"; // Biểu tượng hoặc màu đỏ khi chưa thanh toán
                } else {
                    $status = "Thanh toán một phần";
                    $status_class = "yellow"; // Biểu tượng hoặc màu vàng cho thanh toán một phần
                }
        ?>
        <tr class="text-center">
            <td><?php echo $number; ?></td>
            <td><?php echo $row_data['apartment_name']; ?></td>
            <td><?php echo $row_data['apartment_num']; ?></td>
            <td><?php echo $row_data['fee_name']; ?></td>
            <td><?php echo $row_data['type_name']; ?></td>
            <td><?php echo number_format($amount_due,0,',','.'); ?></td>
            <td><?php echo number_format($amount_paid,0,',','.'); ?></td>
            <td><?php echo $payment_date; ?></td>
            <td class="<?php echo $status_class; ?>"><?php echo $status; ?></td>
        </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
