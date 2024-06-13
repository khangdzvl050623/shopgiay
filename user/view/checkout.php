<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="styles.css"> <!-- Tùy chỉnh CSS của bạn -->
</head>
<body>

  <!-- Header -->
  <header>
    <!-- Thêm header của bạn ở đây -->
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-6">
        <!-- Form Billing Details -->
        <h2 class="mb-4">Billing Details</h2>
        <form action="index.php?act=thanhtoan" method="post">
        <?php 
          $tong = 0;
          if (isset($_SESSION['giohang']) && !empty($_SESSION['giohang'])) {
              foreach ($_SESSION['giohang'] as $item) {
                  $tt = isset($item[3]) && isset($item[4]) ? $item[3] * $item[4] : 0;
                  $tong += $tt;
              }
          }
        ?>
        
          <!-- Đưa biến $tong vào trong form -->
          <input type="hidden" name="tongdonhang" value="<?=$tong?>">
          <div class="form-group">
            <label for="c_country" class="text-black">Quốc gia <span class="text-danger">*</span></label>
            <select id="c_country" class="form-control">
              <option value="1">Select a country</option>    
              <option value="2">Bangladesh</option>    
              <option value="3">Algeria</option>    
              <option value="4">Afghanistan</option>    
              <option value="5">Ghana</option>    
              <option value="6">Albania</option>    
              <option value="7">Bahrain</option>    
              <option value="8">Colombia</option>    
              <option value="9">Dominican Republic</option>    
            </select>
          </div>
          <div class="form-group">
            <label for="hoten" class="text-black">Nhập họ tên <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="hoten" name="hoten">
          </div>
          <div class="form-group">
            <label for="address" class="text-black">Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Street address">
          </div>
          <div class="form-group">
            <label for="email" class="text-black">Nhập email<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="tel" class="text-black">Nhập số điện thoại<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="tel" name="tel" placeholder="Phone Number">
          </div>
          <div class="form-group">
            <label for="notes" class="text-black">Order Notes</label>
            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
          </div>
          <div class="border p-3 mb-4">
            <h3 class="h6 mb-0">Payment Method</h3>
            <div class="py-2">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="pttt" id="cashOnDelivery" value="1">
                <label class="form-check-label" for="cashOnDelivery">
                    Thanh toán khi nhận hàng
                </label>
            </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pttt" id="bankTransfer" value="2">
                <label class="form-check-label" for="bankTransfer">
                    Chuyển khoản ngân hàng
                </label>
            </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pttt" id="momoTransfer" value="3">
                <label class="form-check-label" for="momoTransfer">
                    Chuyển khoản momo
                </label>
            </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="pttt" id="otherPayment" value="4">
                <label class="form-check-label" for="otherPayment">
                    Thanh toán khác
                </label>
            </div>
              <input type="submit" class="btn btn-primary" name="thanhtoan" value="Thanh toán">
            </div>
          </div>
      
      </div>
      <div class="col-md-6">
        <!-- Coupon Code and Order Summary -->
        <h2 class="mb-4">Coupon Code</h2>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Coupon Code" aria-label="Coupon Code" aria-describedby="button-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button" id="button-addon2">Apply</button>
          </div>
        </div>
        <hr>
        <h2 class="mb-4">Your Order</h2>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Product</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $tong = 0;
            if (isset($_SESSION['giohang']) && !empty($_SESSION['giohang'])) {
              
              foreach ($_SESSION['giohang'] as $item) {
                $tt = isset($item[3]) && isset($item[4]) ? $item[3] * $item[4] : 0;
                $tong += $tt;
                echo '<tr>';
                echo '<td>' . (isset($item[1]) ? $item[1] : 'N/A') . '</td>';
                echo '<td>' . number_format($tt, 1) . '</td>';
                echo '</tr>';
              }
              echo '<tr>';
              echo '<td class="text-black font-weight-bold"><strong>Order Total</strong></td>';
              echo '<td class="text-black font-weight-bold"><strong>' . number_format($tong, 1) . '</strong></td>';
              echo '</tr>';
            } else {
              echo '<tr>';
              echo '<td colspan="2" class="text-center">No items in the cart</td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <!-- Thêm footer của bạn ở đây -->
  </footer>

</body>
</html>
