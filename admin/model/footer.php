<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
        // Lấy dữ liệu từ PHP và truyền vào JavaScript
        var salesData = <?php echo json_encode($sales_data); ?>;
        
        // Tạo biểu đồ sử dụng Morris.js
        new Morris.Line({
            element: 'myfirstchart',
            data: salesData,
            xkey: 'month',
            ykeys: ['total_revenue', 'total_quantity'],
            labels: ['Doanh thu', 'Số lượng'],
            xLabelFormat: function (x) { // Định dạng nhãn trục X thành tháng năm
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var month = x.getMonth();
                var year = x.getFullYear();
                return monthNames[month] + ' ' + year;
            },
            dateFormat: function (x) { // Định dạng ngày tháng hiển thị khi di chuột
                var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                var month = new Date(x).getMonth();
                var year = new Date(x).getFullYear();
                return monthNames[month] + ' ' + year;
            }
        });
    </script>
</body>

<p>bàn chân</p>
</html>