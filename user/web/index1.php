<?php
ob_start(); // Bắt đầu buffering output

session_start(); // Bắt đầu session nếu chưa tồn tại
if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']); // Xóa thông báo sau khi hiển thị
}

if (!isset($_SESSION['giohang'])) $_SESSION['giohang'] = [];

include ("../config/config.php");
include ("../config/sanpham.php");
include ("../config/danhmuc.php");
include ("../config/donhang.php");
$sphome1 = getall_sanpham(0, 0);

// Controller
include "../view/header1.php";

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}
$keyword = ""; // Khởi tạo biến $keyword trước khi sử dụng
$action = isset($_GET["act"]) ? $_GET["act"] : 'home';

switch ($action) {
    case 'about':
        include "../view/about.php";
        break;
    case 'thankyou':
        include "../view/thankyou.php";
        break;
    case 'checkout':
        include "../view/checkout.php";
        break;
    case 'addcart':
        // Chuyển hướng người dùng đến trang đăng nhập (index.php) nếu chưa đăng nhập
        $_SESSION['error_message'] = "Bạn cần phải đăng nhập để mua hàng";
        header("Location: index.php");
        exit();
        break;
  
       
    case 'shop':
        // Lấy từ khóa tìm kiếm từ GET nếu tồn tại, nếu không thì mặc định là chuỗi rỗng
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
    
        // Lấy danh sách danh mục
        $dsdm = getall_dm();
    
        // Trang hiện tại, mặc định là trang 1
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    
        // Số lượng sản phẩm trên mỗi trang
        $items_per_page = 10;
    
        // ID danh mục, mặc định là 0 (tất cả sản phẩm)
        $iddm = isset($_GET['id']) && $_GET['id'] > 0 ? intval($_GET['id']) : 0;
    
        // Nếu có ID danh mục, lấy sản phẩm theo danh mục, nếu không, lấy tất cả sản phẩm
        if ($iddm > 0) {
            $dssp = getall_sanpham($iddm, $page, $items_per_page);
            $total_products = get_total_products($iddm);
        } else {
            // Kiểm tra nếu biến $keyword đã được khai báo
            if (!empty($keyword)) {
                $dssp = get_sanpham_by_keyword($keyword, $page, $items_per_page); // Lấy sản phẩm theo từ khóa
                $total_products = count($dssp); // Đếm tổng số sản phẩm từ kết quả tìm kiếm
            } else {
                // Nếu không có từ khóa, lấy tất cả sản phẩm và sắp xếp theo tên sản phẩm
                $dssp = getall_sanpham($iddm, $page, $items_per_page, 'tensp'); // Sắp xếp theo tên sản phẩm
                $total_products = get_total_products($iddm);
            }
        }
        
        // Tính tổng số trang dựa trên số sản phẩm và số sản phẩm trên mỗi trang
        $total_pages = ceil($total_products / $items_per_page);
    
        include "../view/shop.php";
        break;
    
    case 'product':
        if (isset($_GET['id']) && ($_GET['id'] > 0)) {
            $id = $_GET['id'];
            $product = getonesp($id);
            if (!$product) {
                // Nếu không tìm thấy sản phẩm, chuyển hướng người dùng về trang chính
                header("Location: index1.php");
                exit(); // Đảm bảo kết thúc luồng chương trình
            }
            include "../view/shop-single.php";
        } else {
            header("Location: index1.php");
            exit();
        }
        break;

    case 'contact':
        include "../view/contact.php";
        break;

    case 'delcart':
        if (isset($_GET['i']) && ($_GET['i'] >= 0)) {
            if (isset($_SESSION['giohang']) && (count($_SESSION['giohang']) > 0)) {
                array_splice($_SESSION['giohang'], $_GET['i'], 1);
            }
        } else {
            if (isset($_SESSION['giohang'])) unset($_SESSION['giohang']);
        }

        if (isset($_SESSION['giohang']) && (count($_SESSION['giohang']) > 0)) {
            include "../view/cart.php";
        } else {
            header('Location: index1.php');
            exit();
        }
        break;

    case 'thanhtoan':
        if ((isset($_POST['thanhtoan'])) && ($_POST['thanhtoan'])) {
            // Lấy dữ liệu
            $tongdonhang = isset($_POST['tongdonhang']) ? $_POST['tongdonhang'] : 0;
            $hoten = isset($_POST['hoten']) ? $_POST['hoten'] : '';
            $address = isset($_POST['address']) ? $_POST['address'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
            $pttt = isset($_POST['pttt']) ? $_POST['pttt'] : '';
            $madh = rand(0, 999999);
            $iduser = isset($_SESSION['iduser']) ? $_SESSION['iduser'] : NULL; // Lấy iduser từ session hoặc gán NULL nếu không có

            // Tạo đơn hàng và trả về id đơn hàng
            $iddh = taodonhang($madh, $tongdonhang, $hoten, $address, $email, $tel, $pttt, $iduser);
            $_SESSION['iddh'] = $iddh;

            if (isset($_SESSION['giohang']) && (count($_SESSION['giohang']) > 0)) {
                foreach ($_SESSION['giohang'] as $item) {
                    addtocart($iddh, $item[0], $item[1], $item[2], $item[3], $item[4]);
                }
                unset($_SESSION['giohang']);
            }
            include "../view/donhang.php";
        }
        break;

    default:
        include "../view/home.php";
        break;
}

include "../view/footer.php";

ob_end_flush(); // Kết thúc buffering output và gửi tất cả đầu ra
?>
