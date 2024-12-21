<?php
if (isset($_GET['account_info'])) {
    $user_session_name = $_SESSION['username'];
    $select_query = "SELECT * FROM `user_table`
                     JOIN `residents` ON residents.resident_id = user_table.resident_id
                     JOIN `apartments` ON apartments.apartment_id = residents.apartment_id
                     WHERE user_username='$user_session_name'";
    $result_query = mysqli_query($con, $select_query);
    $row_fetch = mysqli_fetch_assoc($result_query);
    $resident_id = $row_fetch['resident_id'];
    $user_username = $row_fetch['user_username'];
    $resident_name = $row_fetch['resident_name'];
    $resident_cccd = $row_fetch['resident_phone'];
    $resident_email = $row_fetch['resident_email'];
    $apartment_name = $row_fetch['apartment_name'];
    $resident_dob = $row_fetch['resident_dob'];
    $resident_status = $row_fetch['resident_status'];
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <style>
        .edit_img{
            width:100px;
            height:100px;
            object-fit:contain;
        }
        table {
            width: 60%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h3 class="text-center text-success mb-4">Thông tin cá nhân</h3>
    <table>
        <tr>
            <th>Tên đăng nhập</th>
            <td><?php echo $user_username; ?></td>
        </tr>
        <tr>
            <th>Tên người dân</th>
            <td><?php echo $resident_name; ?></td>
        </tr>
        <tr>
            <th>CCCD người dân</th>
            <td><?php echo $resident_cccd; ?></td>
        </tr>
        <tr>
            <th>Email người dân</th>
            <td><?php echo $resident_email; ?></td>
        </tr>
        <tr>
            <th>Tên hộ khẩu</th>
            <td><?php echo $apartment_name; ?></td>
        </tr>
        <tr>
            <th>Ngày sinh</th>
            <td><?php echo $resident_dob; ?></td>
        </tr>
        <tr>
            <th>Trạng thái</th>
            <td><?php echo $resident_status; ?></td>
        </tr>
    </table>
</body>
</html>
