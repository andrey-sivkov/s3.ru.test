<!doctype html>
<html>
<head>
    <title>Заказы</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/bootstrap-table.min.css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-table.js"></script>
</head>
<body id="top" class="page">
<div class="header"></div>
<div class="content" style="width: 50%; margin: auto;">
    <table id="orders-table" data-pagination="true">
        <thead>
            <tr>
                <th data-field="id" data-sortable="true">#</th>
                <th data-field="customer_name" data-sortable="true" data-formatter="customerFormatter">Покупатель</th>
                <th data-field="total_sum" data-sortable="true" data-formatter="priceFormatter">Сумма</th>
                <th data-field="date_added" data-sortable="true" data-formatter="dateFormatter">Дата</th>
                <th data-field="status" data-sortable="true">Статус</th>
            </tr>
        </thead>
    </table>
</div>
<div class="footer"></div>
<script>
    $(document).ready(function() {
        $('#orders-table').bootstrapTable({
            url:             '/orders.php',
            method:          'post',
            queryParams:     { get_orders: 1 },
            queryParamsType: 'limit',
            contentType:     'application/x-www-form-urlencoded',
            uniqueId:        'id',
            pageSize:        5,
            pageList:        [5, 10, 50, 'All'],
            sortName:        'id',
            sortOrder:       'desc',
            formatRecordsPerPage: function (a) {
                return a +" заказов на странице";
            },
            formatShowingRows: function (a, b, d) {
                return "Показано с " + a + " по " + b + " из " + d + " заказов";
            },
            formatDetailPagination: function (a) {
                return "показано " + a + " заказов";
            }
        });
    });

    function customerFormatter(value, row) {
        return '<a href="/orders.php?id=' + row['id'] + '">' + value + '</a>';
    }

    function priceFormatter(value) {
        return Number(value).toLocaleString() + ' руб.';
    }

    function dateFormatter(value) {
        return value.replace(/^(\d+)\-(\d+)\-(\d+) (.*)$/, '$3.$2.$1 $4');
    }
</script>
</body>
</html>