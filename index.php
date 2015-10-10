<?php

ini_set('display_errors', 1);
set_time_limit(0);
error_reporting(E_ALL ^ E_WARNING);

include_once 'core/CParadox.php';
include_once 'core/CModel.php';
include_once 'core/CController.php';
include_once 'core/Routine.php';

$query = strtolower(rtrim(get_param($_GET, 'url', 'index'), '/'));
$url = explode('/', $query);

mb_internal_encoding("UTF-8");

try {

    // подгружаем все файлы моделей (можено бы было в автолоаде, но фтопку)
    foreach (glob('./models/*.php') as $model) {
        include_once $model;
    }
    
    // load global config
    CController::$cfg = require_once './config/config.php';
    
    $module = $url[0];

    // проверяем сущевствование файла контролера (класса)
    $file = 'controllers/' . ucfirst($module) . 'Controller.php';
    if (!file_exists($file)) {
        throw new Exception("Controller file not found. '$file'");
    }

    // подключаем
    require_once $file;

    $module .= 'Controller';
    if (!class_exists($module)) {
        throw new Exception("Controller '$module' undefined!");
    }
    
    /* @var $ctrl CController */
    $ctrl = new $module();

    // проверим существует ли нужный метод
    $action = get_param($url, 1, 'index');
    $prefix = isAjax() ? 'ajax' : 'action';
    $method = $prefix . ucfirst($action);

    if (!method_exists($ctrl, $method)) {
        throw new Exception("Action '$method' undefined for controller '$module'.");
    }
    
    // передаем параметры
    $ctrl->arguments = array_slice($url, 2);
    
    // и вызываем запрошенное действие
    $ctrl->$method();
    
} catch (Exception $exc) {
    
    echo $exc->getMessage();
    
}
