<?php
require_once DIR_FS_CATALOG . '/includes/classes/DbSimple/Generic.php';

/**
 * @param $function
 * @param $args
 * @return mixed
 */
function load_function_db($function, $args = array()) {
    global $DB;
    return call_user_func_array(array(&$DB, $function), $args);
}

/**
 * выборка всего результата таблицы
 * @return mixed
 */
function select_to_DB() {
    $args = func_get_args();
    return load_function_db('select', $args);
}

/**
 * выборка строки таблицы
 * @return mixed
 */
function select_row_to_DB() {
    $args = func_get_args();
    return load_function_db('selectRow', $args);
}

/**
 * выборка одной страницы
 * @param $sql
 * @param $total
 * @param $page_offset
 * @param $number_row_page
 * @return mixed
 */
function select_page_to_DB($sql, &$total, $page_offset, $number_row_page = 10) {
    $rows = load_function_db('selectPage', array(&$total, "$sql limit $page_offset, $number_row_page"));
    return $rows;
}

/**
 * выборка столбца таблицы
 * @return mixed
 */
function select_col_to_DB() {
    $args = func_get_args();
    return load_function_db('selectCol', $args);
}

/**
 * выборка одной ячейки таблицы
 * @return mixed
 */
function select_cell_to_DB() {
    $args = func_get_args();
    return load_function_db('selectCell', $args);
}

/**
 * добавление в таблицу БД
 * @param $table
 * @param $array
 * @return mixed
 */
function insert_to_DB($table, $array) {
    global $DB;
    return $DB->query('insert into ' . $table . ' (?#) values (?a)', array_keys($array), array_values($array));
}

/**
 * обновление данных в таблице БД
 * @param $table
 * @param $array
 * @param $where
 * @return mixed
 */
function update_to_DB($table, $array, $where) {
    global $DB;
    $where_str = '';
    if (is_array($where)) {
        foreach($where as $k=>$v) $where_str .= ($where_str ? ' and' : '') . " `" . addslashes($k) . "` = '" . addslashes($v) . "'";
    } else {
        $where_str .= $where;
    }
    return $DB->query("update $table set ?a where " . $where_str, $array);
}

/**
 * выборка нового id в таблице
 * @param $table
 * @return int
 */
function new_id($table) {
    return (int)select_cell_to_DB('select max(id) from ' . $table) + 1;
}

/**
 * подсчет всего количества ячеек в таблице
 * @param $table
 * @param $where
 * @return mixed
 */
function count_cell($table, $where = false) {
    return select_row_to_DB('select count(*) from ' . $table . ($where ? ' where ' . $where : ''));
}

/**
 * выборка всего результата таблицы
 * @return mixed
 */
function query_to_DB() {
    $args = func_get_args();
    return load_function_db('query', $args);
}

