<?php

function get_param(& $source, $key = null, $def = false) {
    if ($key === null) {
        return isset($source) ? $source : $def;
    }
    return isset($source[$key]) ? $source[$key] : $def;
}

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

function isPOST() {
    return get_param($_SERVER, 'REQUEST_METHOD') === 'POST';
}

function isAjax() {
    return get_param($_SERVER, 'HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest';
}

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