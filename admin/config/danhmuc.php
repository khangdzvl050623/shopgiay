<?php
function getall_dm() {
        $conn = connectdb();
        // Truy vấn để lấy tất cả danh mục
        $query = "SELECT * FROM tbl_danhmuc"; // Sửa đổi theo tên bảng thực tế
        $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
        $stmt->execute(); // Thực thi truy vấn
        $kq = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy kết quả
        return $kq; // Trả về kết quả
}

function deldm($id)
{
    $conn = connectdb(); // Kết nối CSDL
    try {
        // Xóa tất cả sản phẩm thuộc danh mục
        $stmt = $conn->prepare("DELETE FROM tbl_sanpham WHERE iddm = ?");
        $stmt->execute([$id]);

        // Xóa danh mục
        $stmt = $conn->prepare("DELETE FROM tbl_danhmuc WHERE id = ?");
        $stmt->execute([$id]);
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // sử dụng để xử lý các ngoại lệ PDO (PHP Data Objects) khi một truy vấn SQL gặp lỗi
    }
}


function getonedm($id){
    $conn = connectdb();
    $query = "SELECT * FROM tbl_danhmuc WHERE id=".$id; // Sửa đổi theo tên bảng thực tế
    $stmt = $conn->prepare($query); // Chuẩn bị truy vấn
    $stmt->execute(); // Thực thi truy vấn
    $kq = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $kq;
}
function update_dm($id, $newValue){
    $conn = connectdb();
    $sql = "UPDATE tbl_danhmuc SET tendm = :tendm WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tendm', $newValue, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}


function themdm($tendm){
    $conn = connectdb();
    $sql = "INSERT INTO tbl_danhmuc (tendm) VALUES ('".$tendm."')";
   $conn->exec($sql);

}
?>