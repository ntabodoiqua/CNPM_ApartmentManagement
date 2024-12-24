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
        <nav class="navbar navbar-expand-lg bg-info navbar-fixed">
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
        <!-- People Management -->
        <div class="dropdown">
            <button class="btn btn-info text-light px-4 py-2 dropdown-toggle" type="button" id="peopleMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Quản lý nhân khẩu
            </button>
            <ul class="dropdown-menu" aria-labelledby="peopleMenu">
                <li><a class="dropdown-item" href="index.php?insert_people">Thêm nhân khẩu</a></li>
                <li><a class="dropdown-item" href="index.php?view_people">Xem nhân khẩu</a></li>
                <li><a class="dropdown-item" href="index.php?lichsu_nhankhau">Biến động nhân khẩu</a></li>
            </ul>
        </div>

        <!-- Apartment Management -->
        <div class="dropdown">
            <button class="btn btn-info text-light px-4 py-2 dropdown-toggle" type="button" id="apartmentMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Quản lý hộ khẩu
            </button>
            <ul class="dropdown-menu" aria-labelledby="apartmentMenu">
                <li><a class="dropdown-item" href="index.php?insert_apartments">Thêm hộ khẩu</a></li>
                <li><a class="dropdown-item" href="index.php?view_apartments">Xem hộ khẩu</a></li>
                <li><a class="dropdown-item" href="index.php?lichsu_hokhau">Lịch sử biến động hộ khẩu</a></li>
            </ul>
        </div>

        <!-- Temporary Residence -->
        <div class="dropdown">
            <button class="btn btn-info text-light px-4 py-2 dropdown-toggle" type="button" id="tamtruMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Quản lý tạm trú
            </button>
            <ul class="dropdown-menu" aria-labelledby="tamtruMenu">
                <li><a class="dropdown-item" href="index.php?insert_tamtru">Thêm tạm trú</a></li>
                <li><a class="dropdown-item" href="index.php?view_tamtru">Danh sách tạm trú</a></li>
            </ul>
        </div>

        <!-- Temporary Absence -->
        <div class="dropdown">
            <button class="btn btn-info text-light px-4 py-2 dropdown-toggle" type="button" id="tamvangMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Quản lý tạm vắng
            </button>
            <ul class="dropdown-menu" aria-labelledby="tamvangMenu">
                <li><a class="dropdown-item" href="index.php?insert_tamvang">Thêm tạm vắng</a></li>
                <li><a class="dropdown-item" href="index.php?view_tamvang">Danh sách tạm vắng</a></li>
            </ul>
        </div>

        <!-- Vehicle Management -->
        <div class="dropdown">
            <button class="btn btn-info text-light px-4 py-2 dropdown-toggle" type="button" id="vehicleMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Quản lý phương tiện
            </button>
            <ul class="dropdown-menu" aria-labelledby="vehicleMenu">
                <li><a class="dropdown-item" href="index.php?insert_vehicles">Thêm phương tiện</a></li>
                <li><a class="dropdown-item" href="index.php?view_vehicles">Danh sách phương tiện</a></li>
            </ul>
        </div>

        <!-- Fee Management -->
        <div class="dropdown">
            <button class="btn btn-info text-light px-4 py-2 dropdown-toggle" type="button" id="feeMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Quản lý phí
            </button>
            <ul class="dropdown-menu" aria-labelledby="feeMenu">
                <li><a class="dropdown-item" href="index.php?view_fee_type">Xem loại phí</a></li>
                <li><a class="dropdown-item" href="index.php?insert_fees">Thêm phí thu cho toàn bộ căn hộ</a></li>
                <li><a class="dropdown-item" href="index.php?insert_fee_each_ap">Thêm phí thu cho căn hộ cụ thể</a></li>
                <li><a class="dropdown-item" href="index.php?view_fees">Xem phí thu</a></li>
                <li><a class="dropdown-item" href="index.php?list_payments">Quản lý thu phí</a></li>
                <li><a class="dropdown-item" href="index.php?statistic_payments">Thống kê thu phí</a></li>
            </ul>
        </div>

        <!-- User Management -->
        <div class="dropdown">
            <button class="btn btn-info text-light px-4 py-2 dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Quản lý người dùng
            </button>
            <ul class="dropdown-menu" aria-labelledby="userMenu">
                <li><a class="dropdown-item" href="index.php?insert_users">Thêm người dùng</a></li>
                <li><a class="dropdown-item" href="index.php?list_users">Danh sách người dùng</a></li>
                <li><a class="dropdown-item" href="index.php?edit_password">Đổi mật khẩu QTV</a></li>
            </ul>
        </div>

        <!-- Logout -->
        <div class="dropdown">
            <button class="btn btn-danger text-light px-4 py-2 dropdown-toggle" type="button" id="logoutMenu" data-bs-toggle="dropdown" aria-expanded="false">
                Đăng xuất
            </button>
            <ul class="dropdown-menu" aria-labelledby="logoutMenu">
                <li><a class="dropdown-item" href="index.php?log_out">Đăng xuất</a></li>
            </ul>
        </div>
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
    <form method="GET" action="index.php" class="d-flex my-4" id="filterForm">
        <!-- Đảm bảo view_apartments vẫn được gửi kèm với dữ liệu tìm kiếm -->
        <input type="hidden" name="view_apartments" value="1">
        <input type="text" name="search_data" class="form-control me-2" placeholder="Nhập mã hộ khẩu, tên hộ khẩu, chủ hộ khẩu hoặc số phòng" value="<?php echo isset($_GET['search_data']) ? htmlspecialchars($_GET['search_data']) : ''; ?>" required>
        <div class="form-check me-2">
            <input type="checkbox" name="include_moved_out" id="include_moved_out" class="form-check-input" value="1" <?php echo isset($_GET['include_moved_out']) ? 'checked' : ''; ?> onchange="document.getElementById('filterForm').submit();">
            <label for="include_moved_out" class="form-check-label">Hiển thị căn hộ đã chuyển đi</label>
        </div>
        <button type="submit" name="search_submit" class="btn btn-info">Tìm kiếm</button>
    </form>
    <?php
    // Bao gồm danh sách căn hộ
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
    if(isset($_GET['delete_user'])) {
        include('delete_user.php');
    }
    if(isset($_GET['edit_password'])) {
        include('edit_password.php');
    }
    if(isset($_GET['edit_apartment'])) {
        include('edit_apartment.php');
    }
    if(isset($_GET['edit_fee_type'])) {
        include('edit_fee_type.php');
    }
    if(isset($_GET['edit_resident'])) {
        include('edit_resident.php');
    }
    if(isset($_GET['lichsu_nhankhau'])) {
        include('lichsu_nhankhau.php');
    }
    if(isset($_GET['lichsu_hokhau'])) {
        include('lichsu_hokhau.php');
    }
    if(isset($_GET['insert_fee_each_ap'])) {
        include('insert_fee_each_ap.php');
    }
    ?>
