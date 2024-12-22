<?php
include('../includes/connect.php');

if (isset($_POST['cccd'])) {
    $cccd = trim(mysqli_real_escape_string($con, $_POST['cccd']));
    $query = "SELECT resident_name FROM `residents` WHERE resident_phone='$cccd' and resident_status = 'Đang sống'";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo $row['resident_name'];
    } else {
        echo "";
    }
}
?>
