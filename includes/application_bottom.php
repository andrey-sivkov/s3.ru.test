<?php
// закрываем сессию
session_write_close();

if (function_exists('mysql_close')) mysql_close();
