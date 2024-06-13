<?php
// Lấy từ khóa tìm kiếm từ biến GET
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// Trang shop URL
$shop_url = 'index.php?act=shop';
if (!empty($_GET['id'])) {
    $shop_url .= '&id=' . $_GET['id'];
}
// Nếu có từ khóa tìm kiếm, thêm vào URL
if (!empty($keyword)) {
    $shop_url .= '&keyword=' . urlencode($keyword);
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$items_per_page = 10;
$iddm = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Nếu có từ khóa tìm kiếm, hiển thị sản phẩm theo từ khóa
if (!empty($keyword)) {
    $dssp = get_sanpham_by_keyword($keyword, $page, $items_per_page); // Sử dụng hàm get_sanpham_by_keyword
    $total_products = count($dssp); // Đếm tổng số sản phẩm từ kết quả tìm kiếm
} else {
    // Nếu không có từ khóa, lấy sản phẩm theo danh mục hoặc tất cả sản phẩm
    if ($iddm > 0) {
        $dssp = getall_sanpham($iddm, $page, $items_per_page);
        $total_products = get_total_products($iddm);
    } else {
        $dssp = getall_sanpham(0, $page, $items_per_page);
        $total_products = get_total_products();
    }
}

$total_pages = ceil($total_products / $items_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <!-- Add your CSS links here -->
</head>
<body>
<div class="site-wrap">
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="../web/index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong></div>
            </div>
        </div>
    </div>

    <div class="site-section">
        <div class="container">

            <div class="row mb-5">
                <div class="col-md-9 order-2">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <div class="float-md-left mb-4"><h2 class="text-black h5">Shop All</h2></div>
                            <div class="d-flex">
                                <div class="dropdown mr-1 ml-md-auto">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Latest
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                        <a class="dropdown-item" href="#">Men</a>
                                        <a class="dropdown-item" href="#">Women</a>
                                        <a class="dropdown-item" href="#">Children</a>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Reference</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                        <a class="dropdown-item" href="#">Relevance</a>
                                        <a class="dropdown-item" href="#">Name, A to Z</a>
                                        <a class="dropdown-item" href="#">Name, Z to A</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Price, low to high</a>
                                        <a class="dropdown-item" href="#">Price, high to low</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                    <?php
                      // Kiểm tra nếu có sản phẩm
                      if (!empty($dssp)) {
                          foreach ($dssp as $sp) {
                              // Kiểm tra xem người dùng đã đăng nhập hay chưa
                              $link = isset($_SESSION['role']) && $_SESSION['role'] == 0 ? 'index.php' : 'index1.php';

                              echo '<div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                                      <div class="block-4 text-center border">
                                          <figure class="block-4-image">
                                              <a href="' . $link . '?act=product&id=' . $sp['id'] . '"><img src="../../uploads/' . $sp['img'] . '" alt="Image placeholder" class="img-fluid"></a>
                                          </figure>
                                          <div class="block-4-text p-4">
                                              <h3><a href="' . $link . '?act=product&id=' . $sp['id'] . '">' . $sp['tensp'] . '</a></h3>
                                              <p class="mb-0">New</p>
                                              <p class="text-primary font-weight-bold">' . $sp['gia'] . '</p>
                                          </div>
                                      </div>
                                  </div>';
                          }
                      } else {
                          echo "<p>No products found.</p>";
                      }
                      ?>



                    </div>
                    <div class="row" data-aos="fade-up">
                        <div class="col-md-12 text-center">
                            <div class="site-block-27">
                                <ul>
                                    <?php
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $link = isset($_SESSION['role']) && $_SESSION['role'] == 0 ? 'index.php' : 'index1.php';
                                        echo '<li' . ($i == $page ? ' class="active"' : '') . '><a href="' . $link . '?act=shop&id=' . $iddm . '&page=' . $i . '">' . $i . '</a></li>';
                                    }
                                    ?>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 order-1 mb-5 mb-md-0">
                    <div class="border p-4 rounded mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
                        <ul class="list-unstyled mb-0">
                            <?php
                            foreach($dsdm as $dm){
                              $link = isset($_SESSION['role']) && $_SESSION['role'] == 0 ? 'index.php' : 'index1.php';
                                echo '<li class="mb-1"><a href="'.$link.'.?act=shop&id='.$dm['id'].'" class="d-flex"><span>'.$dm['tendm'].'</span></a></li>';
                            }
                            ?>
                        </ul>

                    </div>


            <div class="border p-4 rounded mb-4">
              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                <div id="slider-range" class="border-primary"></div>
                <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />
              </div>

              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Size</h3>
                <label for="s_sm" class="d-flex">
                  <input type="checkbox" id="s_sm" class="mr-2 mt-1"> <span class="text-black">Small (2,319)</span>
                </label>
                <label for="s_md" class="d-flex">
                  <input type="checkbox" id="s_md" class="mr-2 mt-1"> <span class="text-black">Medium (1,282)</span>
                </label>
                <label for="s_lg" class="d-flex">
                  <input type="checkbox" id="s_lg" class="mr-2 mt-1"> <span class="text-black">Large (1,392)</span>
                </label>
              </div>

              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Color</h3>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-danger color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Red (2,429)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-success color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Green (2,298)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-info color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Blue (1,075)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center" >
                  <span class="bg-primary color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Purple (1,075)</span>
                </a>
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
                <div class="row justify-content-center text-center mb-5">
                  <div class="col-md-7 site-section-heading pt-4">
                    <h2>Categories</h2>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="../view/images/women.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Women</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="100">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="../view/images/children.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Children</h3>
                      </div>
                    </a>
                  </div>
                  <div class="col-sm-6 col-md-6 col-lg-4 mb-5 mb-lg-0" data-aos="fade" data-aos-delay="200">
                    <a class="block-2-item" href="#">
                      <figure class="image">
                        <img src="../view/images/men.jpg" alt="" class="img-fluid">
                      </figure>
                      <div class="text">
                        <span class="text-uppercase">Collections</span>
                        <h3>Men</h3>
                      </div>
                    </a>
                  </div>
                </div>
              
            </div>`
          </div>
        </div>
        
      </div>
    </div>
