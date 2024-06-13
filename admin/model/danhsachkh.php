<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh mục Khách hàng</title>
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

    <div class="grid_10">
        <div class="box round"> 
            <h2>Danh Mục tài khoản</h2>
            <div class="block">
                <table class="data display datatable" id="categoryTable">
                    <thead>
                        <tr>
                            <th>Mã tài khoản</th>
                            <th>Tên tài khoản</th>
                            <th>Mật khẩu</th>
                            <th>Vai trò</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu danh mục sẽ được thêm vào đây -->
                        <?php
                             // tăng biến i lên một theo mỗi stt
                            if (isset($listtaikhoan) && (count($listtaikhoan) > 0)) {
                                foreach ($listtaikhoan as $taikhoan) {
                                    echo '<tr>';
                                    echo '<td>' . $taikhoan['id'] . '</td>';
                                    echo '<td>' . $taikhoan['user'] . '</td>';
                                    echo '<td>' . $taikhoan['pass'] . '</td>';
                                    echo '<td>' . $taikhoan['role'] . '</td>';
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
