<?php
include('../includes/connect.php');
include('../functions/common_functions.php');
session_start();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
rel="stylesheet" 
integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
crossorigin="anonymous">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" 
crossorigin="anonymous" 
referrerpolicy="no-referrer" />
<!-- css file -->  
 <link rel="stylesheet" href="../style.css">

</head>
<body>
    <!-- navbar -->
     <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/logo.png" alt="" class="logo">
                <nav class="navbar navbar-expand-lg navbar-light bg-info">
                    <ul class="navbar-nav ">
                        <li class="nav-item">
                            <a href="" class="nav-link"><?php echo "<li class='nav-item'>
          <a class='nav-link' href='#'>Welcome ".$_SESSION['username']."!</a>
        </li>"?></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>


        <!-- second child -->
         <div class="bg-light">
            <h3 class="text-center p-2">Quản lý chi tiết</h3>
         </div>

         <!-- third child -->
         <div class="row">
    <div class="col-md-12 bg-secondary p-3 d-flex align-items-center justify-content-between">
        <!-- Admin Avatar and Name -->
        <div class="d-flex align-items-center">
            <a href="#" class="d-block">
                <img src="../images/hacker-nga.webp" alt="Admin Avatar" class="admin_ava rounded-circle border border-light" style="width: 70px; height: 70px;">
            </a>
            <div class="ms-3">
                <p class="text-light mb-0"><?php echo "<li class='nav-item'>
          <a class='nav-link' href='#'>".$_SESSION['username']."</a>
        </li>"?></p>
                <small class="text-danger">Quản trị viên</small>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="button text-center">
            <div class="d-flex flex-wrap gap-2">
                <a href="index.php?insert_people" class="btn btn-info text-light px-4 py-2">Thêm nhân khẩu</a>
                <a href="index.php?view_people" class="btn btn-info text-light px-4 py-2">Xem nhân khẩu</a>
                <a href="index.php?insert_apartments" class="btn btn-info text-light px-4 py-2">Thêm hộ khẩu</a>
                <a href="index.php?view_apartments" class="btn btn-info text-light px-4 py-2">Xem hộ khẩu</a>
                <a href="index.php?insert_tamtru" class="btn btn-info text-light px-4 py-2">Thêm tạm trú</a>
                <a href="index.php?insert_tamvang" class="btn btn-info text-light px-4 py-2">Thêm tạm vắng</a>
                <a href="index.php?view_tamtru" class="btn btn-info text-light px-4 py-2">Danh sách tạm trú</a>
                <a href="index.php?view_tamvang" class="btn btn-info text-light px-4 py-2">Danh sách tạm vắng</a>
                <a href="index.php?insert_vehicles" class="btn btn-info text-light px-4 py-2">Thêm phương tiện</a>
                <a href="index.php?view_vehicles" class="btn btn-info text-light px-4 py-2">Danh sách phương tiện</a>
                <a href="index.php?view_fee_type" class="btn btn-info text-light px-4 py-2">Xem loại phí</a>
                <a href="index.php?insert_fees" class="btn btn-info text-light px-4 py-2">Thêm phí thu</a>
                <a href="index.php?view_fees" class="btn btn-info text-light px-4 py-2">Xem phí thu</a>
                <a href="index.php?list_payments" class="btn btn-info text-light px-4 py-2">Quản lý thu phí</a>
                <a href="index.php?statistic_payments" class="btn btn-info text-light px-4 py-2">Thống kê thu phí</a>
                <a href="index.php?insert_users" class="btn btn-info text-light px-4 py-2">Thêm người dùng</a>
                <a href="index.php?list_users" class="btn btn-info text-light px-4 py-2">Danh sách người dùng</a>
                <a href="index.php?log_out" class="btn btn-danger text-light px-4 py-2">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>



     <!-- fourth child -->
<div class="container my-3">
    <?php
    if(isset($_GET['insert_people'])) {
        include('insert_people.php');
    }
    if(isset($_GET['insert_apartments'])) {
        include('insert_apartments.php');
    }
    if (isset($_GET['view_apartments'])) {
        ?>
        <form method="GET" action="index.php" class="d-flex my-4">
            <!-- Đảm bảo view_apartments vẫn được gửi kèm với dữ liệu tìm kiếm -->
            <input type="hidden" name="view_apartments" value="1">
            <input type="text" name="search_data" class="form-control me-2" placeholder="Nhập mã hộ khẩu, tên hộ khẩu, chủ hộ khẩu hoặc số phòng" required>
            <button type="submit" name="search_submit" class="btn btn-info">Tìm kiếm</button>
        </form>
        <?php
        // Thay thế 'view_people.php' bằng 'view_apartments.php' để hiển thị danh sách hộ khẩu
        include('view_apartments.php');
    }
    if (isset($_GET['view_people'])) { 
        ?>
            <form method="GET" action="index.php" class="d-flex my-4">
                <input type="hidden" name="view_people" value="1">
                <input type="text" name="search_data" class="form-control me-2" placeholder="Nhập tên chủ hộ hoặc người dân" required>
                <button type="submit" name="search_submit" class="btn btn-info">Tìm kiếm</button>
            </form>
        <?php
            include('view_people.php'); 
        }
    if(isset($_GET['view_fee_type'])) {
        include('view_fee_type.php');
    }
    if(isset($_GET['insert_fees'])) {
        include('insert_fees.php');
    }
    if(isset($_GET['view_tamtru'])) {
        include('view_tamtru.php');
    }
    if(isset($_GET['view_tamvang'])) {
        include('view_tamvang.php');
    }
    if(isset($_GET['insert_tamtru'])) {
        include('insert_tamtru.php');
    }
    if(isset($_GET['insert_tamvang'])) {
        include('insert_tamvang.php');
    }
    if(isset($_GET['insert_vehicles'])) {
        include('insert_vehicles.php');
    }
    if(isset($_GET['view_vehicles'])) {
        include('view_vehicles.php');
    }
    if(isset($_GET['view_fees'])) {
        include('view_fees.php');
    }
    if(isset($_GET['list_payments'])) {
        include('list_payments.php');
    }
    if (isset($_GET['statistic_payments'])) {
        // Lấy các tham số search và month_filter (nếu có)
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $month_filter = isset($_GET['month_filter']) ? $_GET['month_filter'] : '';
        $year_filter = isset($_GET['year_filter']) ? $_GET['year_filter'] : '';
        // Bao gồm file statistic_payments.php
        include('statistic_payments.php');
    }
    if(isset($_GET['insert_users'])) {
        include('insert_users.php');
    }
    if(isset($_GET['list_users'])) {
        include('list_users.php');
    }
    if(isset($_GET['edit_payment'])) {
        include('edit_payment.php');
    }
    if(isset($_GET['log_out'])) {
        include('admin_logout.php');
    }
    ?>
</div>



     <!-- last child -->
     <?php
        include("../includes/footer.php");
        ?>
     </div>
<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>