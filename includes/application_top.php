<?php

error_reporting(E_ALL & ~E_NOTICE);

// старт сессии
session_start();

// настройки
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/configure.php';
// основные функции
require_once DIR_FS_CATALOG . '/includes/functions/general.php';
// класс Product
require_once DIR_FS_CATALOG . '/includes/classes/Product.php';
// класс Order
require_once DIR_FS_CATALOG . '/includes/classes/Order.php';

// инициализация класса Smarty
$Smarty = new Smarty();
$Smarty->setTemplateDir(DIR_FS_SMARTY . '/templates')
  ->setCompileDir(DIR_FS_SMARTY . '/compile_dir')
  ->setForceCompile(true);

// установка соединения с БД
$DB = DbSimple_Generic::connect('mysql://' . DB_SERVER_USERNAME . ':' . DB_SERVER_PASSWORD . '@' . DB_SERVER . '/' . DB_DATABASE);
if ($DB->error['code'])
  die($DB->error['message']);
