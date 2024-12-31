<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "apartment_control";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu thống kê theo tháng
$sql_month = "SELECT MONTH(payment_date) AS month, SUM(amount_paid) AS total_paid FROM payments GROUP BY MONTH(payment_date) ORDER BY MONTH(payment_date)";
$result_month = $conn->query($sql_month);

$months = [];
$totals_month = [];

if ($result_month->num_rows > 0) {
    while ($row = $result_month->fetch_assoc()) {
        $months[] = $row['month'];
        $totals_month[] = $row['total_paid'];
    }
}

// Lấy dữ liệu thống kê theo năm
$sql_year = "SELECT YEAR(payment_date) AS year, SUM(amount_paid) AS total_paid FROM payments GROUP BY YEAR(payment_date) ORDER BY YEAR(payment_date)";
$result_year = $conn->query($sql_year);

$years = [];
$totals_year = [];

if ($result_year->num_rows > 0) {
    while ($row = $result_year->fetch_assoc()) {
        $years[] = $row['year'];
        $totals_year[] = $row['total_paid'];
    }
}

// Lấy dữ liệu thống kê theo loại phí
$sql_fee = "SELECT type_name, SUM(amount_paid) AS total_paid FROM payments
            right join fees on payments.fee_id = fees.fee_id
            right join type_fee on fees.type_id = type_fee.type_id 
            GROUP BY type_name ORDER BY type_fee.type_id";
$result_fee = $conn->query($sql_fee);

$fees = [];
$totals_fee = [];

if ($result_fee->num_rows > 0) {
    while ($row = $result_fee->fetch_assoc()) {
        $fees[] = $row['type_name'];
        $totals_fee[] = $row['total_paid'];
    }
}

$conn->close();
?>

<style>
    .chart-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px; /* Khoảng cách giữa các biểu đồ */
        margin-top: 20px;
    }
    .chart-box {
        width: 45%; /* Chiều rộng mỗi biểu đồ */
    }
    canvas {
        width: 100% !important; /* Đảm bảo canvas co giãn theo container */
        height: auto !important;
    }
</style>
<!-- background carousel -->
<div class="container my-5 p-4 bg-light rounded shadow-sm">
<div id="highlightCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <img src="../images/slide1.jpeg" class="d-block w-100 rounded" alt="Mục nổi bật 1">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
            <img src="../images/slide2.jpg" class="d-block w-100 rounded" alt="Mục nổi bật 2">
            <div class="carousel-caption d-none d-md-block">
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
            <img src="../images/slide3.jpg" class="d-block w-100 rounded" alt="Mục nổi bật 3">
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

      <!-- Web intro third child -->

    <!-- Phần giới thiệu -->
    <div class="row mb-4 p-4">
    <!-- Cột Giới thiệu về Laptop Thế Anh -->
    <div class="col-md-6">
        <h2 class="text-dark">Chào mừng đến với trang quản trị thu phí chung cư Blue Moon</h2>
        <p class="lead">
        Chung cư BlueMoon, tọa lạc tại ngã tư Văn Phú, là biểu tượng hiện đại với 30 tầng, gồm kiot, nhà ở và penhouse, được hoàn thiện năm 2023. Với cơ sở vật chất đẳng cấp và quản lý chuyên nghiệp bởi Ban quản trị cư dân, BlueMoon mang đến không gian sống tiện nghi và bền vững.
        </p>
    </div>
    
    <!-- Cột Hình ảnh -->
    <div class="col-md-6 text-center">
        <img src="../images/chungcu_trangchu.webp" alt="Giới thiệu Laptop Thế Anh" class="img-fluid img-intro">
    </div>
</div>
</div>
<h2>Thống kê thanh toán</h2>
<div class="chart-container">
    <div class="chart-box">
        <h3>Thống kê theo tháng</h3>
        <canvas id="monthlyChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Thống kê theo năm</h3>
        <canvas id="yearlyChart"></canvas>
    </div>
    <div class="chart-box">
        <h3>Thống kê theo loại phí</h3>
        <canvas id="feeChart"></canvas>
    </div>
</div>

    <script>
        // Dữ liệu thống kê theo tháng
const months = <?php echo json_encode($months); ?>;
const totalsMonth = <?php echo json_encode($totals_month); ?>;

const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: months.map(m => `Tháng ${m}`),
        datasets: [{
            label: 'Tổng thanh toán (VND)',
            data: totalsMonth,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

// Dữ liệu thống kê theo năm
const years = <?php echo json_encode($years); ?>;
const totalsYear = <?php echo json_encode($totals_year); ?>;

const yearlyChart = new Chart(document.getElementById('yearlyChart'), {
    type: 'line', // Bạn có thể thay đổi loại biểu đồ nếu muốn
    data: {
        labels: years,
        datasets: [{
            label: 'Tổng thanh toán (VND)',
            data: totalsYear,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

// Dữ liệu thống kê theo loại phí
const fees = <?php echo json_encode($fees); ?>;
const totalsFee = <?php echo json_encode($totals_fee); ?>;

const feeChart = new Chart(document.getElementById('feeChart'), {
    type: 'pie',
    data: {
        labels: fees.map(f => `${f}`),
        datasets: [{
            label: 'Tổng thanh toán (VND)',
            data: totalsFee,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ],
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

    </script>

