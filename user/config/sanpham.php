<?php
function getall_sanpham($iddm, $page = 1, $items_per_page = 10) {
    $conn = connectdb();

    // Đảm bảo rằng page luôn là số dương và offset không âm
    $page = max(1, intval($page));
    $offset = ($page - 1) * $items_per_page;

    $sql = "SELECT * FROM tbl_sanpham WHERE 1";
    if ($iddm > 0) {
        $sql .= " AND iddm = :iddm";
    }
    $sql .= " ORDER BY id DESC LIMIT :offset, :items_per_page";

    $stmt = $conn->prepare($sql);
    if ($iddm > 0) {
        $stmt->bindParam(':iddm', $iddm, PDO::PARAM_INT);
    }
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function get_total_products($iddm = 0) {
    $conn = connectdb();
    $sql = "SELECT COUNT(*) as total FROM tbl_sanpham WHERE 1";
    if ($iddm > 0) {
        $sql .= " AND iddm = :iddm";
    }
    $stmt = $conn->prepare($sql);
    if ($iddm > 0) {
        $stmt->bindParam(':iddm', $iddm, PDO::PARAM_INT);
    }
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}



function getonesp($id){
    $conn = connectdb();
    $query = "SELECT * FROM tbl_sanpham WHERE id=".$id; // Sửa đổi theo tên bảng thực tế
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}

function get_sanpham_by_danhmuc($iddm) {
    $conn = connectdb();
    $sql = "SELECT * FROM tbl_sanpham WHERE iddm = ?"; // Truy vấn dựa trên ID danh mục
    $stmt = $conn->prepare($sql);
    $stmt->execute([$iddm]); // Thực hiện truy vấn với tham số
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách sản phẩm
}

function get_sanpham_by_keyword($keyword, $page, $items_per_page) {
    $conn = connectdb();
    $offset = ($page - 1) * $items_per_page;

    $sql = "SELECT * FROM tbl_sanpham WHERE tensp LIKE :keyword LIMIT :offset, :items_per_page";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
    
    if (!$stmt->execute()) {
        // In lỗi nếu có bất kỳ lỗi nào xảy ra
        var_dump($stmt->errorInfo());
        return false;
    }

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

   

    return $result;
}


?>
