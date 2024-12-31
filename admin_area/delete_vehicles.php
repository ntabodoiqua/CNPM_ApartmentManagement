<?php
if(isset($_GET['delete_vehicles'])){
    $delete_vehicles=$_GET['delete_vehicles'];
    $delete_query_vehicle="delete from `vehicles` where vehicle_id = $delete_vehicles";
    $result=mysqli_query($con,$delete_query_vehicle);
    if($result){
        echo "<script>alert('Phương tiện được xóa thành công!')</script>";
        echo "<script>window.open('./index.php?view_vehicles','_self')</script>";
    } else {
        echo "<script>alert('Xóa thất bại!')</script>";
        echo "<script>window.open('./index.php?view_vehicles','_self')</script>";
    }
}
?>