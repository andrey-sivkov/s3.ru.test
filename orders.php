<?php
require_once('includes/application_top.php');

if (!empty($_POST['get_orders'])) {
    $orders = Order::getOrdersList();
    die(json_encode($orders));
}

$page = fetch_to_Smarty(DIR_FS_SMARTY . '/templates/orders.tpl');

require_once('includes/application_bottom.php');

die($page);