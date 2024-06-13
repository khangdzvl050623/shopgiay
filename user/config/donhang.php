<?php
// Kiểm tra và trích xuất giá trị của biến $tongdonhang từ dữ liệu POST
$tongdonhang = isset($_POST['tongdonhang']) ? $_POST['tongdonhang'] : 0;

function taodonhang($madh, $tongdonhang, $hoten, $address, $email, $tel, $pttt, $iduser) {
    try {
        $conn = connectdb(); // Kết nối CSDL
        $sql = "INSERT INTO tbl_order (madh, tongdonhang, hoten, address, email, tel, pttt, iduser, order_date) 
                VALUES (:madh, :tongdonhang, :hoten, :address, :email, :tel, :pttt, :iduser, NOW())";
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho các tham số
        $stmt->bindParam(':madh', $madh);
        $stmt->bindParam(':tongdonhang', $tongdonhang);
        $stmt->bindParam(':hoten', $hoten);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':pttt', $pttt);
        $stmt->bindParam(':iduser', $iduser);

        // Thực thi câu lệnh SQL
        $stmt->execute();

        // Lấy id đơn hàng vừa được chèn
        $last_id = $conn->lastInsertId();
        return $last_id;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}



function addtocart($iduser, $iddh, $idpro, $tensp, $img, $dongia, $soluong) {
    try {
        $conn = connectdb();
        $sql = "INSERT INTO tbl_cart (iduser, iddh, idpro, tensp, img, dongia, soluong) VALUES (:iduser, :iddh, :idpro, :tensp, :img, :dongia, :soluong)";
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho các tham số
        $stmt->bindParam(':iduser', $iduser);
        $stmt->bindParam(':iddh', $iddh);
        $stmt->bindParam(':idpro', $idpro);
        $stmt->bindParam(':tensp', $tensp);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':dongia', $dongia);
        $stmt->bindParam(':soluong', $soluong);

        // Thực thi câu lệnh SQL
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function getshowcart($iddh) {
    $conn = connectdb();
    $query = "SELECT * FROM tbl_cart WHERE iddh = :iddh";
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->bindParam(':iddh', $iddh, PDO::PARAM_INT);
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}

function getorderinfo($iddh) {
    $conn = connectdb();
    $query = "SELECT * FROM tbl_order WHERE id = :iddh";
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->bindParam(':iddh', $iddh, PDO::PARAM_INT);
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}
function get($iddh) {
    $conn = connectdb();
    $query = "SELECT * FROM tbl_order WHERE id = :iddh";
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->bindParam(':iddh', $iddh, PDO::PARAM_INT);
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}
function get_order_detail($id) {
    try {
        $conn = connectdb();
        $sql = "SELECT * FROM tbl_order WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $orderDetail = $stmt->fetch(PDO::FETCH_ASSOC);
        return $orderDetail;
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return false;
    }
}

function get_order_items($id) {
    try {
        $conn = connectdb();
        $sql = "SELECT * FROM tbl_cart WHERE iddh=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orderItems;
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return false;
    }
}



// Hàm get_ttdh
function get_ttdh($n) {
    switch ($n) {
        case '0':
            $tt = "Đơn hàng mới";
            break;
        case '1':
            $tt = "Đang xử lí";
            break;
        case '2':
            $tt = "Đang giao hàng";
            break;
        case '3':
            $tt = "Đã giao hàng";
            break;
        default:
            $tt = "Đơn hàng mới";
            break;
    }
    return $tt;
}

// Hàm loadall_cart_count
function loadall_cart_count($iddh) {
    try {
        $conn = connectdb(); // Kết nối CSDL
        $query = "SELECT COUNT(*) AS count FROM tbl_cart WHERE iddh = :iddh"; // Đếm số lượng sản phẩm trong giỏ hàng
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':iddh', $iddh, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count']; // Trả về số lượng sản phẩm
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}


function get_all_orders() {
    try {
        $conn = connectdb(); // Hàm kết nối cơ sở dữ liệu, đảm bảo hàm này hoạt động chính xác
        $query = "SELECT * FROM tbl_order"; // Đảm bảo tên bảng đúng
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return [];
    }
}
function get_orders_by_user_id($user_id) {
    try {
        $conn = connectdb();
        $sql = "SELECT * FROM tbl_order WHERE iduser = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return false;
    }
}
function get_all_bill($iduser) {
    try {
        $conn = connectdb();   
        $sql = "SELECT * FROM tbl_order WHERE iduser = :iduser"; 
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':iduser', $iduser, PDO::PARAM_INT);
        $stmt->execute();
        $listbill = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $listbill;
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return [];
    }
}


?>
