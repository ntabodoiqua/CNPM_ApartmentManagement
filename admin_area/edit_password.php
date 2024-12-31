<?php
if (isset($_GET['edit_password'])){
    $admin_session_name = $_SESSION['username'];
    $select_query = "select * from `admin_table` where admin_username='$admin_session_name'";
    $result_query = mysqli_query($con, $select_query);
    $row_fetch = mysqli_fetch_assoc($result_query);
    $admin_id = $row_fetch['admin_id'];

    if(isset($_POST['update_password'])){
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Kiểm tra mật khẩu hiện tại
        if(password_verify($current_password, $row_fetch['admin_password'])){
            // Kiểm tra mật khẩu mới và xác nhận mật khẩu
            if($new_password === $confirm_password){
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_query = "update `admin_table` set admin_password='$hashed_password' where admin_id=$admin_id";
                $result_update = mysqli_query($con, $update_password_query);

                if($result_update){
                    echo "<script>alert('Mật khẩu đã được đổi thành công!');</script>";
                    echo "<script>window.open('admin_logout.php', '_self');</script>";
                }
            } else {
                echo "<script>alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu hiện tại không đúng!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
    <style>
        table {
            width: 50%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h3 class="text-center text-success mb-4">Đổi mật khẩu</h3>
    <form action="" method="post">
        <table>
            <tr>
                <th colspan="2">Thông tin đổi mật khẩu</th>
            </tr>
            <tr>
                <td>Mật khẩu hiện tại:</td>
                <td><input type="password" name="current_password" required class="form-control w-50"></td>
            </tr>
            <tr>
                <td>Mật khẩu mới:</td>
                <td><input type="password" name="new_password" required class="form-control w-50"></td>
            </tr>
            <tr>
                <td>Xác nhận mật khẩu mới:</td>
                <td><input type="password" name="confirm_password" required class="form-control w-50"></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <input type="submit" class="bg-info py-2 px-3 border-0" value="Đổi mật khẩu" name="update_password">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
