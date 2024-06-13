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

    <div class="grid_10">
        <div class="box round first grid">
            <h2>Cập nhật danh mục</h2>
            <?php
                // echo var_dump($kqone);
            ?>
            <div class="block copyblock">
            <?php if ($kqone !== null && count($kqone) > 0): ?>
                <form action="index.php?act=updatedm" method="post">
                    <table class="form">
                    <tr>
                        <td>
                         <input type="text" name="tendm" id="" placeholder="Nhập danh mục sản phẩm" class="medium" value="<?=$kqone[0]['tendm']?>">
                         </td>
                         <td>
                            <input type="hidden" name="id" value="<?=$kqone[0]['id']?>">
                         </td>
                        <td>
                            <input type="submit" name="submit" value="Lưu" >
                         </td>
                    </tr>
                    </table>
                 </form>
<?php else: ?>
    <p>Không tìm thấy danh mục cần cập nhật.</p>
<?php endif; ?>
            </div>
        </div>

        <div class="box round">
            <h2>Danh Mục Sản Phẩm</h2>
            <div class="block">
                <table class="data display datatable" id="categoryTable">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên Danh Mục</th>
                            <th>Ưu tiên</th>
                            <th>Hiển thị</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu danh mục sẽ được thêm vào đây -->
                        <?php
                            $i=1;  // tăng biên' i lên một theo mỗi stt
                            if(isset($kq)&&(count($kq)>0)){
                                foreach($kq as $dm){
                                    echo '<tr>';
                                    echo '<td>'.$i.'</td>';
                                    echo '<td>'.$dm['tendm'].'</td>';
                                    echo '<td>'.$dm['uutien'].'</td>';
                                    echo '<td>'.$dm['hienthi'].'</td>';
                                    echo '<td><a href="index.php?act=updatedm&id='.$dm['id'].'">Sửa</a> | <a href="index.php?act=deletedm&id='.$dm['id'].'">Xóa</a></td>';
                                    echo '</tr>';
                                    $i++;
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
