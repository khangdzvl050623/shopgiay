<?php
function connectdb() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "product";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Thiết lập chế độ lỗi để báo cáo lỗi
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
    } catch(PDOException $e) {
        echo "" . $e->getMessage();
        return null;
    }
    return $conn;
}
?>
