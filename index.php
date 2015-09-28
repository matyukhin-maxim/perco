<?php

ini_set('display_errors', 1);
set_time_limit(0);
error_reporting(E_ALL);

include_once 'core/CModel.php';
include_once 'core/CController.php';
include_once 'core/Routine.php';

$query = strtolower(rtrim(get_param($_GET, 'url', 'index'), '/'));
$url = explode('/', $query);

mb_internal_encoding("UTF-8");

