<?php

// include connect file
// include('./includes/connect.php');

// get products
function getproducts(){
    global $con;

    // check isset
    if(!isset($_GET['category'])){
        if(!isset($_GET['brand'])){
    $select_query="select * from `products` LIMIT 0,6";
$result_query=mysqli_query($con,$select_query);
// $row=mysqli_fetch_assoc($result_query);
// echo $row['product_title'];
while($row=mysqli_fetch_assoc($result_query)){
  $product_id=$row['product_id'];
  $product_title=$row['product_title'];
  $product_description=$row['product_description'];
  $product_image1=$row['product_image1'];
  $temp_price=$row['product_price'];
  $product_price = number_format($temp_price, 0, ',', '.');
  $category_id=$row['category_id'];
  $brand_id=$row['brand_id'];
  $product_link=$row['product_link'];
  $number_available=$row['number_available'] - $row['number_sold'];
  if ($number_available>0) {
  echo "<div class='col-md-4 mb-2'>
  <div class='card' >
    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
    <div class='card-body'>
      <h5 class='card-title'>$product_title</h5>
      <p class='card-text'>$product_description</p>
      <p class='card-text'>Giá sản phẩm: $product_price VNĐ</p>
      <p class='card-text'>Còn trong kho: $number_available sản phẩm</p>
      <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Thêm vào giỏ hàng</a>
      <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>Xem thêm</a>
    </div>
  </div>
</div>";
  } else {
    echo "<div class='col-md-4 mb-2'>
  <div class='card' >
    <img src='./admin_area/product_images/$product_image1' class='card-img-top' alt='$product_title'>
    <div class='card-body'>
      <h5 class='card-title'>$product_title</h5>
      <p class='card-text'>$product_description</p>
      <p class='card-text'>Giá sản phẩm: $product_price VNĐ</p>
      <p class='card-text'>Còn trong kho: $number_available sản phẩm</p>
      <a href='$product_link' class='btn btn-secondary'>Đã hết hàng. Nhấp vào đây để đến trang NSX</a>
    </div>
  </div>
</div>";
  }
}
}
}
}

