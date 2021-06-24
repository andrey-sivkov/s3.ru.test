<?php

/**
 * Транслитерация
 * @param $text
 * @return string
 */
function transliterate($text) {
    $replace = [
        'А'=>'a', 'а'=>'a', 'Б'=>'b', 'б'=>'b', 'В'=>'v', 'в'=>'v', 'Г'=>'g', 'г'=>'g', 'Д'=>'d', 'д'=>'d', 'Е'=>'e', 'е'=>'e',
        'Ё'=>'jo', 'ё'=>'jo', 'Ж'=>'zh', 'ж'=>'zh', 'З'=>'z', 'з'=>'z', 'И'=>'i', 'и'=>'i', 'Й'=>'j', 'й'=>'j', 'К'=>'k', 'к'=>'k',
        'Л'=>'l', 'л'=>'l', 'М'=>'m', 'м'=>'m', 'Н'=>'n', 'н'=>'n', 'О'=>'o', 'о'=>'o', 'П'=>'p', 'п'=>'p', 'Р'=>'r', 'р'=>'r',
        'С'=>'s', 'с'=>'s', 'Т'=>'t', 'т'=>'t', 'У'=>'u', 'у'=>'u', 'Ф'=>'f', 'ф'=>'f', 'Х'=>'h', 'х'=>'h', 'Ц'=>'c', 'ц'=>'c',
        'Ч'=>'ch', 'ч'=>'ch', 'Ш'=>'sh', 'ш'=>'sh', 'Щ'=>'sch', 'щ'=>'sch', 'Ъ'=>'-', 'ъ'=>'-', 'Ы'=>'y', 'ы'=>'y', 'Ь'=>'-', 'ь'=>'-',
        'Э'=>'je', 'э'=>'je', 'Ю'=>'ju', 'ю'=>'ju', 'Я'=>'ja', 'я'=>'ja'
    ];

    return strtr($text, $replaces);
}

/**
 * @param $var
 */
function _dump($var) {
    die('<pre>' . print_r($var, true) . '</pre>');
}
