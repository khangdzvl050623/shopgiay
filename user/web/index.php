<?php
session_start(); // Bắt đầu session nếu chưa tồn tại

ob_start(); // Bắt đầu buffering output

if (isset($_SESSION["role"]) && $_SESSION["role"] == 0) {

    if (!isset($_SESSION['giohang'])) $_SESSION['giohang'] = [];

    include("../config/config.php");
    include("../config/sanpham.php");
    include("../config/danhmuc.php");
    include("../config/donhang.php");
    $sphome1 = getall_sanpham(0, 0);

    // Controller
    // Lưu nội dung của header2.php vào một biến
    ob_start();
    include "../view/header2.php"; // Sử dụng header2.php cho người dùng đã đăng nhập

    $action = isset($_GET["act"]) ? $_GET["act"] : 'home';

    switch ($action) {
        case 'mybill':
            $listbill = get_all_bill($_SESSION['user']['id']);
            include "../view/mybill.php";
            break;
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
            // Kiểm tra trạng thái đăng nhập
            if (!isset($_SESSION["role"]) || $_SESSION["role"] != 0) {
                // Chuyển hướng đến trang đăng nhập nếu người dùng chưa đăng nhập
                $_SESSION['error_message'] = "Bạn cần phải đăng nhập để mua hàng";
                header("Location: index1.php");
                exit();
            }
            // Kiểm tra xem có yêu cầu POST từ form không và dữ liệu hợp lệ
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addtocart'])) {
                if (
                    isset($_POST['id'], $_POST['tensp'], $_POST['img'], $_POST['gia'], $_POST['sl']) &&
                    !empty($_POST['id']) && !empty($_POST['tensp']) && !empty($_POST['img']) && !empty($_POST['gia']) && ($_POST['sl'] > 0)
                ) {
                    // Lấy dữ liệu từ form
                    $id = $_POST['id'];
                    $tensp = $_POST['tensp'];
                    $img = $_POST['img'];
                    $gia = $_POST['gia'];
                    $sl = $_POST['sl'];

                    // Kiểm tra xem giỏ hàng đã được khởi tạo chưa
                    if (!isset($_SESSION['giohang'])) {
                        $_SESSION['giohang'] = array();
                    }

                    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
                    $productExists = false;
                    foreach ($_SESSION['giohang'] as &$item) {
                        if ($item[0] === $id && $item[1] === $tensp) { // So sánh cả id và tensp
                            $item[4] += $sl; // Cập nhật số lượng sản phẩm
                            $productExists = true;
                            break;
                        }
                    }
                    unset($item); // Quan trọng: Hủy tham chiếu để tránh lỗi

                    // Nếu sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
                    if (!$productExists) {
                        $item = array($id, $tensp, $img, $gia, $sl);
                        $_SESSION['giohang'][] = $item;
                    }
                }
            }
            // Bao gồm trang giỏ hàng
            include "../view/cart.php";
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
                    header("Location: index.php");
                    exit(); // Đảm bảo kết thúc luồng chương trình
                }
                include "../view/shop-single.php";
            } else {
                header("Location: index.php");
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
                header('Location: index.php');
                exit();
            }
            break;

            case 'thanhtoan':
                if (isset($_POST['thanhtoan']) && ($_POST['thanhtoan'])) {
                    // Lấy dữ liệu từ form
                    $madh = rand(0,999999); 
                    $tongdonhang = isset($_POST['tongdonhang']) ? $_POST['tongdonhang'] :0;
                    $hoten = isset($_POST['hoten']) ? $_POST['hoten'] : '';
                    $address = isset($_POST['address']) ? $_POST['address'] : '';
                    $email = isset($_POST['email']) ? $_POST['email'] : '';
                    $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
                    $pttt = isset($_POST['pttt']) ? $_POST['pttt'] : '';
            
                    // Kiểm tra xem người dùng đã đăng nhập và có thông tin user không
                    if (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['id'])) {
                        $iduser = $_SESSION['user']['id'];
                    } else {
                        $iduser = 0; // hoặc xử lý lỗi theo cách bạn muốn
                    }
                    
                    // Các biến khác...
            
                    // Tạo đơn hàng và trả về id đơn hàng
                    $iddh = taodonhang($madh, $tongdonhang, $hoten, $address, $email, $tel, $pttt, $iduser);
                    $_SESSION['iddh'] = $iddh;
            
                    if (isset($_SESSION['giohang']) && is_array($_SESSION['giohang']) && count($_SESSION['giohang']) > 0) {
                        foreach ($_SESSION['giohang'] as $item) {
                            if (is_array($item) && count($item) >= 5) {
                                addtocart($_SESSION['user']['id'], $iddh, $item[0], $item[1], $item[2], $item[3], $item[4]);
                            } else {
                                // Thông báo lỗi hoặc xử lý trường hợp không mong đợi
                                echo "Giỏ hàng có phần tử không hợp lệ.";
                            }
                        }
                        unset($_SESSION['giohang']);
                    } else {
                        // Thông báo lỗi hoặc xử lý trường hợp không mong đợi
                        echo "Giỏ hàng không hợp lệ.";
                    }
            
                    include "../view/donhang.php";
                }
                break;
            

        case 'thoat':
            session_unset(); // Xóa tất cả các biến trong session
            session_destroy(); // Hủy session
            header("Location: index1.php"); // Chuyển hướng về trang chủ khi đăng xuất
            exit();
            break;

        default:
            include "../view/home.php";
            break;
    }

    include "../view/footer.php";
    // In ra nội dung của header2.php ở cuối file
    echo $header_content;
} else {
    header("Location: index1.php");
    exit(); // Dừng mã sau khi chuyển hướng
}

ob_end_flush(); // Kết thúc buffering output và gửi tất cả đầu ra
?>
