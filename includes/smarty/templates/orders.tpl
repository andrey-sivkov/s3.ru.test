<!doctype html>
<html>
<head>
    <title>Заказы</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="./css/bootstrap.min.css" rel="stylesheet" />
    <link href="./css/bootstrap-table.min.css" rel="stylesheet" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/bootstrap-table.js"></script>
</head>
<body id="top" class="page">
<div class="header"></div>
<div class="content" style="width: 50%; margin: auto;">
    {if $smarty.get.id}
    <form id="order-form">
        <input type="hidden" name="order_id" value="{$smarty.get.id}">
        <table class="table" width="100%">
            <thead>
            <tr>
                <th colspan="2">Заказ #{$smarty.get.id} от {date('d.m.Y H:i', $order.date_added|strtotime)}</th>
            </tr>
            </thead>
            <tr>
                <td>Покупатель:</td>
                <td><input type="text" name="customer_name" class="form-control" value="{$order.customer_name}"></td>
            </tr>
            <tr>
                <td>E-mail:</td>
                <td><input type="text" name="customer_email" class="form-control" value="{$order.customer_email}"></td>
            </tr>
            <tr>
                <td>Адрес доставки:</td>
                <td><textarea class="form-control" style="height: 50px" name="customer_address">{$order.customer_address|nl2br}</textarea></td>
            </tr>
        </table>
        <table class="table" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Цена</th>
                <th>Кол-во</th>
            </tr>
            </thead>
            {foreach from=$order.products item=v key=k}
            <tr>
                <td>{$k + 1}</td>
                <td>{$v.product_name}</td>
                <td><input type="text" class="form-control" name="products[{$v.id}][price]" value="{$v.product_price}" style="width: 80px;" maxlength="6"></td>
                <td><input type="text" class="form-control" name="products[{$v.id}][quantity]" value="{$v.product_quantity}" style="width: 40px;" maxlength="1"></td>
            </tr>
            {/foreach}
        </table>
        <table class="table" width="100%">
            <thead>
            <tr>
                <th>Изменить статус</th>
                <th>Оставить комментарий</th>
            </tr>
            </thead>
            <tr>
                <td>
                    <select class="form-control" name="order_status_id">
                        {foreach from=$orders_statuses item=v key=k}
                            <option value="{$k}"{if $k==$order.status.status_id} selected{/if}>{$v}</option>
                        {/foreach}
                    </select>
                </td>
                <td><textare class="form-control" style="height: 50px" name="comments" placeholder="Оставьте здесь ваши комментарии"></textare></td>
            </tr>
        </table>
        <div style="text-align: right;">
            <button class="btn btn-default btn-cancel">Отменить</button>
            <input type="submit" class="btn btn-info" name="save" value="Сохранить изменения">
        </div><br>
        <table class="table" width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>Дата / время</th>
                <th>Статус</th>
                <th>Комментрий</th>
            </tr>
            </thead>
            {foreach from=$order.history item=v key=k}
            <tr>
                <td>{$k + 1}</td>
                <td>{date('d.m.Y H:i', $v.date_added|strtotime)}</td>
                <td>{$v.status}</td>
                <td>{$v.comments|nl2br}</td>
            </tr>
            {/foreach}
        </table>
    </form>
    <script>
        $(document).ready(function() {
            $('button.btn-cancel').click(function () {
                window.location.href = './orders.php';
            });

            $('#order-form').submit(function (e) {
                e.preventDefault();
                $.post('./orders.php', $(this).serialize(), function (result) {
                    if (result['result']) {
                        alert('Заказ успешно обновлен!');
                        window.location.href = './orders.php';
                    } else {
                        alert('При обновлении заказа произошла ошибка!');
                    }
                }, 'json');
            });
        });
    </script>
    {else}
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
    <script>
        $(document).ready(function() {
            $('#orders-table').bootstrapTable({
                url:             './orders.php',
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
            return '<a href="./orders.php?id=' + row['id'] + '">' + value + '</a>';
        }

        function priceFormatter(value) {
            return Number(value).toLocaleString() + ' руб.';
        }

        function dateFormatter(value) {
            return value.replace(/^(\d+)\-(\d+)\-(\d+) (.*)$/, '$3.$2.$1 $4');
        }
    </script>
    {/if}
</div>
<div class="footer"></div>
</body>
</html>