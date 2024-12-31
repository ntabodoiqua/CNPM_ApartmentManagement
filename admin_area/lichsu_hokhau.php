<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "apartment_control";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch data
$sql = "SELECT apartment_name, apartment_num, apartment_ngaylap, apartment_ngayroi, curr_living, apartment_id FROM apartments";
$result = $conn->query($sql);
// Query to update ngaydi

?>

<body>
    <div class="container">
        <h3 class="text-center text-success my-4">Lịch Sử Hộ Khẩu</h3>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Tên Hộ Khẩu</th>
                    <th>Số Phòng</th>
                    <th>Ngày Đến</th>
                    <th>Ngày Đi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row["apartment_name"]) . "</td>
                                <td>" . htmlspecialchars($row["apartment_num"]) . "</td>
                                <td>" . htmlspecialchars($row["apartment_ngaylap"]) . "</td>
                                <td>" . htmlspecialchars($row["apartment_ngayroi"]) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='bg-danger text-center'>Không có bản ghi nào!</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