// get all fees
function get_all_fees() {
  global $con;
  // get apartment_id
  $user_session_name = $_SESSION['username'];
  $select_query = "SELECT * FROM `user_table`
                    JOIN `residents` ON residents.resident_id = user_table.resident_id
                    WHERE user_username='$user_session_name'";
  $result_query = mysqli_query($con, $select_query);
  $row_fetch = mysqli_fetch_assoc($result_query);
  $apartment_id = $row_fetch['apartment_id'];
  // check isset
  if(!isset($_GET['type'])){
      $select_query="select * from `payments`
                  join `fees` on payments.fee_id = fees.fee_id
                  where payments.apartment_id = $apartment_id";
      $result_query=mysqli_query($con,$select_query);
      while($row=mysqli_fetch_assoc($result_query)){
          $payment_id=$row['payment_id'];
          $fee_name=$row['fee_name'];
          $fee_image=$row['fee_image'];
          $fee_start_date=$row['fee_start_date'];
          $fee_due_date=$row['fee_due_date'];
          $temp_amount_due=$row['amount_due'];
          $temp_amount_paid=$row['amount_paid'];
          $amount_due = number_format($temp_amount_due, 0, ',', '.');
          $amount_paid = number_format($temp_amount_paid, 0, ',', '.');
          $fee_id=$row['fee_id'];
          $status=$row['status'];
          $current_date = date('Y-m-d');
          // sẽ thêm đk ngày sau
          if (strtotime($current_date) < strtotime($fee_due_date) && strtotime($current_date) > strtotime($fee_start_date)) { 

              echo "<div class='col-md-4 mb-2'>
              <div class='card' >
              <img src='./admin_area/fee_images/$fee_image' class='card-img-top' alt='$fee_name'>
              <div class='card-body'>
                <h5 class='card-title'>$fee_name</h5>
                <p class='card-text'>Bắt đầu nộp ngày: $fee_start_date </p>
                <p class='card-text'>Hết hạn vào: $fee_due_date </p>
                <p class='card-text'>Cần thu: $amount_due VNĐ</p>
                <p class='card-text'>Bạn đã thanh toán: $amount_paid VNĐ</p>
                <a href='fee_details.php?fee_id=$fee_id' class='btn btn-secondary'>Xem chi tiết</a>
                <a href='' class='btn btn-info'>Khoản phí đã bắt đầu nộp</a>
              </div>
              </div>
              </div>";
          } else if (strtotime($current_date) > strtotime($fee_due_date)){
          echo "<div class='col-md-4 mb-2'>
              <div class='card' >
              <img src='./admin_area/fee_images/$fee_image' class='card-img-top' alt='$fee_name'>
              <div class='card-body'>
                <h5 class='card-title'>$fee_name</h5>
                <p class='card-text'>Bắt đầu nộp ngày: $fee_start_date </p>
                <p class='card-text'>Hết hạn vào: $fee_due_date </p>
                <p class='card-text'>Cần thu: $amount_due VNĐ</p>
                <p class='card-text'>Bạn đã thanh toán: $amount_paid VNĐ</p>
                <a href='fee_details.php?fee_id=$fee_id' class='btn btn-secondary'>Xem chi tiết</a>
                <a href='' class='btn btn-danger'>Đã quá hạn nộp</a>

              </div>
              </div>
              </div>";
          } else if (strtotime($current_date) < strtotime($fee_start_date)) {
            echo "<div class='col-md-4 mb-2'>
            <div class='card' >
            <img src='./admin_area/fee_images/$fee_image' class='card-img-top' alt='$fee_name'>
            <div class='card-body'>
              <h5 class='card-title'>$fee_name</h5>
              <p class='card-text'>Bắt đầu nộp ngày: $fee_start_date </p>
              <p class='card-text'>Hết hạn vào: $fee_due_date </p>
              <p class='card-text'>Cần thu: $amount_due VNĐ</p>
              <p class='card-text'>Bạn đã thanh toán: $amount_paid VNĐ</p>
              <a href='fee_details.php?fee_id=$fee_id' class='btn btn-secondary'>Xem chi tiết</a>
              <a href='' class='btn btn-danger'>Chưa đến ngày nộp</a>
            </div>
            </div>
            </div>";
          }
      }
    }
  }


// get chosen fees
function get_chosen_fees() {

}

// display fee types
function get_fee_types() {
  global $con;
  $select_type_fee = "SELECT * FROM `type_fee`";
  $result_type_fee = mysqli_query($con, $select_type_fee);
  while ($row_data = mysqli_fetch_assoc($result_type_fee)) {
    $type_name = $row_data['type_name'];
    $type_id = $row_data['type_id'];
    echo "<li class='sidebar-list-item'>
            <a href='index.php?type=$type_id' class='sidebar-link'>
            $type_name
            </a>
          </li>";
  }
}



// search fees

function search_fees(){
 
}

// view details function
function view_details() {

}


// get user order details

function get_user_order_details() {
  global $con;
  $username=$_SESSION['username'];
  $get_details="select * from `user_table` where username='$username'";
  $result_query=mysqli_query($con,$get_details);
  while($row_query=mysqli_fetch_array($result_query)){
    $user_id=$row_query['user_id'];
    if(!isset($_GET['edit_account'])){
      if(!isset($_GET['my_orders'])){
        if(!isset($_GET['delete_account'])){
          $get_orders="select * from `user_orders` where user_id=$user_id and order_status='pending'";
          $result_orders_query=mysqli_query($con,$get_orders);
          $row_count=mysqli_num_rows($result_orders_query);
          if($row_count>0){
            echo "<h3 class='text-center text-success mt-5 mb-2'>Bạn có <span class='text-danger'>$row_count
            </span> đơn hàng đang chờ xác nhận.</h3>
            <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Chi tiết đơn hàng</a></p>";
          } else {
            echo "<h3 class='text-center text-success mt-5 mb-2'>Bạn không có đơn hàng đang chờ xác nhận.</h3>
            <p class='text-center'><a href='../index.php' class='text-dark'>Tới trang chủ</a></p>";
          }
        }
      }
    }
  }
}




