<?php

error_reporting(E_ALL & ~E_NOTICE);

// старт сессии
session_start();

// настройки
require_once 'includes/configure.php';
// основные функции
require_once 'includes/functions/general.php';
// класс Smarty
require_once 'includes/classes/Smarty/Smarty.class.php';
// класс DbSimbple
require_once 'includes/classes/DbSimple/Generic.php';
// класс Product
require_once 'includes/classes/Product.php';
// класс Order
require_once 'includes/classes/Order.php';

// инициализация класса Smarty
$Smarty = new Smarty();
$Smarty->setTemplateDir('includes/smarty/templates')
  ->setCompileDir('includes/smarty/compile_dir')
  ->setForceCompile(true);

// установка соединения с БД
$DB = @DbSimple_Generic::connect('mysqli://' . DB_SERVER_USERNAME . ':' . DB_SERVER_PASSWORD . '@' . DB_SERVER . '/' . DB_DATABASE);
if ($DB->error['code'])
  die($DB->error['message']);
