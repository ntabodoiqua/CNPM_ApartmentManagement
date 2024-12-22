<?php
if (isset($_GET['edit_password'])){
    $user_session_name = $_SESSION['username'];
    $select_query = "select * from `user_table` where user_username='$user_session_name'";
    $result_query = mysqli_query($con, $select_query);
    $row_fetch = mysqli_fetch_assoc($result_query);
    $resident_id = $row_fetch['resident_id'];

    if(isset($_POST['update_password'])){
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Kiểm tra mật khẩu hiện tại
        if(password_verify($current_password, $row_fetch['user_password'])){
            // Kiểm tra mật khẩu mới và xác nhận mật khẩu
            if($new_password === $confirm_password){
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_query = "update `user_table` set user_password='$hashed_password' where resident_id=$resident_id";
                $result_update = mysqli_query($con, $update_password_query);

                if($result_update){
                    echo "<script>alert('Mật khẩu đã được đổi thành công!');</script>";
                    echo "<script>window.open('user_logout.php', '_self');</script>";
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
</head>
<body>
    <h3 class="text-center text-success mb-4">Đổi mật khẩu</h3>
    <form action="" method="post">
        <div class="form-outline mb-4">
            <label for="current_password">Mật khẩu hiện tại:</label>
            <input type="password" class="form-control w-50 m-auto" name="current_password" required>
        </div>
        <div class="form-outline mb-4">
            <label for="new_password">Mật khẩu mới:</label>
            <input type="password" class="form-control w-50 m-auto" name="new_password" required>
        </div>
        <div class="form-outline mb-4">
            <label for="confirm_password">Xác nhận mật khẩu mới:</label>
            <input type="password" class="form-control w-50 m-auto" name="confirm_password" required>
        </div>
        <div class="form-outline mb-4">
            <input type="submit" class="bg-info py-2 px-3 border-0" value="Đổi mật khẩu" name="update_password">
        </div>
    </form>
</body>
</html>
