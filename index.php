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
    <title>Chung cư Blue Moon</title>
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

 <style>
  #productCarousel {
    max-width: 90%; /* Giới hạn chiều rộng slider đến 90% của trang */
    margin: 0 auto; /* Căn giữa slider */
  }

  #productCarousel .carousel-inner {
    padding: 10px;
  }

  #productCarousel .carousel-item img {
    width: 200px; /* Cố định kích thước của ảnh */
    height: 200px;
    object-fit: cover; /* Đảm bảo ảnh không bị méo */
    border-radius: 10px; /* Bo góc ảnh */
  }

  /* Đảm bảo tiêu đề "Các sản phẩm nổi bật" nổi bật */
  #productCarousel h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
  }

  /* Tùy chỉnh cho thiết bị nhỏ */
  @media (max-width: 768px) {
    #productCarousel {
      max-width: 100%; /* Cho phép slider chiếm toàn bộ chiều rộng trên màn hình nhỏ */
    }
  }
</style>


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

<!-- Web intro third child -->
<div class="container my-5 p-4 bg-light rounded shadow-sm">
    <!-- Phần giới thiệu -->
    <div class="row mb-4">
    <!-- Cột Giới thiệu về Laptop Thế Anh -->
    <div class="col-md-6">
        <h2 class="text-dark">Chào mừng đến với trang thông tin thu phí chung cư Blue Moon</h2>
        <p class="lead">
        Chung cư BlueMoon, tọa lạc tại ngã tư Văn Phú, là biểu tượng hiện đại với 30 tầng, gồm kiot, nhà ở và penhouse, được hoàn thiện năm 2023. Với cơ sở vật chất đẳng cấp và quản lý chuyên nghiệp bởi Ban quản trị cư dân, BlueMoon mang đến không gian sống tiện nghi và bền vững.
        </p>
        <a href="display_all.php" class="btn btn-success mt-3">Tất cả các khoản phí của bạn</a>
    </div>
    
    <!-- Cột Hình ảnh -->
    <div class="col-md-6 text-center">
        <img src="./images/chungcu_trangchu.webp" alt="Giới thiệu Laptop Thế Anh" class="img-fluid img-intro">
    </div>
</div>
<div class="shop-video-container">
  <div><h5 class="text-center">Mời bạn xem video giới thiệu về chung cư</h5></div>
  <iframe
  class="shop-video"
  src="https://www.youtube.com/embed/SG3HAnqT56w?si=bmBrkt5osk5Q2UOO&autoplay=1&mute=1&loop=1&modestbranding=1&controls=0&rel=0"
  frameborder="0"
  allow="autoplay; encrypted-media"
  allowfullscreen>
</iframe>



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

      


      <?php
// Kiểm tra nếu người dùng đã đăng nhập
if (isset($_SESSION['username'])) {
?>
<!-- fourth child -->
<div class="row">
    <div class="col-md-10">
        <!-- products -->
        <div class="row">
            <h5 class="featured-products-title">Các khoản thu</h5>
            <!-- fetch products -->
            <?php
            get_index_fees();
            get_chosen_fee_type();
            search_fees();
            ?>
            <!-- row end -->
        </div>
        <!-- column end -->
    </div>
    <div class="col-md-2 apple-style-sidebar">
        <!-- type of fee -->
        <div class="sidebar-section-brands">
            <h5 class="section-title text-center">Loại khoản thu</h5>
            <ul class="sidebar-list text-center">
                <?php get_fee_types(); ?>
            </ul>
        </div>
    </div>
</div>
<?php
} else {
?>
<!-- Thông báo chưa đăng nhập -->
<div class="container text-center mt-5">
    <div class="alert alert-warning" style="font-size: 1.2rem; max-width: 600px; margin: auto;">
        <strong>Vui lòng đăng nhập!</strong> Bạn cần đăng nhập để xem các khoản thu.
    </div>
    <a href="./user_area/user_login.php" class="btn btn-primary mt-3" style="font-size: 1rem;">
        Đăng nhập ngay
    </a>
</div>
<?php
}
?>







  <div class="container text-center my-5">
    <h2 class="section-title">Cư dân nghĩ gì về chung cư?</h2>
    <p class="section-description">Đọc những chia sẻ từ cư dân của chung cư để biết lý do vì sao chung cư là lựa chọn hàng đầu cho nhu cầu sinh sống của bạn!</p>
