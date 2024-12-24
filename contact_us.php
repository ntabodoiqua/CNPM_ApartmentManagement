<!-- connect file -->
<?php
include('includes/connect.php');
include('functions/common_functions.php');
session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tất cả khoản thu</title>
<!-- bootstrap CSS link -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
rel="stylesheet" 
integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
crossorigin="anonymous">
<!-- font awesome link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" 
integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" 
crossorigin="anonymous" 
referrerpolicy="no-referrer" />

<!-- css file -->
 <link rel="stylesheet" href="style.css">




</head>
<body>
    <!-- navbar -->
     <div class="container-fluid p-0">
        <!-- first child -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-fixed">
  <div class="container-fluid">
    <img src="./images/logo.png" alt="" class="logo">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Trang chủ</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="display_all.php">Các khoản phí</a>
        </li>
        
        <?php
    // Chỉ hiển thị mục "Tài khoản của tôi" nếu đã đăng nhập
    if (isset($_SESSION['username'])) {
    ?>
    <li class="nav-item">
        <a class="nav-link" href="./user_area/profile.php">Tài khoản của tôi</a>
    </li>
    <?php
    }
    ?>
        <li class="nav-item">
          <a class="nav-link" href="contact_us.php">Liên hệ ban quản trị</a>
        </li>
      </ul>
      <form class="d-flex" role="search" action="search_fees.php" method="get">
        <input class="form-control me-2" type="search" placeholder="Tìm kiếm khoản phí" aria-label="Search" name="search_data">
         <input type="submit" value="Tìm kiếm" class="btn btn-success" name="search_data_product">
      </form>
    </div>
  </div>
</nav>



<!-- second child -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <ul class="navbar-nav me-auto">
        <?php
        if(!isset($_SESSION['username'])){
          echo "<li class='nav-item'>
          <a class='nav-link text-white' href='#'>Welcome Guest!</a>
        </li>";
        } else {
          echo "<li class='nav-item'>
          <a class='nav-link text-white' href='#'>Welcome ".$_SESSION['username']."!</a>
        </li>";
        }
        if(!isset($_SESSION['username'])){
          echo "<li class='nav-item'>
          <a class='nav-link text-white' href='./user_area/user_login.php'>Đăng nhập</a>
        </li>";
        } else {
          echo "<li class='nav-item'>
          <a class='nav-link text-white' href='./user_area/user_logout.php'>Đăng xuất</a>
        </li>";
        }
        ?>
    </ul>
</nav>

<!-- third child -->





 <div class="container my-5 p-4 bg-light rounded shadow-sm">
 <div class="hero-minimalist">
    <h3 class="hero-minimalist-title">
        <i class="fas fa-building"></i> Chung cư BlueMoon
    </h3>
    <p class="hero-minimalist-subtitle">
        <i class="fas fa-quote-left"></i>Đẳng cấp, tiện nghi và sang trọng
    </p>
</div>

<div id="highlightCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <img src="./images/slide1.jpeg" class="d-block w-100 rounded" alt="Mục nổi bật 1">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
            <img src="./images/slide2.jpg" class="d-block w-100 rounded" alt="Mục nổi bật 2">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
            <img src="./images/slide3.jpg" class="d-block w-100 rounded" alt="Mục nổi bật 3">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
    </div>
    <!-- Nút điều hướng -->
    <button class="carousel-control-prev" type="button" data-bs-target="#highlightCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#highlightCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
      </div>

    <!-- Main Section -->
    <div class="container my-5">
        <h1 class="text-center mb-4">Liên hệ chúng tôi</h1>
        <div class="row">
            <!-- Thông tin cá nhân -->
            <div class="col-md-4">
                <div class="card text-center border-0 shadow-sm">
                    <img src="./images/TheAnh.JPG" class="card-img-top rounded-circle p-3" alt="The Anh">
                    <div class="card-body">
                        <h4 class="card-title">Nhóm 07</h4>
                        <p class="card-text">Nhập môn công nghệ phần mềm </p>
                        <p>IT3180 - 154019</p>
                        <div>
                            <a href="https://www.facebook.com/ntabodoiqua2004/" target="_blank" class="btn btn-primary btn-sm me-2"><i class="fa-brands fa-facebook"></i> Facebook</a>
                            <a href="https://github.com/ntabodoiqua" target="_blank" class="btn btn-dark btn-sm"><i class="fa-brands fa-github"></i> GitHub</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Nội dung -->
            <div class="col-md-8">
    <div class="mb-4">
        <h2>Về chúng tôi</h2>
        <p>Chào mừng bạn đến với <strong>Chung cư BlueMoon</strong>! Chúng tôi tự hào mang đến một không gian sống hiện đại, tiện nghi và thân thiện với môi trường.</p>
        <ul>
            <li>Thiết kế sang trọng và đẳng cấp</li>
            <li>Tiện ích nội khu đa dạng</li>
            <li>Môi trường sống xanh và an lành</li>
            <li>Dịch vụ hỗ trợ tận tâm</li>
        </ul>
    </div>
    <div>
        <h2>Liên hệ</h2>
        <p>Hãy để chúng tôi đồng hành cùng bạn. Bạn có thể liên hệ với chúng tôi qua:</p>
        <ul>
            <li>Email: <a href="mailto:bluemoon.support@housing.vn">bluemoon.support@housing.vn</a></li>
            <li>Hotline: <a href="tel:+84987654321">+84 987 654 321</a></li>
        </ul>
        <div class="d-flex justify-content-start mt-3">
            <a href="mailto:bluemoon.support@housing.vn" class="btn btn-outline-primary me-2"><i class="fa-solid fa-envelope"></i> Gửi Email</a>
            <a href="tel:+84987654321" class="btn btn-outline-success"><i class="fa-solid fa-phone"></i> Gọi Hotline</a>
        </div>
    </div>
</div>

        </div>
    </div>

    <!-- Footer -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
