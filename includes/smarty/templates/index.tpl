<!doctype html>
<html>
<head>
    <title>Products</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/bootstrap-table.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-table.js"></script>
</head>
<body id="top" class="page">
<div class="header"></div>
<div class="content" style="width: 50%; margin: auto;">
    <table id="products-table" data-pagination="true" class="">
        <thead>
            <tr>
                <th data-field="id" class="id_column">#</th>
                <th data-field="name" data-sortable="true">Наименование</th>
                <th data-field="price" data-sortable="true" data-formatter="priceFormatter">Цена</th>
                <th data-field="phone_number" data-formatter="buyFormatter">Купить</th>
            </tr>
        </thead>
    </table>
</div>
<div class="footer"></div>
<script>
    $(document).ready(function() {
        $('#products-table').bootstrapTable({
            url:             '/',
            method:          'post',
            queryParams:     { get_products: 1 },
            queryParamsType: 'limit',
            contentType:     'application/x-www-form-urlencoded',
            uniqueId:        'id',
            pageSize:        5,
            pageList:        [5, 10, 50, 'All'],
            sortName:        'id',
            formatRecordsPerPage: function (a) {
                return a +" товаров на странице";
            },
            formatShowingRows: function (a, b, d) {
                return "Показано с " + a + " по " + b + " из " + d + " товаров";
            },
            formatDetailPagination: function (a) {
                return "показано " + a + " товаров";
            }
        });
    });

    function priceFormatter(value) {
        return Number(value).toLocaleString() + ' руб.';
    }

    function buyFormatter(value, row) {
        return Number(value).toLocaleString() + ' руб.';
    }
</script>
</body>
</html>