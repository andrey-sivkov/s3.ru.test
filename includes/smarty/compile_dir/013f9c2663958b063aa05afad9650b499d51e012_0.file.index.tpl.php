<?php
/* Smarty version 3.1.30, created on 2017-03-05 21:43:44
  from "D:\xampp\htdocs\s3.ru.test\includes\smarty\templates\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58bc78800512a2_36187713',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '013f9c2663958b063aa05afad9650b499d51e012' => 
    array (
      0 => 'D:\\xampp\\htdocs\\s3.ru.test\\includes\\smarty\\templates\\index.tpl',
      1 => 1488746618,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58bc78800512a2_36187713 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html>
<head>
    <title>Products</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link href="/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/css/bootstrap-table.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons" />
    <?php echo '<script'; ?>
 src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/js/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/js/bootstrap-table.js"><?php echo '</script'; ?>
>
</head>
<body id="top" class="page">
<div class="header"></div>
<div class="content" style="width: 50%; margin: auto;">
    <table id="products-table" data-pagination="true" class="">
        <thead>
            <tr>
                <th data-field="id">#</th>
                <th data-field="name" data-sortable="true">Наименование</th>
                <th data-field="price" data-sortable="true" data-formatter="priceFormatter">Цена</th>
                <th data-field="phone_number" data-formatter="buyFormatter">Купить</th>
            </tr>
        </thead>
    </table>
</div>
<div class="footer"></div>
<?php echo '<script'; ?>
>
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

    $(document).on('click', 'button.btn-buy', function() {
        var product_id = $(this).data('id');
        var product_name = $(this).data('content');
        $('#modal-popup').find('.modal-title').text('Купить ' + product_name);
        $('#modal-popup').find('select').attr('name', 'products[' + product_id + ']');
        $('#modal-popup').modal();
    });

    $(document).on('submit', '#modal-form', function (e) {
        e.preventDefault();
        if (!$('input[name=customer_name]').val().trim()) {
            $('input[name=customer_name]').parent().toggleClass('has-error');
        } else if (!$('input[name=customer_email]').val().trim()) {
            $('input[name=customer_email]').parent().toggleClass('has-error');
        } else if (!$('textarea[name=customer_address]').val().trim()) {
            $('textarea[name=customer_address]').parent().addClass('has-error');
        } else {
            $.post('/', $(this).serialize() + '&make_order=1', function (data) {
                $('#modal-popup').modal('hide');
                alert('Ваш заказ #' + data['order_id'] + ' успешно принят.');
            }, 'json');
        }
        return false;
    });

    function priceFormatter(value) {
        return Number(value).toLocaleString() + ' руб.';
    }

    function buyFormatter(value, row) {
        return '<button type="button" class="btn btn-info btn-sm btn-buy" data-toggle="modal" data-target="modal-popup" data-content="' + row['name'] + '" data-id="' + row['id'] + '">Купить</button>';
    }
<?php echo '</script'; ?>
>

<div class="modal fade" tabindex="-1" id="modal-popup">
    <div class="modal-dialog">
        <form id="modal-form" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Купить</h4>
                </div>
                <div class="modal-body">
                    <p>
                        Выберите кол-во:
                        <select class="form-control" name="">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </p>
                    <p><input type="text" name="customer_name" class="form-control" value="" placeholder="Ваше имя"></p>
                    <p><input type="text" name="customer_email" class="form-control" value="" placeholder="Контактный e-mail"></p>
                    <p><textarea name="customer_address" class="form-control" placeholder="Адрес доставки"></textarea></p>
                    <p><textarea name="comments" class="form-control" placeholder="Комментарии к заказу"></textarea></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <input type="submit" class="btn btn-info" name="make_order" value="Сделать заказ">
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html><?php }
}
