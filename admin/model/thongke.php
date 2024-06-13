<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê</title>
    <!-- Include thư viện jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include thư viện Morris.js -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>
<body>
    <h1>Thống kê</h1>
    <div id="chart"></div> <!-- Đây là nơi hiển thị biểu đồ -->

    <script>
    // Khi trang được tải hoàn tất
    $(document).ready(function() {
        // Hàm thực hiện yêu cầu AJAX để lấy dữ liệu thống kê
        function thongke() {
            $.ajax({
                url: "../config/thongke.php", // URL của trang thongke.php
                method: "POST",
                dataType: "json",
                success: function(data) {
                    // Khởi tạo biểu đồ Morris.Area với dữ liệu được trả về từ Ajax
                    var chart = new Morris.Area({
                        element: 'chart',
                        xkey: 'date',
                        ykeys: ['order', 'sales', 'quantity'],
                        labels: ['Đơn hàng', 'Doanh thu', 'Số lượng bán ra'],
                        data: data // Dữ liệu từ Ajax
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error); // Xử lý lỗi nếu có
                }
            });
        }

        // Gọi hàm thongke để lấy dữ liệu và vẽ biểu đồ khi trang được tải
        thongke();
    });
    </script>
</body>
</html>
