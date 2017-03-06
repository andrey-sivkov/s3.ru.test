<?php
require_once('includes/application_top.php');

if (!empty($_POST['get_orders'])) {
    $orders = Order::getOrdersList();
    die(json_encode($orders));
} else if (!empty($_POST['order_id'])) {
    $result = Order::updateOrder($_POST, $_POST['order_id']);
    die(json_encode(array('result' => $result)));
}

if (!empty($_GET['id'])) {
    assign_to_Smarty('order', Order::getOrderInfo($_GET['id']));
    assign_to_Smarty('orders_statuses', Order::getOrdersStatusesList());
}

$page = fetch_to_Smarty(DIR_FS_SMARTY . '/templates/orders.tpl');

require_once('includes/application_bottom.php');

die($page);