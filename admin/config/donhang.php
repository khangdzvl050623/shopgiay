<?php
// Kiểm tra và trích xuất giá trị của biến $tongdonhang từ dữ liệu POST
$tongdonhang = isset($_POST['tongdonhang']) ? $_POST['tongdonhang'] : 0;



function taodonhang($madh, $tongdonhang, $hoten, $address, $email, $tel, $pttt) {
    try {
        $conn = connectdb();
        $sql = "INSERT INTO tbl_order (madh, tongdonhang, hoten, address, email, tel, pttt) VALUES (:madh, :tongdonhang, :hoten, :address, :email, :tel, :pttt)";
        $stmt = $conn->prepare($sql);
        
        // Gán giá trị cho các tham số
        $stmt->bindParam(':madh', $madh);
        $stmt->bindParam(':tongdonhang', $tongdonhang);
        $stmt->bindParam(':hoten', $hoten);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':pttt', $pttt);
        
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

function addtocart($iddh, $idpro, $tensp, $img, $dongia, $soluong) {
    try {
        $conn = connectdb();
        $sql = "INSERT INTO tbl_cart (iddh, idpro, tensp, img, dongia, soluong) VALUES (:iddh, :idpro, :tensp, :img, :dongia, :soluong)";
        $stmt = $conn->prepare($sql);

        // Gán giá trị cho các tham số
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

function getshowcart($iddh){
    $conn = connectdb();
    $query = "SELECT * FROM tbl_cart WHERE iddh=".$iddh; 
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}
function getorderinfo($iddh){
    $conn = connectdb();
    $query = "SELECT * FROM tbl_order WHERE id=".$iddh; 
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}

function loadall_bill($iduser = null) {
    $conn = connectdb(); // Sử dụng hàm connectdb() để kết nối đến cơ sở dữ liệu

    // Xây dựng truy vấn
    $sql = "SELECT id, madh, hoten, address, tel, email, tongdonhang, status FROM tbl_order";
    if ($iduser !== null) {
        $sql .= " WHERE iduser = ?";
    }
    $sql .= " ORDER BY id DESC";

    // Chuẩn bị truy vấn
    $stmt = $conn->prepare($sql);

    // Gán giá trị cho tham số iduser nếu cần
    if ($iduser !== null) {
        $stmt->bindParam(':iduser', $iduser, PDO::PARAM_INT);
    }

    // Thực thi truy vấn
    $stmt->execute();

    // Lấy kết quả
    $listbill = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Đóng kết nối
    $conn = null;

    // Trả về danh sách đơn hàng
    return $listbill;
}


function get_order_detail($iddh) {
    try {
        $conn = connectdb();
        $sql = "SELECT * FROM tbl_order WHERE id=:iddh"; // Thay tbl_order bằng tên bảng đơn hàng thực tế

        // Chuẩn bị truy vấn
        $stmt = $conn->prepare($sql);

        // Bind tham số
        $stmt->bindParam(':iddh', $iddh, PDO::PARAM_INT);

        // Thực thi truy vấn
        $stmt->execute();

        // Lấy kết quả
        $orderDetail = $stmt->fetch(PDO::FETCH_ASSOC);

        return $orderDetail;
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return false;
    }
}
function get_order_items($iddh) {
    try {
        $conn = connectdb();
        $sql = "SELECT * FROM tbl_cart WHERE iddh=:iddh"; // Thay tbl_cart bằng tên bảng mặt hàng thực tế

        // Chuẩn bị truy vấn
        $stmt = $conn->prepare($sql);

        // Bind tham số
        $stmt->bindParam(':iddh', $iddh, PDO::PARAM_INT);

        // Thực thi truy vấn
        $stmt->execute();

        // Lấy kết quả
        $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $orderItems;
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return false;
    }
}
function get_ttdh($n){
   switch($n){
        case '0':
            $tt="Đơn hàng mới";
            break;
        case '1':
            $tt="Đang xử lí";
            break;
        case '2':
            $tt="Đang giao hàng";
            break;
        case '3':
            $tt="Đã giao hàng";
            break;
        default:
            $tt="Đơn hàng mới";
            break;
   }
   return $tt;
   
}
function update_status($id, $newStatus){
    try {
        $conn = connectdb();
        $sql = "UPDATE tbl_order SET status=:status WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $newStatus, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        // Thực hiện các hành động cần thiết sau khi cập nhật trạng thái
        // Ví dụ: gửi email thông báo hoặc cập nhật trạng thái trên hệ thống khác
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
// Hàm xóa đơn hàng
function delete_bill($id){
    try {
        $conn = connectdb();
        $sql = "DELETE FROM tbl_order WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}

function delete_cart_items($order_id){
    try {
        $conn = connectdb();
        $sql = "DELETE FROM tbl_cart WHERE iddh=:id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $order_id, PDO::PARAM_INT);
        $stmt->execute();
    } catch(PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
function get_sales_data() {
    try {
        $conn = connectdb(); // Hàm kết nối cơ sở dữ liệu
        $query = "
            SELECT 
                DATE_FORMAT(tbl_order.order_date, '%Y-%m') AS month, 
                SUM(tbl_order.tongdonhang) AS total_revenue,
                SUM(tbl_cart.soluong) AS total_quantity
            FROM 
                tbl_order
            LEFT JOIN 
                tbl_cart ON tbl_order.id = tbl_cart.iddh
            WHERE 
                tbl_order.status = 3
            GROUP BY 
                DATE_FORMAT(tbl_order.order_date, '%Y-%m')";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $sales_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sales_data;
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
        return [];
    }
}

?>