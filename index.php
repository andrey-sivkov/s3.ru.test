<?php
require_once('includes/application_top.php');

// загрузка класса
require_once('includes/classes/Product.php');

$page = fetch_to_Smarty('includes/tpl/index.tpl');

require_once('includes/application_bottom.php');

echo $page;
die;
