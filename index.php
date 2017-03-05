<?php

require_once('includes/application_top.php');

$page = fetch_to_Smarty(DIR_FS_SMARTY . '/templates/index.tpl');

require_once('includes/application_bottom.php');

die($page);