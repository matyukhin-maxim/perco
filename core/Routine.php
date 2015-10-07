<?php

/**
 * Get some value from input array
 * by key, or self $source, if key is null
 * if source[key] is undefined then deturn default value
 * 
 * @param mixed $source
 * @param string|null $key
 * @param mixed $def
 * @return mixed
 */
function get_param(& $source, $key = null, $def = false) {
    if ($key === null) {
        return isset($source) ? $source : $def;
    }
    return isset($source[$key]) ? $source[$key] : $def;
}

/**
 * Change codepege
 * 
 * @param string $value
 */
function charsetChange(&$value) {
    $type = gettype($value);
    if ($type === 'string')
        $value = mb_convert_encoding($value, 'UTF-8', 'Windows-1251');
}

function trimHereDoc($txt) {
    // разбиваем текст по строками, и удаляем пробелы в каждой
    // т.к. при копипасте с word`а нсс копируют ТАБы
    return implode("\n", array_map('trim', explode("\n", $txt)));
}

/**
 * Check that incoming request is POST method (form or ajax)
 * 
 * @return boolean
 */
function isPOST() {
    return get_param($_SERVER, 'REQUEST_METHOD') === 'POST';
}

/**
 * little check for CController
 * diffrent actions will be run depends of this func
 * 
 * @return boolean
 */
function isAjax() {
    return get_param($_SERVER, 'HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
}

/**
 * turn input parameter(string) into mysql like-string
 * 'blah blah' => '%blah blah%'
 * 
 * @param string $value
 * @return string
 */
function toLike($value) {
    
    $ans = '%';
    $type = gettype($value);
    switch ($type) {
        case 'string':

            if (!empty($value)) {
                $ans .= "$value%";
            }
            break;

        default:
            break;
    }
    return $ans;
}

/**
 * 
 * convert text string from DOS codepage into UTF
 * 
 * @param string $text
 * @return string
 */
function d2u($text) {
    return iconv('cp866', 'utf-8', $text);
}