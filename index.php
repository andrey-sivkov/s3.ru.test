<?php
require_once('includes/application_top.php');

if (!empty($_POST['get_products'])) {
    $products = Product::getProductsList();
    die(json_encode($products));
} else if ($_POST['make_order']) {
    $result = array('order_id' => Order::createOrder($_POST));
    die(json_encode($result));
}

$page = fetch_to_Smarty(DIR_FS_SMARTY . '/templates/index.tpl');

require_once('includes/application_bottom.php');

die($page);