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
$sql = "SELECT resident_name, resident_phone, resident_ngayden, resident_ngaydi FROM residents";
$result = $conn->query($sql);

?>

<body>
    <div class="container">
        <h3 class="text-center text-success my-4">Lịch Sử Biến Động Nhân Khẩu</h3>
        <table class="table table-bordered">
            <thead class="table-light text-center">
                <tr>
                    <th>Tên</th>
                    <th>Căn cước công dân</th>
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
                                <td>" . htmlspecialchars($row["resident_name"]) . "</td>
                                <td>" . htmlspecialchars($row["resident_phone"]) . "</td>
                                <td>" . htmlspecialchars($row["resident_ngayden"]) . "</td>
                                <td>" . htmlspecialchars($row["resident_ngaydi"]) . "</td>
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
