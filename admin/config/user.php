<?php
function checkuser($user, $pass) {
    $conn = connectdb();  // Kết nối cơ sở dữ liệu

    if (!$conn) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Tạo chuỗi băm MD5 từ mật khẩu đầu vào
    $hashed_pass = md5($pass);
     
    // Chuẩn bị và thực hiện truy vấn
    $stmt = $conn->prepare("SELECT id, role, pass FROM tbl_user WHERE user = ?");
    $stmt->execute([$user]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);  // Lấy kết quả

    // Kiểm tra kết quả và so sánh mật khẩu
    if ($result && $result['pass'] === $hashed_pass) {
        return $result;  // Trả về mảng chứa role và id nếu đúng
    }

    return false;  // Trả về false nếu sai hoặc không tìm thấy
}

function getall_taikhoan() {
    $conn = connectdb();
    // Truy vấn để lấy tất cả tài khoản
    $sql = "SELECT * FROM tbl_user ORDER BY id DESC"; // Sửa đổi theo tên bảng thực tế
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $listtaikhoan = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $listtaikhoan;
}



?>
