<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2; /* Màu nền xám nhạt */
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff; /* Màu nền trắng */
            border-radius: 6px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h2 {
            margin: 0 0 20px;
            color: #333; /* Màu chữ đen */
        }

        p {
            margin: 0 0 10px;
            color: #666; /* Màu chữ xám */
        }

        ul {
            padding-left: 20px;
            margin: 0;
        }

        li {
            list-style-type: none;
            margin-bottom: 5px;
            color: #666; /* Màu chữ xám */
        }

        a {
            color: #007bff; /* Màu chữ xanh dương */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Chi Tiết Đơn Hàng</h2>
        <?php
        // Hiển thị thông tin chi tiết đơn hàng
        if(isset($orderDetail) && !empty($orderDetail)) {
            echo '<p>Mã đơn hàng: ' . $orderDetail['madh'] . '</p>';
            echo '<p>Tên khách hàng: ' . $orderDetail['hoten'] . '</p>';
            echo '<p>Địa chỉ: ' . $orderDetail['address'] . '</p>';
            echo '<p>Điện thoại: ' . $orderDetail['tel'] . '</p>';
            echo '<p>Email: ' . $orderDetail['email'] . '</p>';
          
            // Sử dụng switch case để hiển thị phương thức thanh toán
            echo '<p>Phương thức thanh toán: ';
            switch($orderDetail['pttt']) {
                case '1':
                    echo 'Thanh toán khi nhận hàng';
                    break;
                case '2':
                    echo 'Chuyển khoản ngân hàng';
                    break;
                case '3':
                    echo 'Chuyển khoản momo';
                    break;
                case '4':
                    echo 'Thanh toán khác';
                    break;
                default:
                    echo 'Quý khách chưa chọn phương thức thanh toán';
                    break;
            }
            echo '</p>';

            echo '<p>Tổng giá trị đơn hàng: ' . number_format($orderDetail['tongdonhang'], 0, ',', '.') . ' VND</p>';
            echo '<p>Thời gian đặt hàng: ' . $orderDetail['order_date'] . '</p>';
            // Hiển thị danh sách sản phẩm trong đơn hàng
            // Ví dụ: get_order_items là hàm để lấy danh sách sản phẩm trong đơn hàng từ cơ sở dữ liệu
            $orderItems = get_order_items($orderDetail['id']);
            if($orderItems) {
                echo '<h3>Danh sách sản phẩm:</h3>';
                echo '<ul>';
                foreach($orderItems as $item) {
                    echo '<li>' . $item['tensp'] . ' - Số lượng: ' . $item['soluong'] . '</li>';
                }
                echo '</ul>';
            } else {
                echo 'Không có sản phẩm trong đơn hàng.';
            }
        } else {
            echo 'Không tìm thấy chi tiết đơn hàng.';
        }
        ?>
    </div>

</body>
</html>
