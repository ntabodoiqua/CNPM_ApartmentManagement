<?php
include('../includes/connect.php');
if(isset($_POST['insert_user'])){
    $user_username=trim($_POST['user_username']);
    $user_cccd=trim($_POST['cccd']);
    $user_password=$_POST['user_password'];
    $hash_password=password_hash($user_password, PASSWORD_DEFAULT);
    $user_conf_password=$_POST['user_conf_password'];
    // select query
    $select_query="select * from `user_table` where user_username='$user_username'";
    $result=mysqli_query($con,$select_query);
    $rows_count=mysqli_num_rows($result);
    if($rows_count>0) {
        echo "<script>alert('Tên đăng nhập đã tồn tại!')</script>";
    }
    else if($user_password!=$user_conf_password){
        echo "<script>alert('Mật khẩu xác nhận không chính xác!')</script>";
    }
    else{
        // select resident id
        $select_resident_id="select * from `residents` where resident_phone='$user_cccd'";
        $query_resident_id=mysqli_query($con, $select_resident_id);
        $result_id=mysqli_fetch_assoc($query_resident_id);
        $resident_id=$result_id['resident_id'];
        // insert query
        $insert_query="insert into `user_table` (resident_id, user_username, user_password)
        values ($resident_id, '$user_username', '$hash_password')";
        $sql_exec=mysqli_query($con,$insert_query);
        if($sql_exec){
            echo "<script>alert('Đăng ký thành công tài khoản cho người dân')</script>
            <script>window.open('index.php?insert_users','_self')</script>";
        
        }else{
            die(mysqli_error($con));
        }
    }
    
}
?>



</head>
<body class="bg-light">
<div class="container mt-3">
    <h3 class="text-center text-success my-4">Thêm tài khoản cho người dân</h3>
    <form action="" method="post" class="mx-auto" enctype="multipart/form-data">
        <table class="table table-bordered table-hover table-striped mt-3">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Thông tin</th>
                    <th>Nhập dữ liệu</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td><label for="cccd">CCCD Người dân</label></td>
                <td><input type="text" name="cccd" id="cccd" class="form-control" placeholder="Nhập CCCD" required></td>
            </tr>
            <tr>
                
                <td><label for="name">Tên Người dân</label></td>
                <td><input type="text" name="name" id="name" class="form-control" placeholder="Tên sẽ tự động hiển thị" readonly></td>
            </tr>
            <tr>
                <td><label for="user_username">Tên đăng nhập</label></td>
                <td><input type="text" name="user_username" id="user_username" class="form-control" placeholder="Nhập tên đăng nhập" required></td>
            </tr>
            <tr>
                <td><label for="user_password">Mật khẩu</label></td>
                <td><input type="password" name="user_password" id="user_password" class="form-control" placeholder="Nhập mật khẩu" required></td>
            </tr>
            <tr>
                <td><label for="user_conf_password">Xác nhận mật khẩu</label></td>
                <td><input type="password" name="user_conf_password" id="user_conf_password" class="form-control" placeholder="Xác nhận mật khẩu" required></td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <button type="submit" name="insert_user" class="btn btn-info px-4">Xác nhận</button>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#cccd').on('input', function() {
        let cccd = $(this).val();
        if (cccd.length >= 3) {
            $.ajax({
                url: 'fetch_resident.php',
                type: 'POST',
                data: { cccd: cccd },
                success: function(data) {
                    $('#name').val(data ? data : 'Không tìm thấy');
                },
                error: function() {
                    alert("Lỗi khi tìm kiếm dữ liệu.");
                }
            });
        } else {
            $('#name').val('');
        }
    });
});
</script>
</body>


