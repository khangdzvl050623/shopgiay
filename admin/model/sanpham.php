<div class="row">
    <div class="box round first grid">
        <h2>Sản Phẩm</h2>
        <div class="block copyblock">
            <form action="index.php?act=sanpham_add" method="post" enctype="multipart/form-data">
                <select name="iddm" id="">
                    <option value="0">Chọn danh mục</option>
                    <?php
                    if (isset($dsdm) && count($dsdm) > 0) {
                        foreach ($dsdm as $dm) {
                            echo '<option value="' . $dm['id'] . '">' . $dm['tendm'] . '</option>';
                        }
                    } else {
                        echo '<option value="">Không có danh mục nào</option>';
                    }
                    ?>
                </select>
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="tensp" id="" placeholder="Nhập tên sản phẩm" class="medium">
                        </td>
                        <td>
                            <input type="file" name="img" id="">
                        </td>
                        <td>
                            <input type="text" name="gia" id="" placeholder="Nhập giá sản phẩm">
                        </td>
                        <td>
                            <textarea name="detail" id="" placeholder="Nhập mô tả sản phẩm" class="medium"></textarea>
                        </td>
                        <td>
                            <input type="submit" name="submit" value="Lưu">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="box round">
        <h2>Sản Phẩm</h2>
        <div class="block">
            <table class="data display datatable" id="categoryTable">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Hình</th>
                        <th>Giá</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1; // Tăng biến $i lên một theo mỗi STT
                    if (isset($kq) && count($kq) > 0) {
                        foreach ($kq as $sp) {
                            echo '<tr>';
                            echo '<td>' . $i . '</td>';
                            echo '<td>' . $sp['tensp'] . '</td>';
                            echo '<td><img src="'. $sp['img'] .'" width"80px"></td>';
                            echo '<td>' . $sp['gia'] . '</td>';
                            echo '<td>' . $sp['detail'] . '</td>';
                            echo '<td><a href="index.php?act=updatesp&id=' . $sp['id'] . '">Sửa</a> | <a href="index.php?act=deletesp&id=' . $sp['id'] . '">Xóa</a></td>';
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
