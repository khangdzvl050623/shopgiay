<?php
function getall_sp() {
    $conn = connectdb();
    // Truy vấn để lấy tất cả danh mục
    $query = "SELECT * FROM tbl_sanpham"; // Sửa đổi theo tên bảng thực tế
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy kết quả
    return $kq; // Trả về kết quả
}

// Function to insert a product
function insert_sanpham($iddm, $tensp, $img, $gia, $detail) {
    $conn = connectdb();
    $sql = "INSERT INTO tbl_sanpham (iddm, tensp, img, gia, detail) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$iddm, $tensp, $img, $gia, $detail]);
    return $conn->lastInsertId();
}



function getonesp($id){
    $conn = connectdb();
    $query = "SELECT * FROM tbl_sanpham WHERE id=".$id; // Sửa đổi theo tên bảng thực tế
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}

function updatesp($id, $iddm, $tensp, $img, $gia, $detail) {
    $conn = connectdb();

    try {
        if ($img != "") {
            $sql = "UPDATE tbl_sanpham 
                    SET iddm = ?, tensp = ?, img = ?, gia = ?, detail = ?
                    WHERE id = ?";
            $params = [$iddm, $tensp, $img, $gia, $detail, $id];
        } else {
            $sql = "UPDATE tbl_sanpham 
                    SET iddm = ?, tensp = ?, gia = ?, detail = ?
                    WHERE id = ?";
            $params = [$iddm, $tensp, $gia, $detail, $id];
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        return true;
    } catch (PDOException $e) {
        echo "Error updating product: " . $e->getMessage();
        return false;
    }
}

function deletesp($id) {
    $conn = connectdb();
    
    // Bắt đầu một giao dịch
    $conn->beginTransaction();
    
    try {
        // Xóa tất cả các hàng liên quan trong tbl_cart
        $sqlCart = "DELETE FROM tbl_cart WHERE idpro=?";
        $stmtCart = $conn->prepare($sqlCart);
        $stmtCart->execute([$id]);
        
        // Xóa sản phẩm
        $sqlProduct = "DELETE FROM tbl_sanpham WHERE id=?";
        $stmtProduct = $conn->prepare($sqlProduct);
        $stmtProduct->execute([$id]);
        
        // Commit giao dịch
        $conn->commit();
        
        return true;
    } catch (PDOException $e) {
        // Rollback giao dịch nếu có lỗi
        $conn->rollBack();
        echo "Lỗi khi xóa sản phẩm: " . $e->getMessage();
        return false;
    }
}



?>