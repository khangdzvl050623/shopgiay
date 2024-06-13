<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shoppers &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <link rel="stylesheet" href="../view/fonts/icomoon/style.css">
    <link rel="stylesheet" href="../view/css/bootstrap.min.css">
    <link rel="stylesheet" href="../view/css/magnific-popup.css">
    <link rel="stylesheet" href="../view/css/jquery-ui.css">
    <link rel="stylesheet" href="../view/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../view/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="../view/css/aos.css">
    <link rel="stylesheet" href="../view/css/style.css">
    <style>
      .site-top-icons ul li.has-children.active .dropdown {
        display: block;
      }
      .fixed-image {
        width: 100%;
        height: 300px; /* Điều chỉnh kích thước cao của hình ảnh */
        object-fit: cover;
      }
      .nonloop-block-3 .item {
        max-height: 400px; /* Độ cao tối đa cho các phần tử trong carousel */
        overflow: hidden;
      }
      .nonloop-block-3 .item img {
        width: 100%;
        height: auto;
      }
    </style>
</head>
<body>
<header class="site-navbar" role="banner">
    <!-- Phần header cho trang index.php -->
    <div class="site-navbar-top">
        <div class="container">
            <div class="row align-items-center">
            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
            <form action="<?php echo $shop_url; ?>" method="GET">
                <input type="text" name="keyword" placeholder="Tìm kiếm">
            </form>

            </div>
                <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                    <div class="site-logo">
                        <a href="index.php" class="js-logo-clone">Shoppers</a>
                    </div>
                </div>
                <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                    <div class="site-top-icons">
                        <ul>
                            <?php if(isset($_SESSION['user'])) : ?>
                                <li class="has-children">
                                    <a href="#"><span class="icon icon-person"></span> <?php echo $_SESSION['user']['id']; ?></a>
                                    <ul class="dropdown">
                                        <li><a href="index.php?act=thoat">Logout</a></li>
                                        <li><a href="index.php?act=mybill">Đơn hàng của bạn</a></li>
                                    </ul>
                                </li>
                            <?php else: ?>
                                <li class="has-children">
                                    <a href="#"><span class="icon icon-person"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="../../admin/view/login.php">Login</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>
                            <li>
                                <a href="index.php?act=addcart" class="site-cart">
                                    <span class="icon icon-shopping_cart"></span>
                                    <span class="count">!</span>
                                </a>
                            </li> 
                            <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
            <ul class="site-menu js-clone-nav d-none d-md-block">
                <li class="has-children active">
                    <a href="index.php">Home</a>
                    <ul class="dropdown">
                        <li><a href="#">Menu One</a></li>
                        <li><a href="#">Menu Two</a></li>
                        <li><a href="#">Menu Three</a></li>
                        <li class="has-children">
                            <a href="#">Sub Menu</a>
                            <ul class="dropdown">
                                <li><a href="#">Menu One</a></li>
                                <li><a href="#">Menu Two</a></li>
                                <li><a href="#">Menu Three</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="has-children">
                    <a href="index.php?act=about">About</a>
                    <ul class="dropdown">
                        <li><a href="#">Menu One</a></li>
                        <li><a href="#">Menu Two</a></li>
                        <li><a href="#">Menu Three</a></li>
                    </ul>
                </li>
                <li><a href="index.php?act=shop">Shop</a></li>
                <li><a href="index.php?act=contact">Contact</a></li>
            </ul>
        </div>
    </nav>
</header>
<script>
    // Bắt sự kiện khi người dùng nhấn phím Enter trên trường nhập liệu
    document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.querySelector("input[name='keyword']"); // Sử dụng attribute selector để chọn input có name là 'keyword'
        searchInput.addEventListener("keypress", function(e) {
            if (e.key === "Enter") {
                e.preventDefault(); // Ngăn chặn gửi biểu mẫu mặc định
                var keyword = searchInput.value.trim();
                if (keyword !== "") {
                    // Chuyển hướng đến trang tìm kiếm với từ khóa
                    window.location.href = "index.php?act=shop&keyword=" + encodeURIComponent(keyword);
                }
            }
        });
    });
</script>
</body>
</html>
