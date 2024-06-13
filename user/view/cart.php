
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Cart</strong></div>
    </div>
  </div>
</div>

<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <form class="col-md-12" method="post">
        <div class="site-blocks-table">
          <?php
          if (isset($_SESSION['giohang']) && !empty($_SESSION['giohang'])) {
            echo '<table class="table table-bordered">
            <thead>
            <tr>
              <th class="product-thumbnail">STT</th>
              <th class="product-name">Product</th>
              <th class="product-thumbnail">Image</th>
              <th class="product-price">Price</th>
              <th class="product-quantity">Quantity</th>
              <th class="product-total">Total</th>
              <th class="product-remove">Active</th>
            </tr>
            </thead>';
            $tong = 0;
           
            $i = 0; // Biến đếm mới
            foreach ($_SESSION['giohang'] as $item) {
                $tt = isset($item[3]) && isset($item[4]) ? $item[3] * $item[4] : 0;
                $tong += $tt;
                echo '<tbody>
                        <tr>
                            <td>' . ($i + 1) . '</td>
                            <td class="product-name">' . (isset($item[1]) ? $item[1] : 'N/A') . '</td>
                            <td class="product-thumbnail"><img src="../../uploads/' . (isset($item[2]) ? $item[2] : 'N/A') . '" alt="Image" class="img-fluid"></td>
                            <td class="product-price">' . (isset($item[3]) ? number_format($item[3], 1) : 'N/A') . '</td>
                            <td class="product-quantity">' . (isset($item[4]) ? $item[4] : 'N/A') . '</td>
                            <td class="product-total">' .  number_format($tt, 1) . '</td>
                            <td class="product-remove"><a href="index.php?act=delcart&i='.$i.'">Xóa</a></td>
                        </tr>
                      </tbody>';
                $i++; // Tăng biến đếm sau mỗi lần duyệt
            }
            
            echo '<tfoot>
              <tr>
                <td colspan="5" class="text-right"><strong>Tổng giá trị đơn hàng:</strong></td>
                <td><strong>' . number_format($tong, 1) . '</strong></td>
                <td></td>
              </tr>
            </tfoot>';
            echo '</table>';
          } else {
            echo '<div class="alert alert-info" role="alert">Giỏ hàng của bạn đang trống!</div>';
          }
          ?>
          <br>
        </div>
      </form>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="row mb-5">
          <div class="col-md-4 mb-3 mb-md-0">
            <a href="index.php">
              <button class="btn btn-primary btn-sm btn-block">Tiếp tục mua</button>
            </a>
          </div>
          <?php
          if (isset($_SESSION['giohang']) && !empty($_SESSION['giohang'])) {
            echo '<div class="col-md-4 mb-3 mb-md-0">
                    <a href="index.php?act=checkout">
                      <button class="btn btn-primary btn-sm btn-block">Thanh toán</button>
                    </a>
                  </div>
                  <div class="col-md-4">
                    <a href="index.php?act=delcart">
                      <button class="btn btn-outline-primary btn-sm btn-block">Xóa giỏ hàng</button>
                    </a>
                  </div>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/main.js"></script>
</body>
</html>
