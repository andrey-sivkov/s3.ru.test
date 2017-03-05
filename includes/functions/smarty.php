<?php
// загрузка библиотеки Smarty
require_once DIR_FS_CATALOG . '/includes/classes/Smarty/Smarty.class.php';

/**
 * инициализация переменной для шаблонов Smarty
 * @param $value
 * @param $variable
 */
function assign_to_Smarty($value, $variable){
    global $smarty;
    if(is_array($value)) foreach($value as $k=>$v) assign_to_Smarty($k, $v);
    return $smarty->assign($value, $variable);
}

/**
 * возвращает вывод шаблона вместо его отображения на экран
 * @param $src
 * @return mixed
 */
function fetch_to_Smarty($src){
    global $smarty;
    return $smarty->fetch($src);
}

/**
 * отображает шаблон Smarty
 * @param $src
 */
function display_to_Smarty($src){
    global $smarty;
    return $smarty->display($src);
}

/**
 * добавляет элемент к назначенному массиву
 * @param $key
 * @param bool $item
 */
function append_to_Smarty($key, $item = false) {
    global $smarty;
    if ($item) return $smarty->append($key, $item);
    else return $smarty->append($key);
}

/**
 * выводит все параметры инициализированных для Smarty
 * @return array
 */
function get_vars_template_out_Smarty() {
    global $smarty;
    return $smarty->get_template_vars();
}

/**
 * очистка переменной/ых инициализированных в Smarty
 * @param string $variable
 */
function clear_assign_of_Smarty($variable = 'all') {
    global $smarty;
    if ($variable == 'all') $smarty->clear_all_assign();
    else $smarty->clear_assign($variable);
}

/**
 * регистрация фунций в Smarty
 * @param $name_function_to_Smarty
 * @param $name_function
 */
function register_function_to_Smarty($name_function_to_Smarty,$name_function){
    global $smarty;
    $smarty->register_function($name_function_to_Smarty,$name_function);
}

/**
 * проверка шаблона
 * @param $template
 * @return bool
 */
function exist_template($template) {
    global $smarty;
    return $smarty->template_exists($template);
}
