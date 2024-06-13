<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
    <link rel="stylesheet" href="path/to/your/css/file.css"> <!-- Đường dẫn đến file CSS của bạn -->
</head>
<body>
    <h1>Chi tiết đơn hàng</h1>
    <table>
        <thead>
            <tr>
                <th>ID đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Số lượng đặt hàng</th>
                <th>Giá</th>
                <th>Tình trạng đơn hàng</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (is_array($listbill)){
                foreach ($listbill as $bill) {
                    extract($bill);
                    $ttdh = get_ttdh($bill['status']);
                    $countsp = loadall_cart_count($bill['id']);
                    echo '<tr>
                        <td>' . htmlspecialchars($bill['id']) . '</td>
                        <td>' . htmlspecialchars($bill['order_date']) . '</td>
                        <td>' . htmlspecialchars($countsp) . '</td>
                        <td>' . htmlspecialchars($bill['tongdonhang']) . '</td>
                        <td>' . htmlspecialchars($ttdh) . '</td>
                    </tr>';
                }
            }
        ?>
        </tbody>
    </table>
</body>
</html>
