<?php
// // Đường dẫn đến autoload.php của Composer
// require_once 'D:\xamp\htdocs\Project-daupdate\Project-daupdate\admin\vendor/autoload.php';

// // Sử dụng namespace của Carbon
// use Carbon\Carbon;
// // Thiết lập ngày bắt đầu (365 ngày trước) và ngày hiện tại
// $subdays = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
// $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

// // Truy vấn dữ liệu từ cơ sở dữ liệu
// $sql = "SELECT * FROM tbl_thongke WHERE ngaydat BETWEEN '$subdays' AND '$now' ORDER BY ngaydat ASC";
// $result = mysqli_query($mysqli, $sql);

// $chart_data = array(); // Mảng chứa dữ liệu thống kê

// // Lấy dữ liệu từ kết quả truy vấn và đưa vào mảng $chart_data
// while ($row = mysqli_fetch_array($result)) {
//     $chart_data[] = array(
//         'date' => $row['ngaydat'],
//         'order' => $row['donhang'],
//         'sales' => $row['doanhthu'],
//         'quantity' => $row['soluongban']
//     );
// }

// // Encode dữ liệu thành JSON và đưa ra
// echo json_encode($chart_data);
?>
