<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục hàng hóa</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .grid_10 {
            width: 80%;
            margin: 0 auto;
        }

        .box {
            background: #fff;
            border-radius: 6px;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
            -moz-box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
            -webkit-box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
        }

        .round {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .first {
            margin-top: 20px;
        }

        .grid {
            margin-bottom: 20px;
        }

        h2 {
            margin: 0 0 10px;
        }

        .block {
            padding: 10px;
        }

        .copyblock {
            padding: 20px;
        }

        .form {
            width: 100%;
        }

        .medium {
            width: 100%;
            padding: 7px;
        }

        .data {
            width: 100%;
            border-collapse: collapse;
        }

        .data th {
            background: #F5F5F5;
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .data td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
        }

        .datatable {
            width: 100%;
            margin-top: 20px;
        }
    </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục đơn hàng</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="grid_10">
        <div class="box round">
            <h2>Danh Mục Đơn Hàng</h2>
            <div class="block">
                <table class="data display datatable" id="categoryTable">
                    <thead>
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Tên khách hàng</th>
                            <th>Tổng giá trị đơn hàng</th>
                            <th>Tình trạng đơn hàng</th>
                            <th>Chi tiết</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if (isset($listbill) && count($listbill) > 0) {
                            foreach ($listbill as $bill) {
                                echo '<tr>';
                                echo '<td>' . $bill['madh'] . '</td>';
                                echo '<td>' . $bill['hoten'] . '</td>';
                                echo '<td>' . number_format($bill['tongdonhang'], 0, ',', '.') . ' VND</td>';
                                echo '<td>' . get_ttdh($bill['status']) . '</td>'; // gọi hàm get_ttdh
                                echo '<td><a href="index.php?act=orderdetail&iddh=' . $bill['id'] . '">Xem chi tiết</a></td>';
                                echo '<td>';
                                // Thêm form để cập nhật trạng thái đơn hàng
                                echo '<form action="index.php?act=updatestatus" method="post">';
                                echo '<input type="hidden" name="id" value="' . $bill['id'] . '">';
                                echo '<select name="newstatus">';
                                echo '<option value="0">Đơn hàng mới</option>';
                                echo '<option value="1">Đang xử lí</option>';
                                echo '<option value="2">Đang giao hàng</option>';
                                echo '<option value="3">Đã giao hàng</option>';
                                echo '</select>';
                                echo '<input type="submit" name="updatestatus" value="Cập nhật">';
                                echo '</form>';
                               
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

