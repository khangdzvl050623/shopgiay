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
    
        <div class="site-blocks-table">
          <?php
         if (isset($_SESSION['iddh']) && is_numeric($_SESSION['iddh']) && $_SESSION['iddh'] > 0) {
          $getshowcart = getshowcart($_SESSION['iddh']);
          if (isset($getshowcart) && is_array($getshowcart) && count($getshowcart) > 0) {
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
            foreach ($getshowcart as $item) {
                $tt = isset($item['soluong']) && isset($item['dongia']) ? $item['soluong'] * $item['dongia'] : 0;
                $tong += $tt;
                echo '<tbody>
                        <tr>
                            <td>' . ($i + 1) . '</td> <!-- Sử dụng biến đếm $i thay vì $i -->
                            <td class="product-name">' . (isset($item['tensp']) ? $item['tensp'] : 'N/A') . '</td>
                            <td class="product-thumbnail"><img src="../../uploads/' . (isset($item['img']) ? $item['img'] : 'N/A') . '" alt="Image" class="img-fluid"></td>
                            <td class="product-price">' . (isset($item['dongia']) ? number_format($item['dongia'], 1) : 'N/A') . '</td>
                            <td class="product-quantity">' . (isset($item['soluong']) ? $item['soluong'] : 'N/A') . '</td>
                            <td class="product-total">' .  number_format($tt, 1) . '</td>
                    
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
          }
          } else {
            echo '<div class="alert alert-info" role="alert">Giỏ hàng của bạn đang trống!</div>';
          }
          ?>
          <br>
        </div>
        <?php
        if(isset($_SESSION['iddh'])&&($_SESSION['iddh']>0)){
          $orderinfo=getorderinfo($_SESSION['iddh']);
          if(count($orderinfo)>0){
        ?>
        <H3>Mã đơn hàng: <?=$orderinfo[0]['madh'];?></H3>
        <tr>
          <td>Tên người nhận: <?=$orderinfo[0]['hoten'];?></td>
        </tr>
        <tr>
          <td>Địa chỉ người nhận: <?=$orderinfo[0]['address'];?></td>
        </tr>
        <tr>
          <td>Email người nhận: <?=$orderinfo[0]['email'];?></td>
        </tr>
        <tr>
          <td>Điện thoại người nhận: <?=$orderinfo[0]['tel'];?></td>
        </tr>
        <tr>
          <td>Phương thức thanh toán:</td>
          <td>
            <?php
                switch($orderinfo[0]['pttt']){
                  case '1':
                    $txtmess="Thanh toán khi nhận hàng";
                    break;
                  case '2':
                    $txtmess="Chuyển khoản ngân hàng";
                    break;
                  case '3':
                    $txtmess="Chuyển khoản momo";
                    break;
                  case '4':
                    $txtmess="Thanh toán khác";
                    break;
                  default:
                    $txtmess="Quý khách chưa chọn phương thức thanh toán";
                    break;
                }
                echo $txtmess;
            ?>
          </td>
        </tr>
        <?php
        }
        }
      ?>
    </div>

        <div class="row">
          <div class="col-md-6">
            <div class="row mb-5">
                <div class="col-md-4 mb-3 mb-md-0">
                    <a href="index.php">
                        <button class="btn btn-primary btn-sm btn-block">Tiếp tục mua</button>
                    </a>
                </div>
              
              
              </div>

            </div>
         
          </div>

          
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