</div>
<!-- review child -->
<div id="customerReviewCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <!-- Slide 1 -->
    <div class="carousel-item active">
      <div class="d-flex justify-content-center align-items-center">
        <div class="carousel-content text-center">
          <img src="./images/customer1.jpg" class="rounded-circle customer-img" alt="Customer 1">
          <h5 class="mt-3">Lionel Messi</h5>
          <p class="text-muted">"Giành được chiếc cúp World Cup còn khó hơn mua một căn chung cư tại đây!"</p>
        </div>
      </div>
    </div>
    <!-- Slide 2 -->
    <div class="carousel-item">
      <div class="d-flex justify-content-center align-items-center">
        <div class="carousel-content text-center">
          <img src="./images/customer2.jpg" class="rounded-circle customer-img" alt="Customer 2">
          <h5 class="mt-3">Cristiana Ronalty</h5>
          <p class="text-muted">"BlueMoon mang đến một không gian sống đầy tinh tế và thoải mái, hoàn hảo để tôi thư giãn sau những màn đập điện thoại"</p>
        </div>
      </div>
    </div>
    <!-- Slide 3 -->
    <div class="carousel-item">
      <div class="d-flex justify-content-center align-items-center">
        <div class="carousel-content text-center">
          <img src="./images/customer3.jpg" class="rounded-circle customer-img" alt="Customer 3">
          <h5 class="mt-3">Anh Chây 97</h5>
          <p class="text-muted">"Chỉ cần 5 triệu mỗi tháng, bạn đã có thể mua được một căn chung cư sịn sò ở đây!"</p>
        </div>
      </div>
    </div>
    <!-- Slide 4 -->
    <div class="carousel-item">
      <div class="d-flex justify-content-center align-items-center">
        <div class="carousel-content text-center">
          <img src="./images/sontung.jpg" class="rounded-circle customer-img" alt="Customer 3">
          <h5 class="mt-3">Sơn Tùng MTP</h5>
          <p class="text-muted">"Chung cư này mang phong cách hiện đại, sang trọng, đúng chuẩn "chất" sống đẳng cấp mà tôi luôn tìm kiếm."</p>
        </div>
      </div>
    </div>
    <!-- Slide 5 -->
    <div class="carousel-item">
      <div class="d-flex justify-content-center align-items-center">
        <div class="carousel-content text-center">
          <img src="./images/elon.jpg" class="rounded-circle customer-img" alt="Customer 3">
          <h5 class="mt-3">Elon Musk</h5>
          <p class="text-muted">"Đây là nơi tôi có thể hình dung không chỉ là một ngôi nhà, mà còn là một bước tiến trong cuộc sống hiện đại."</p>
        </div>
      </div>
    </div>
    <!-- Slide 6 -->
    <div class="carousel-item">
      <div class="d-flex justify-content-center align-items-center">
        <div class="carousel-content text-center">
          <img src="./images/ceonvdia.jpg" class="rounded-circle customer-img" alt="Customer 3">
          <h5 class="mt-3">Jensen Huang</h5>
          <p class="text-muted">"Chung cư BlueMoon là sự lựa chọn số một của tôi để sinh sống!"</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#customerReviewCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#customerReviewCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Phần Cam kết của Laptop Thế Anh -->
<div class="row mb-5">
    <div class="col-12 text-center">
        <h2 class="commitment-title">Những cam kết của chúng tôi</h2>
        <p class="commitment-description">Chúng tôi cam kết mang đến cho bạn trải nghiệm sống tuyệt vời và đẳng cấp nhất.</p>
    </div>
</div>

<div class="row">
    <!-- Cam kết 1 -->
    <div class="col-md-4 text-center mb-4">
        <div class="commitment-box">
            <i class="fas fa-shield-alt fa-3x commitment-icon"></i> <!-- Đổi thành biểu tượng bảo vệ -->
            <h4 class="commitment-heading">An toàn tuyệt đối</h4>
            <p class="commitment-text">Chung cư BlueMoon cam kết mang đến môi trường sống an toàn với hệ thống bảo vệ và giám sát hiện đại, đảm bảo sự yên tâm cho cư dân.</p>
        </div>
    </div>

    <!-- Cam kết 2 -->
    <div class="col-md-4 text-center mb-4">
        <div class="commitment-box">
            <i class="fas fa-headphones-alt fa-3x commitment-icon"></i> <!-- Đổi thành biểu tượng tai nghe hỗ trợ -->
            <h4 class="commitment-heading">Hỗ trợ cư dân 24/7</h4>
            <p class="commitment-text">Chung cư BlueMoon luôn sẵn sàng hỗ trợ cư dân mọi lúc, từ việc giải quyết yêu cầu đến các vấn đề khẩn cấp, với đội ngũ nhân viên chuyên nghiệp và nhiệt tình.</p>
        </div>
    </div>

    <!-- Cam kết 3 -->
    <div class="col-md-4 text-center mb-4">
        <div class="commitment-box">
            <i class="fas fa-clipboard-list fa-3x commitment-icon"></i> <!-- Đổi thành biểu tượng danh sách chi phí -->
            <h4 class="commitment-heading">Minh bạch chi phí</h4>
            <p class="commitment-text">Chung cư BlueMoon cam kết cung cấp thông tin chi tiết và rõ ràng về chi phí, giúp cư dân dễ dàng theo dõi và kiểm soát tài chính của mình.</p>
        </div>
    </div>
</div>




<!-- last child -->
     </div>


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
<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" 
crossorigin="anonymous"></script>
</body>
</html>