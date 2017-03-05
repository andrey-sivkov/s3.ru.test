<?php
error_reporting(E_ALL & ~E_NOTICE);

// старт сессии
session_start();

// настройки
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/configure.php';
// функции работы с БД
require_once DIR_FS_CATALOG . '/includes/functions/database.php';
// функции работы с Smarty
require_once DIR_FS_CATALOG . '/includes/functions/smarty.php';
// основные функции
require_once DIR_FS_CATALOG . '/includes/functions/general.php';

// инициализация класса Smarty
$smarty = new Smarty();
$smarty->template_dir  = DIR_FS_SMARTY . '/templates';
$smarty->compile_dir   = DIR_FS_SMARTY . '/compile_dir';
$smarty->force_compile = true;

// установка соединения с БД
$DB = DbSimple_Generic::connect('mysql://' . DB_SERVER_USERNAME . ':' . DB_SERVER_PASSWORD . '@' . DB_SERVER . '/' . DB_DATABASE) or die(mysql_error());
