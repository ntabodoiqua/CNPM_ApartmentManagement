<?php

// include connect file
// include('./includes/connect.php');

// get products
function get_index_fees() {
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
                  where payments.apartment_id = $apartment_id
                  order by fee_start_date desc
                  limit 6";
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
                <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
                <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
              <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
              <a href='' class='btn btn-danger'>Chưa đến ngày nộp</a>
            </div>
            </div>
            </div>";
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
                  where payments.apartment_id = $apartment_id
                  order by fee_start_date desc
                  ";
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
                <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
                <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
              <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
              <a href='' class='btn btn-warning'>Chưa đến ngày nộp</a>
            </div>
            </div>
            </div>";
          }
      }
    }
  }


// get chosen fees
function get_chosen_fee_type() {
  global $con;

    // check isset
    if(isset($_GET['type'])){
      $user_session_name = $_SESSION['username'];
      $select_query = "SELECT * FROM `user_table`
                    JOIN `residents` ON residents.resident_id = user_table.resident_id
                    WHERE user_username='$user_session_name'";
      $result_query = mysqli_query($con, $select_query);
      $row_fetch = mysqli_fetch_assoc($result_query);
      $apartment_id = $row_fetch['apartment_id'];
      $type_id=$_GET['type'];
      $select_query="select * from `payments`
                    join `fees` on payments.fee_id = fees.fee_id
                    where fees.type_id = $type_id and payments.apartment_id = $apartment_id;
                    ";
      $result_query_2=mysqli_query($con,$select_query);
      $num_rows=mysqli_num_rows($result_query_2);
      if ($num_rows==0){
        echo "<h2 class='text-center text-danger'>Không có khoản phí nào!</h2>";
      }
      while($row=mysqli_fetch_assoc($result_query_2)){
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
              <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
              <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
            <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
            <a href='' class='btn btn-warning'>Chưa đến ngày nộp</a>
          </div>
          </div>
          </div>";
        }
      }
}
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
  global $con;
    if(isset($_GET['search_data'])){
      $user_session_name = $_SESSION['username'];
      $select_query = "SELECT * FROM `user_table`
                    JOIN `residents` ON residents.resident_id = user_table.resident_id
                    WHERE user_username='$user_session_name'";
      $result_query = mysqli_query($con, $select_query);
      $row_fetch = mysqli_fetch_assoc($result_query);
      $apartment_id = $row_fetch['apartment_id'];
      $search_data_value=$_GET['search_data'];
      $search_query="select * from `payments`
                  join `fees` on payments.fee_id = fees.fee_id 
                  where fee_name like '%$search_data_value%' and payments.apartment_id = $apartment_id";
      $result_query_2=mysqli_query($con,$search_query);
      $num_rows=mysqli_num_rows($result_query_2);
      if ($num_rows==0){
        echo "<h2 class='text-center text-danger'>Không có khoản phí nào nào! Hãy kiểm tra từ khóa của bạn.</h2>";
      }
      while($row=mysqli_fetch_assoc($result_query_2)){
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
              <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
              <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
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
            <a href='mailto:BlueMoon@gmail.com' class='btn btn-secondary'>Gửi ý kiến</a>
            <a href='' class='btn btn-warning'>Chưa đến ngày nộp</a>
          </div>
          </div>
          </div>";
        }
      }
}
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