</div>



     <!-- last child -->
     <div class="footer bg-dark text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Địa chỉ quán Laptop -->
            <div class="col-md-4">
                <h5>Địa chỉ:</h5>
                <p>123 Đường ABC, Quận XYZ, Thành phố Hà Nội</p>
            </div>
            
            <!-- Số điện thoại và Email -->
            <div class="col-md-4">
                <h5>Liên hệ:</h5>
                <p><strong>Điện thoại:</strong> <a href="tel:+84987654321" class="text-light">0987 654 321</a></p>
                <p><strong>Email:</strong> <a href="mailto:contact@laptopstore.com" class="text-light">BlueMoon@gmail.com</a></p>
            </div>

            <!-- Liên kết đến các mạng xã hội -->
            <div class="col-md-4 text-center">
                <h5>Theo dõi chúng tôi:</h5>
                <a href="https://www.facebook.com/ntabodoiqua2004" target="_blank" class="text-light mx-2">
                    <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="https://github.com/ntabodoiqua/Project1_EcomWebSite" target="_blank" class="text-light mx-2">
                    <i class="fab fa-github fa-2x"></i>
                </a>
            </div>
        </div>
        
        <!-- Dòng chữ "All Rights Reserved" -->
        <div class="text-center mt-3">
            <p>&copy;2024 BlueMoon. All Rights Reserved.</p>
        </div>
    </div>
</div>
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